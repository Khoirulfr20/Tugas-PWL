<!-- resources/views/reports/patient-history.blade.php -->
@extends('layouts.app')

@section('title', 'Riwayat Pasien')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-history me-2 text-primary"></i>
        Riwayat Pasien
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if(isset($patient))
        <div class="btn-group me-2">
            <button type="button" class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Print
            </button>
            <a href="{{ route('reports.patient-history', ['patient' => $patient->id, 'pdf' => 1]) }}" 
               class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf me-1"></i>PDF
            </a>
        </div>
        @endif
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<!-- PATIENT SEARCH -->
@if(!isset($patient))
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-search me-2"></i>Pilih Pasien
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.patient-history') }}">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Cari Pasien</label>
                        <select class="form-select form-select-lg" id="patient_id" name="patient" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->patient_number }} - {{ $p->name }} ({{ $p->age }} tahun)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Lihat Riwayat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<!-- PATIENT INFO -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar-large bg-primary text-white">
                            {{ strtoupper(substr($patient->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="col">
                        <h3 class="mb-1">{{ $patient->name }}</h3>
                        <p class="mb-0">
                            <span class="badge bg-secondary">{{ $patient->patient_number }}</span>
                            <span class="ms-2">
                                <i class="fas fa-{{ $patient->gender === 'L' ? 'mars' : 'venus' }} me-1"></i>
                                {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}, {{ $patient->age }} tahun
                            </span>
                            <span class="ms-2">
                                <i class="fas fa-phone me-1"></i>{{ $patient->phone }}
                            </span>
                        </p>
                    </div>
                    <div class="col-auto">
                        <div class="text-end">
                            <small class="text-muted d-block">Terdaftar Sejak</small>
                            <strong>{{ $patient->created_at->format('d F Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATISTICS -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow border-left-primary h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Kunjungan
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $patient->medicalRecords->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow border-left-success h-100">
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
    <div class="col-md-4">
        <div class="card shadow border-left-info h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Total Tindakan
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $patient->medicalRecords->sum(function($record) { return $record->treatments->count(); }) }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MEDICAL HISTORY -->
@if($patient->medicalRecords->count() > 0)
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-file-medical me-2"></i>Timeline Rekam Medis
        </h6>
    </div>
    <div class="card-body">
        <div class="timeline">
            @foreach($patient->medicalRecords()->orderBy('examination_date', 'desc')->get() as $record)
            <div class="timeline-item mb-4">
                <div class="timeline-marker bg-primary"></div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    {{ $record->examination_date->format('d F Y') }}
                                </h5>
                                <small class="text-muted">
                                    <i class="fas fa-user-md me-1"></i>{{ $record->user->name }}
                                </small>
                            </div>
                            <a href="{{ route('medical-records.show', $record) }}" 
                               class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="fas fa-external-link-alt me-1"></i>Detail
                            </a>
                        </div>
                    </div>
                    
                    <div class="timeline-body mt-3">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong class="text-primary">Keluhan:</strong>
                                <p class="mb-0">{{ Str::limit($record->chief_complaint, 150) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong class="text-primary">Diagnosis:</strong>
                                <p class="mb-0">{{ Str::limit($record->diagnosis, 150) }}</p>
                            </div>
                        </div>
                        
                        @if($record->treatments->count() > 0)
                        <div class="mt-3">
                            <strong class="text-primary">Tindakan:</strong>
                            <div class="mt-2">
                                @foreach($record->treatments as $treatment)
                                    <span class="badge bg-info me-1 mb-1">
                                        {{ $treatment->treatment->name }}
                                        @if($treatment->tooth_number)
                                            (Gigi: {{ $treatment->tooth_number }})
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        @if($record->prescription)
                        <div class="mt-3">
                            <strong class="text-primary">Resep:</strong>
                            <p class="mb-0">{{ Str::limit($record->prescription, 200) }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<div class="card shadow">
    <div class="card-body text-center py-5">
        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">Belum Ada Riwayat Medis</h4>
        <p class="text-muted">Pasien ini belum memiliki rekam medis</p>
    </div>
</div>
@endif
@endif
@endsection

@push('styles')
<style>
    .avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
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
        background: #e9ecef;
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
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 3px solid #007bff;
    }
    
    @media print {
        .btn-toolbar, .btn, .timeline-marker {
            display: none !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
        .timeline::before {
            display: none;
        }
        .timeline {
            padding-left: 0;
        }
    }
</style>
@endpush