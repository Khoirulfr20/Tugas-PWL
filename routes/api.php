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
| IMPORTANT: Routes di file ini otomatis prefix '/api'
| Jadi /api/patients sebenarnya dipanggil dari route 'patients' di bawah
*/

// ✅ Get all patients (for search/autocomplete)
Route::get('/patients', function (Request $request) {
    try {
        $query = Patient::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $patients = $query->orderBy('name')->limit(10)->get();
        
        return response()->json($patients);
        
    } catch (\Exception $e) {
        \Log::error('API Patients Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to load patients',
            'message' => $e->getMessage()
        ], 500);
    }
});

// ✅ Get single patient
Route::get('/patients/{id}', function ($id) {
    try {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    } catch (\Exception $e) {
        \Log::error('API Patient Detail Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Patient not found',
            'message' => $e->getMessage()
        ], 404);
    }
});

// ✅ Get all treatments
Route::get('/treatments', function () {
    try {
        $treatments = Treatment::where('is_active', true)
                              ->orderBy('name')
                              ->get();
        
        return response()->json($treatments);
    } catch (\Exception $e) {
        \Log::error('API Treatments Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to load treatments',
            'message' => $e->getMessage()
        ], 500);
    }
});

// ✅ Get next queue number for a specific date
Route::get('/queues/next-number', function (Request $request) {
    try {
        $date = $request->input('date', today());
        
        $lastQueue = Queue::whereDate('queue_date', $date)
                         ->max('queue_number');
        
        $nextNumber = ($lastQueue ?? 0) + 1;
        
        return response()->json([
            'next_number' => $nextNumber,
            'date' => $date
        ]);
    } catch (\Exception $e) {
        \Log::error('API Queue Next Number Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to get next queue number',
            'message' => $e->getMessage()
        ], 500);
    }
});

// ✅ Get queue statistics (for dashboard real-time update)
Route::get('/queues/statistics', function (Request $request) {
    try {
        $date = $request->input('date', today());
        
        $queues = Queue::whereDate('queue_date', $date)->get();
        
        return response()->json([
            'total' => $queues->count(),
            'waiting' => $queues->where('status', 'waiting')->count(),
            'in_progress' => $queues->where('status', 'in_progress')->count(),
            'completed' => $queues->where('status', 'completed')->count(),
            'cancelled' => $queues->where('status', 'cancelled')->count(),
        ]);
    } catch (\Exception $e) {
        \Log::error('API Queue Statistics Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to load statistics',
            'message' => $e->getMessage()
        ], 500);
    }
});