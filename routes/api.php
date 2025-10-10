<?php
// routes/api.php
// API Routes untuk AJAX calls dari view forms

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Queue;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Routes untuk mendukung fitur AJAX di forms
*/

// Get all patients (for search/autocomplete)
Route::get('/patients', function (Request $request) {
    $query = Patient::query();
    
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('patient_number', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }
    
    $patients = $query->limit(10)->get();
    
    return response()->json($patients);
});

// Get single patient
Route::get('/patients/{id}', function ($id) {
    $patient = Patient::findOrFail($id);
    return response()->json($patient);
});

// Get all treatments
Route::get('/treatments', function () {
    $treatments = Treatment::where('is_active', true)
                          ->orderBy('name')
                          ->get();
    
    return response()->json($treatments);
});

// Get next queue number for a specific date
Route::get('/queues/next-number', function (Request $request) {
    $date = $request->input('date', today());
    
    $lastQueue = Queue::whereDate('queue_date', $date)
                     ->max('queue_number');
    
    $nextNumber = ($lastQueue ?? 0) + 1;
    
    return response()->json([
        'next_number' => $nextNumber,
        'date' => $date
    ]);
});

// Get queue statistics (for dashboard real-time update)
Route::get('/queues/statistics', function (Request $request) {
    $date = $request->input('date', today());
    
    $queues = Queue::whereDate('queue_date', $date)->get();
    
    return response()->json([
        'total' => $queues->count(),
        'waiting' => $queues->where('status', 'waiting')->count(),
        'in_progress' => $queues->where('status', 'in_progress')->count(),
        'completed' => $queues->where('status', 'completed')->count(),
        'cancelled' => $queues->where('status', 'cancelled')->count(),
    ]);
});