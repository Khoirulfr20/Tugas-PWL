<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Halaman utama laporan
     */
    public function index()
    {
        // Statistik untuk dashboard laporan
        $stats = [
            'total_patients' => Patient::count(),
            'today_visits' => Queue::whereDate('created_at', today())->count(),
            'this_month_visits' => Queue::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count(),
        ];

        // Ambil semua pasien untuk dropdown
        $patients = Patient::orderBy('name')->get();

        return view('reports.index', compact('stats', 'patients'));
    }

    /**
     * Laporan harian
     */
    public function daily(Request $request)
    {
        // Ambil tanggal dari request, default hari ini
        $date = $request->input('date', now()->format('Y-m-d'));

        // Validasi format tanggal
        try {
            $parsedDate = Carbon::parse($date);
        } catch (\Exception $e) {
            $parsedDate = now();
            $date = $parsedDate->format('Y-m-d');
        }

        // Ambil data kunjungan (queues) pada tanggal tersebut
        $visits = Queue::whereDate('created_at', $date)
            ->with('patient') // eager loading
            ->orderBy('created_at', 'asc')
            ->get();

        // Hitung statistik
        $stats = [
            'total_visits' => $visits->count(),
            'completed' => $visits->where('status', 'completed')->count(),
            'cancelled' => $visits->where('status', 'cancelled')->count(),
            'in_progress' => $visits->where('status', 'in_progress')->count(),
            'waiting' => $visits->where('status', 'waiting')->count(),
        ];

        return view('reports.daily', compact('date', 'visits', 'stats'));
    }

    /**
     * Laporan bulanan
     */
    public function monthly(Request $request)
    {
        // Default bulan ini (format: Y-m)
        $month = $request->input('month', now()->format('Y-m'));
        
        // Parse month untuk mendapatkan year dan month number
        try {
            $parsedMonth = Carbon::parse($month . '-01');
            $year = $parsedMonth->year;
            $monthNum = $parsedMonth->month;
        } catch (\Exception $e) {
            $parsedMonth = now();
            $year = $parsedMonth->year;
            $monthNum = $parsedMonth->month;
            $month = $parsedMonth->format('Y-m');
        }

        // Simpan sebagai $selectedMonth untuk view
        $selectedMonth = $parsedMonth;

        // Data kunjungan bulanan
        $visits = Queue::whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->with('patient')
            ->orderBy('created_at', 'asc')
            ->get();

        // Statistik per hari dalam bulan
        $dailyStats = Queue::whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Statistik keseluruhan
        $stats = [
            'total_visits' => $visits->count(),
            'completed' => $visits->where('status', 'completed')->count(),
            'cancelled' => $visits->where('status', 'cancelled')->count(),
            'in_progress' => $visits->where('status', 'in_progress')->count(),
            'waiting' => $visits->where('status', 'waiting')->count(),
            'unique_patients' => $visits->unique('patient_id')->count(),
        ];

        return view('reports.monthly', compact('month', 'selectedMonth', 'visits', 'stats', 'dailyStats'));
    }

    /**
     * Riwayat pasien
     */
    public function patientHistory(Patient $patient)
    {
        // Ambil semua rekam medis pasien
        // Menggunakan examination_date sesuai struktur tabel
        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->with(['user']) // jika ada relasi ke user (dokter)
            ->orderBy('examination_date', 'desc') // ← SESUAI DENGAN STRUKTUR TABEL
            ->get();

        // Ambil semua antrian/kunjungan pasien
        $queues = Queue::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik kunjungan pasien
        $visitStats = [
            'total_visits' => $queues->count(),
            'total_medical_records' => $medicalRecords->count(),
            'last_visit' => $medicalRecords->first()?->examination_date ?? $queues->first()?->created_at,
            'first_visit' => $medicalRecords->last()?->examination_date ?? $queues->last()?->created_at,
            'completed_visits' => $queues->where('status', 'completed')->count(),
        ];

        return view('reports.patient-history', compact('patient', 'medicalRecords', 'queues', 'visitStats'));
    }
}