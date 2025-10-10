<!-- resources/views/reports/index.blade.php -->
@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">
            <i class="fas fa-chart-bar me-2 text-primary"></i>
            Laporan & Statistik
        </h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Pasien
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $stats['total_patients'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Kunjungan Hari Ini
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $stats['today_visits'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Kunjungan Bulan Ini
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $stats['this_month_visits'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Menu -->
    <div class="row">
        <!-- Daily Report -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-day fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Laporan Harian</h5>
                    <p class="card-text text-muted">
                        Lihat laporan kunjungan pasien per hari
                    </p>
                    <a href="{{ route('reports.daily') }}" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Monthly Report -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Laporan Bulanan</h5>
                    <p class="card-text text-muted">
                        Lihat laporan kunjungan pasien per bulan
                    </p>
                    <a href="{{ route('reports.monthly') }}" class="btn btn-success">
                        <i class="fas fa-eye me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Patient History -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <i class="fas fa-user-injured fa-3x text-info mb-3 d-block text-center"></i>
                    <h5 class="card-title text-center">Riwayat Pasien</h5>
                    <p class="card-text text-muted text-center">
                        Lihat riwayat medis pasien
                    </p>
                    
                    <!-- Form Pilih Pasien -->
                    <form action="{{ route('reports.patient-history', ['patient' => 0]) }}" 
                          method="GET" 
                          id="patientHistoryForm">
                        <div class="mb-3">
                            <select name="patient_id" 
                                    class="form-select" 
                                    required
                                    onchange="updatePatientHistoryUrl(this.value)">
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->name }} - {{ $patient->medical_record_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info w-100" id="btnViewHistory" disabled>
                            <i class="fas fa-eye me-2"></i>Lihat Riwayat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePatientHistoryUrl(patientId) {
    const form = document.getElementById('patientHistoryForm');
    const btn = document.getElementById('btnViewHistory');
    
    if (patientId) {
        form.action = "{{ url('reports/patient-history') }}/" + patientId;
        btn.disabled = false;
    } else {
        btn.disabled = true;
    }
}
</script>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.border-left-success {
    border-left: 4px solid #1cc88a !important;
}

.border-left-info {
    border-left: 4px solid #36b9cc !important;
}

.text-xs {
    font-size: 0.7rem;
}
</style>
@endpush