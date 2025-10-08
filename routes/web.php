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
    Route::resource('queues', QueueController::class);
    Route::patch('/queues/{queue}/status', [QueueController::class, 'updateStatus'])->name('queues.update-status');

    // Medical record routes
    Route::resource('medical-records', MedicalRecordController::class);

    // Treatment routes (admin only)
    Route::middleware(['auth'])->group(function () {
    Route::resource('treatments', TreatmentController::class);
    Route::resource('users', UserController::class);
    });

    // Report routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/patient-history/{patient}', [ReportController::class, 'patientHistory'])->name('reports.patient-history');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
});
