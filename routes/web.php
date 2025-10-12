<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Patient routes
    Route::resource('patients', PatientController::class);

    // Queue routes
    Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
    Route::get('/queues/create', [QueueController::class, 'create'])->name('queues.create');
    Route::post('/queues', [QueueController::class, 'store'])->name('queues.store');
    Route::get('/queues/{queue}', [QueueController::class, 'show'])->name('queues.show');
    Route::patch('/queues/{queue}/status', [QueueController::class, 'updateStatus'])->name('queues.updateStatus');

     Route::get('/queues/ajax-stats', [QueueController::class, 'getStatistics'])->name('queues.statistics');

    // Medical record routes
    Route::resource('medical-records', MedicalRecordController::class);

    // Treatment routes (admin only)
    Route::middleware(['auth'])->group(function () {
    Route::resource('treatments', TreatmentController::class);
    Route::resource('users', UserController::class);
    });


    // Report routes
    // Report routes - URUTAN INI PENTING!
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// Route STATIS harus di atas
Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');

// Route dengan PARAMETER di paling bawah
Route::get('/reports/patient-history/{patient}', [ReportController::class, 'patientHistory'])
    ->name('reports.patient-history');
});
