<?php
// app/Http/Controllers/QueueController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Patient;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $query = Queue::with('patient');
        
        // Filter by date
        $date = $request->input('date', today()->format('Y-m-d'));
        $query->whereDate('queue_date', $date);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by patient name
        if ($request->filled('search')) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        $queues = $query->orderBy('queue_number')->get();
        
        // AJAX request untuk statistics update (auto-refresh)
        if ($request->ajax()) {
            return response()->json([
                'total' => $queues->count(),
                'waiting' => $queues->where('status', 'waiting')->count(),
                'in_progress' => $queues->where('status', 'in_progress')->count(),
                'completed' => $queues->where('status', 'completed')->count(),
            ]);
        }
        
        return view('queues.index', compact('queues'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        return view('queues.create', compact('patients'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'queue_date' => 'required|date',
                'complaint' => 'nullable|string|max:1000',
            ]);

            // Get last queue number for the date
            $lastQueue = Queue::whereDate('queue_date', $validated['queue_date'])
                             ->max('queue_number');
            
            $validated['queue_number'] = ($lastQueue ?? 0) + 1;
            $validated['status'] = 'waiting';

            $queue = Queue::create($validated);

            // TIDAK ADA BROADCAST - Sistem lebih sederhana

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

    public function updateStatus(Request $request, Queue $queue)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:waiting,in_progress,completed,cancelled'
            ]);

            $queue->status = $validated['status'];
            
            if ($validated['status'] === 'in_progress') {
                $queue->called_at = now();
            } elseif ($validated['status'] === 'completed') {
                $queue->completed_at = now();
            }

            $queue->save();

            // TIDAK ADA BROADCAST - User refresh untuk lihat update

            return response()->json([
                'success' => true,
                'message' => 'Status antrian berhasil diperbarui.',
                'queue' => $queue->load('patient')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating queue status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getStatistics(Request $request)
    {
        $date = $request->input('date', today()->format('Y-m-d'));
        
        $queues = Queue::whereDate('queue_date', $date)->get();
        
        return response()->json([
            'total' => $queues->count(),
            'waiting' => $queues->where('status', 'waiting')->count(),
            'in_progress' => $queues->where('status', 'in_progress')->count(),
            'completed' => $queues->where('status', 'completed')->count(),
        ]);
    }

    // TAMBAHAN INI: Method untuk show detail queue
    public function show(Queue $queue)
    {
        // Load relasi patient dan data terkait (misalnya medical record terkait jika ada)
        $queue->load('patient');
        
        // Optional: Authorize jika pakai policy
        // $this->authorize('view', $queue);
        
        // Optional: Ambil data tambahan, misalnya medical records terkait queue ini
        // $relatedRecords = MedicalRecord::where('queue_id', $queue->id)->get(); // Asumsi ada kolom queue_id
        
        return view('queues.show', compact('queue')); // Render view detail
    }
}
