<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function patientHistory(Patient $patient)
    {
        $patient->load(['medicalRecords.user', 'medicalRecords.treatments.treatment']);
        
        if (request()->has('pdf')) {
            $pdf = PDF::loadView('reports.patient-history-pdf', compact('patient'));
            return $pdf->download('riwayat-pasien-' . $patient->patient_number . '.pdf');
        }

        return view('reports.patient-history', compact('patient'));
    }

    public function daily(Request $request)
    {
        $date = $request->input('date', today()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);

        $stats = [
            'total_patients' => Queue::whereDate('queue_date', $selectedDate)->distinct('patient_id')->count(),
            'total_examinations' => MedicalRecord::whereDate('examination_date', $selectedDate)->count(),
            'total_revenue' => MedicalRecord::whereDate('examination_date', $selectedDate)
                                          ->with('treatments')
                                          ->get()
                                          ->sum('total_cost'),
            'completed_queues' => Queue::whereDate('queue_date', $selectedDate)->where('status', 'completed')->count(),
        ];

        $examinations = MedicalRecord::with(['patient', 'user', 'treatments.treatment'])
                                   ->whereDate('examination_date', $selectedDate)
                                   ->get();

        if (request()->has('pdf')) {
            $pdf = PDF::loadView('reports.daily-pdf', compact('stats', 'examinations', 'selectedDate'));
            return $pdf->download('laporan-harian-' . $selectedDate->format('Y-m-d') . '.pdf');
        }

        return view('reports.daily', compact('stats', 'examinations', 'selectedDate'));
    }

    public function monthly(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $selectedMonth = Carbon::parse($month . '-01');

        $stats = [
            'total_patients' => Queue::whereYear('queue_date', $selectedMonth->year)
                                   ->whereMonth('queue_date', $selectedMonth->month)
                                   ->distinct('patient_id')
                                   ->count(),
            'total_examinations' => MedicalRecord::whereYear('examination_date', $selectedMonth->year)
                                                ->whereMonth('examination_date', $selectedMonth->month)
                                                ->count(),
            'total_revenue' => MedicalRecord::whereYear('examination_date', $selectedMonth->year)
                                          ->whereMonth('examination_date', $selectedMonth->month)
                                          ->with('treatments')
                                          ->get()
                                          ->sum('total_cost'),
        ];

        // Daily breakdown
        $dailyStats = [];
        $daysInMonth = $selectedMonth->daysInMonth;
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = $selectedMonth->copy()->day($day);
            $dailyStats[] = [
                'date' => $currentDate->format('Y-m-d'),
                'day' => $currentDate->format('d'),
                'patients' => Queue::whereDate('queue_date', $currentDate)->distinct('patient_id')->count(),
                'examinations' => MedicalRecord::whereDate('examination_date', $currentDate)->count(),
                'revenue' => MedicalRecord::whereDate('examination_date', $currentDate)
                                        ->with('treatments')
                                        ->get()
                                        ->sum('total_cost'),
            ];
        }

        if (request()->has('pdf')) {
            $pdf = PDF::loadView('reports.monthly-pdf', compact('stats', 'dailyStats', 'selectedMonth'));
            return $pdf->download('laporan-bulanan-' . $selectedMonth->format('Y-m') . '.pdf');
        }

        return view('reports.monthly', compact('stats', 'dailyStats', 'selectedMonth'));
    }
}