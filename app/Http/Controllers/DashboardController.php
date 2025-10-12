<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\MedicalRecord;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'today_queue' => Queue::today()->count(),
            'waiting_queue' => Queue::today()->waiting()->count(),
            'today_examinations' => MedicalRecord::whereDate('examination_date', today())->count(),
        ];

        $recent_patients = Patient::latest()->limit(5)->get();
        $today_queue = Queue::today()
                           ->with('patient')
                           ->orderBy('queue_number')
                           ->limit(10)
                           ->get();

        return view('dashboard', compact('stats', 'recent_patients', 'today_queue'));
    }
}