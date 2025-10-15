<?php
// app/Http/Controllers/QueueController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Patient;
use Carbon\Carbon;
use App\Helpers\NotificationHelper; // 🔔 Tambahkan helper notifikasi

class QueueController extends Controller
{
    /**
     * Tampilkan daftar antrian
     */
    public function index(Request $request)
    {
        $query = Queue::with('patient');
        
        // Filter tanggal
        $date = $request->input('date', today()->format('Y-m-d'));
        $query->whereDate('queue_date', $date);
        
        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Pencarian pasien
        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        $queues = $query->orderBy('queue_number')->get();

        // AJAX untuk statistik
        if ($request->ajax()) {
            return response()->json([
                'total' => $queues->count(),
                'waiting' => $queues->where('status', 'waiting')->count(),
                'in_progress' => $queues->where('status', 'in_progress')->count(),
                'completed' => $queues->where('status', 'completed')->count(),
                'cancelled' => $queues->where('status', 'cancelled')->count(),
            ]);
        }
        
        return view('queues.index', compact('queues', 'date'));
    }

    /**
     * Form tambah antrian baru
     */
    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        return view('queues.create', compact('patients'));
    }

    /**
     * Simpan antrian baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'queue_date' => 'required|date',
                'complaint' => 'nullable|string|max:1000',
            ]);

            // Nomor antrian berikutnya
            $lastQueue = Queue::whereDate('queue_date', $validated['queue_date'])
                             ->max('queue_number');
            
            $validated['queue_number'] = ($lastQueue ?? 0) + 1;
            $validated['status'] = 'waiting';

            $queue = Queue::create($validated);

            // 🔔 Tambah notifikasi baru
            $patient = Patient::find($validated['patient_id']);
            NotificationHelper::add(
                'success',
                'Antrian Baru Ditambahkan',
                'Pasien ' . ($patient->name ?? 'Tidak diketahui') . ' mendapat nomor antrian #' . $queue->queue_number,
                [
                    'url' => route('queues.show', $queue->id),
                    'queue_number' => $queue->queue_number,
                    'queue_date' => $queue->queue_date,
                ]
            );

            return redirect()
                ->route('queues.index', ['date' => $validated['queue_date']])
                ->with('success', 'Antrian berhasil ditambahkan dengan nomor: ' . $queue->queue_number);

        } catch (\Exception $e) {
            \Log::error('Error creating queue: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan antrian: ' . $e->getMessage());
        }
    }

    /**
     * Update status antrian (via AJAX)
     */
    public function updateStatus(Request $request, Queue $queue)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:waiting,in_progress,completed,cancelled',
            ]);

            $queue->status = $validated['status'];

            // Tanggal aktivitas
            if ($validated['status'] === 'in_progress') {
                $queue->called_at = now();
            } elseif ($validated['status'] === 'completed') {
                $queue->completed_at = now();
            }

            $queue->save();

            // 🔔 Tambah notifikasi perubahan status
            NotificationHelper::add(
                'info',
                'Status Antrian Diperbarui',
                'Nomor antrian #' . $queue->queue_number . ' sekarang berstatus ' . strtoupper($queue->status),
                [
                    'url' => route('queues.show', $queue->id),
                    'queue_number' => $queue->queue_number,
                    'status' => $queue->status,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Status antrian berhasil diperbarui.',
                'queue' => $queue->load('patient'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating queue status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Statistik antrian (dipanggil via AJAX)
     */
    public function getStatistics(Request $request)
    {
        $date = $request->input('date', today()->format('Y-m-d'));
        $queues = Queue::whereDate('queue_date', $date)->get();

        return response()->json([
            'total' => $queues->count(),
            'waiting' => $queues->where('status', 'waiting')->count(),
            'in_progress' => $queues->where('status', 'in_progress')->count(),
            'completed' => $queues->where('status', 'completed')->count(),
            'cancelled' => $queues->where('status', 'cancelled')->count(),
        ]);
    }

    /**
     * Detail antrian tertentu
     */
    public function show(Queue $queue)
    {
        $queue->load('patient');
        return view('queues.show', compact('queue'));
    }
}
