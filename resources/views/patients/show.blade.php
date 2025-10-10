<!-- resources/views/patients/show.blade.php -->
@extends('layouts.app')

@section('title', 'Detail Pasien - ' . $patient->name)

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2 text-primary"></i>
        Detail Pasien
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('queues.create') }}?patient_id={{ $patient->id }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>Buat Antrian
            </a>
            <button type="button" class="btn btn-info" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Print
            </button>
        </div>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- LEFT SIDEBAR - PATIENT INFO -->
    <div class="col-md-4">
        <!-- PATIENT CARD -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="avatar-large mx-auto mb-3">
                    <div class="avatar-circle-large bg-primary text-white">
                        {{ strtoupper(substr($patient->name, 0, 2)) }}
                    </div>
                </div>
                <h4 class="mb-1">{{ $patient->name }}</h4>
                <p class="text-muted mb-3">
                    <span class="badge bg-secondary">{{ $patient->patient_number }}</span>
                </p>
                <div class="d-grid gap-2">
                    <a href="{{ route('medical-records.create') }}?patient_id={{ $patient->id }}" 
                       class="btn btn-primary">
                        <i class="fas fa-file-medical me-2"></i>Rekam Medis Baru
                    </a>
                    <a href="{{ route('reports.patient-history', $patient) }}" 
                       class="btn btn-outline-info">
                        <i class="fas fa-history me-2"></i>Lihat Riwayat Lengkap
                    </a>
                </div>
            </div>
        </div>

        <!-- BASIC INFO CARD -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <small class="text-muted d-block">Jenis Kelamin</small>
                    <strong>
                        <i class="fas fa-{{ $patient->gender === 'L' ? 'mars text-primary' : 'venus text-danger' }} me-1"></i>
                        {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </strong>
                </div>
                <div class="info-item mb-3">
                    <small class="text-muted d-block">Tanggal Lahir</small>
                    <strong>{{ $patient->birth_date->format('d F Y') }}</strong>
                </div>
                <div class="info-item mb-3">
                    <small class="text-muted d-block">Umur</small>
                    <strong>{{ $patient->age }} tahun</strong>
                </div>
                <div class="info-item mb-3">
                    <small class="text-muted d-block">Telepon</small>
                    <strong>
                        <i class="fas fa-phone me-1 text-success"></i>
                        <a href="tel:{{ $patient->phone }}">{{ $patient->phone }}</a>
                    </strong>
                </div>
                <div class="info-item mb-3">
                    <small class="text-muted d-block">Alamat</small>
                    <strong>{{ $patient->address }}</strong>
                </div>
                <div class="info-item">
                    <small class="text-muted d-block">Terdaftar Sejak</small>
                    <strong>{{ $patient->created_at->format('d M Y') }}</strong>
                    <br>
                    <small class="text-muted">{{ $patient->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>

        <!-- EMERGENCY CONTACT CARD -->
        @if($patient->emergency_contact_name || $patient->emergency_contact_phone)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-phone-alt me-2"></i>Kontak Darurat
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item mb-2">
                    <small class="text-muted d-block">Nama</small>
                    <strong>{{ $patient->emergency_contact_name ?? '-' }}</strong>
                </div>
                <div class="info-item">
                    <small class="text-muted d-block">Telepon</small>
                    <strong>
                        <i class="fas fa-phone me-1 text-danger"></i>
                        <a href="tel:{{ $patient->emergency_contact_phone }}">
                            {{ $patient->emergency_contact_phone ?? '-' }}
                        </a>
                    </strong>
                </div>
            </div>
        </div>
        @endif

        <!-- MEDICAL HISTORY CARD -->
        @if($patient->medical_history || $patient->allergies)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>Riwayat Medis
                </h6>
            </div>
            <div class="card-body">
                @if($patient->medical_history)
                <div class="info-item mb-3">
                    <small class="text-muted d-block">Riwayat Penyakit</small>
                    <div class="alert alert-warning mb-0 mt-1">
                        {{ $patient->medical_history }}
                    </div>
                </div>
                @endif
                
                @if($patient->allergies)
                <div class="info-item">
                    <small class="text-muted d-block">Alergi</small>
                    <div class="alert alert-danger mb-0 mt-1">
                        <i class="fas fa-allergies me-1"></i>
                        {{ $patient->allergies }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- RIGHT CONTENT - TABS -->
    <div class="col-md-8">
        <!-- TABS NAVIGATION -->
        <ul class="nav nav-tabs mb-3" id="patientTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="medical-records-tab" 
                        data-bs-toggle="tab" data-bs-target="#medical-records" 
                        type="button" role="tab">
                    <i class="fas fa-file-medical me-1"></i>Rekam Medis
                    <span class="badge bg-primary ms-1">{{ $patient->medicalRecords->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="queues-tab" 
                        data-bs-toggle="tab" data-bs-target="#queues" 
                        type="button" role="tab">
                    <i class="fas fa-list-ol me-1"></i>Riwayat Antrian
                    <span class="badge bg-success ms-1">{{ $patient->queues->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="statistics-tab" 
                        data-bs-toggle="tab" data-bs-target="#statistics" 
                        type="button" role="tab">
                    <i class="fas fa-chart-bar me-1"></i>Statistik
                </button>
            </li>
        </ul>

        <!-- TABS CONTENT -->
        <div class="tab-content" id="patientTabsContent">
            <!-- TAB 1: MEDICAL RECORDS -->
            <div class="tab-pane fade show active" id="medical-records" role="tabpanel">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Rekam Medis</h6>
                    </div>
                    <div class="card-body">
                        @if($patient->medicalRecords->count() > 0)
                        <div class="timeline">
                            @foreach($patient->medicalRecords as $record)
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">
                                                {{ $record->examination_date->format('d F Y') }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-user-md me-1"></i>
                                                {{ $record->user->name }}
                                            </small>
                                        </div>
                                        <a href="{{ route('medical-records.show', $record) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-1"><strong>Keluhan:</strong> {{ Str::limit($record->chief_complaint, 100) }}</p>
                                        <p class="mb-1"><strong>Diagnosis:</strong> {{ Str::limit($record->diagnosis, 100) }}</p>
                                        @if($record->treatments->count() > 0)
                                        <p class="mb-0">
                                            <strong>Tindakan:</strong>
                                            @foreach($record->treatments as $treatment)
                                                <span class="badge bg-info">{{ $treatment->treatment->name }}</span>
                                            @endforeach
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada rekam medis</p>
                            <a href="{{ route('medical-records.create') }}?patient_id={{ $patient->id }}" 
                               class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Rekam Medis Pertama
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TAB 2: QUEUES -->
            <div class="tab-pane fade" id="queues" role="tabpanel">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-success">Riwayat Antrian</h6>
                    </div>
                    <div class="card-body">
                        @if($patient->queues->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No. Antrian</th>
                                        <th>Status</th>
                                        <th>Keluhan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->queues()->latest()->get() as $queue)
                                    <tr>
                                        <td>{{ $queue->queue_date->format('d M Y') }}</td>
                                        <td><span class="badge bg-dark">{{ $queue->queue_number }}</span></td>
                                        <td>
                                            <span class="badge bg-{{ $queue->status === 'completed' ? 'success' : ($queue->status === 'cancelled' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($queue->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $queue->complaint ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-list-ol fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada riwayat antrian</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TAB 3: STATISTICS -->
            <div class="tab-pane fade" id="statistics" role="tabpanel">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-info">Statistik Pasien</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card border-left-success h-100">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Kunjungan Terakhir
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ $patient->latestMedicalRecord?->examination_date?->format('d M Y') ?? 'Belum ada' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-left-warning h-100">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Antrian
                                        </div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                                            {{ $patient->queues->count() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-left-info h-100">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Pasien Sejak
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ $patient->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-circle-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 2.5rem;
        margin: 0 auto;
    }
    
    .info-item {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 0.75rem;
    }
    
    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-marker {
        position: absolute;
        left: -24px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #007bff;
    }
    
    .timeline-content {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 3px solid #007bff;
    }
    
    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        color: #007bff;
        font-weight: 600;
    }
    
    @media print {
        .btn-toolbar, .nav-tabs, .btn-group, .btn {
            display: none !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-activate tab based on URL hash
    const hash = window.location.hash;
    if (hash) {
        const tab = document.querySelector(`button[data-bs-target="${hash}"]`);
        if (tab) {
            const bsTab = new bootstrap.Tab(tab);
            bsTab.show();
        }
    }
    
    // Update URL hash when tab changes
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(e) {
            const target = e.target.getAttribute('data-bs-target');
            history.replaceState(null, null, target);
        });
    });
});
</script>
@endpush