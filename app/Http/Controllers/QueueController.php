<?php
// app/Http/Controllers/QueueController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Patient;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::with('patient')
                      ->whereDate('queue_date', today())
                      ->orderBy('queue_number')
                      ->get();
        
        return view('queues.index', compact('queues'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('queues.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'queue_date' => 'required|date',
            'complaint' => 'nullable|string',
        ]);

        $lastQueue = Queue::whereDate('queue_date', $validated['queue_date'])->max('queue_number');
        $validated['queue_number'] = ($lastQueue ?? 0) + 1;

        Queue::create($validated);

        return redirect()->route('queues.index')->with('success', 'Antrian berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Queue $queue)
    {
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

        // Broadcast event untuk real-time update
        broadcast(new QueueUpdated($queue));

        return response()->json(['success' => true, 'message' => 'Status antrian berhasil diperbarui.']);
    }
}