<!-- resources/views/reports/patient-history.blade.php -->
@extends('layouts.app')

@section('title', 'Riwayat Pasien - ' . $patient->name)

@section('content')
<div class="container-fluid">
    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-history me-2 text-primary"></i>
            Riwayat Medis Pasien
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>Print
                </button>
                <button type="button" class="btn btn-danger" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf me-1"></i>PDF
                </button>
            </div>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- PATIENT INFO CARD -->
    <div class="card shadow mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-injured me-2"></i>
                Informasi Pasien
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="180">Nama Lengkap</th>
                            <td>: <strong>{{ $patient->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>No. Rekam Medis</th>
                            <td>: <span class="badge bg-dark">{{ $patient->medical_record_number }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>: {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Usia</th>
                            <td>: {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->age : '-' }} tahun</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $patient->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="180">Telepon</th>
                            <td>: {{ $patient->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $patient->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $patient->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Golongan Darah</th>
                            <td>: {{ $patient->blood_type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alergi</th>
                            <td>: {{ $patient->allergies ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- VISIT STATISTICS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow border-left-primary h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Kunjungan
                    </div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                        {{ $visitStats['total_visits'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-left-success h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Rekam Medis
                    </div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                        {{ $visitStats['total_medical_records'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-left-info h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Kunjungan Selesai
                    </div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                        {{ $visitStats['completed_visits'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-left-warning h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Kunjungan Terakhir
                    </div>
                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                        {{ $visitStats['last_visit'] ? $visitStats['last_visit']->diffForHumans() : '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MEDICAL RECORDS -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-medical-alt me-2"></i>Riwayat Rekam Medis
            </h6>
            <span class="badge bg-primary">{{ $medicalRecords->count() }} rekam medis</span>
        </div>
        <div class="card-body">
            @if($medicalRecords->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">Tanggal</th>
                            <th width="20%">Keluhan</th>
                            <th width="20%">Diagnosis</th>
                            <th width="20%">Tindakan</th>
                            <th width="13%">Dokter</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicalRecords as $index => $record)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($record->examination_date)->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($record->examination_date)->format('H:i') }}</small>
                            </td>
                            <td>
                                <small>{{ Str::limit($record->chief_complaint ?? '-', 60) }}</small>
                            </td>
                            <td>
                                <small>{{ Str::limit($record->diagnosis ?? '-', 60) }}</small>
                            </td>
                            <td>
                                <small>
                                    @if($record->treatment_performed)
                                        {{ Str::limit($record->treatment_performed, 60) }}
                                    @elseif($record->treatment_plan)
                                        {{ Str::limit($record->treatment_plan, 60) }}
                                    @else
                                        -
                                    @endif
                                </small>
                            </td>
                            <td>
                                <small>{{ $record->user->name ?? '-' }}</small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('medical-records.show', $record) }}" 
                                   class="btn btn-sm btn-info"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada rekam medis</p>
            </div>
            @endif
        </div>
    </div>

    <!-- VISIT HISTORY (QUEUES) -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Riwayat Kunjungan
            </h6>
            <span class="badge bg-secondary">{{ $queues->count() }} kunjungan</span>
        </div>
        <div class="card-body">
            @if($queues->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">Tanggal</th>
                            <th width="10%">No. Antrian</th>
                            <th width="30%">Keluhan</th>
                            <th width="15%">Status</th>
                            <th width="18%">Waktu Tunggu</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($queues as $index => $queue)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $queue->created_at->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ $queue->created_at->format('H:i') }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-dark">{{ $queue->queue_number }}</span>
                            </td>
                            <td>
                                <small>{{ Str::limit($queue->complaint ?? '-', 80) }}</small>
                            </td>
                            <td class="text-center">
                                @if($queue->status === 'completed')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Selesai
                                    </span>
                                @elseif($queue->status === 'in_progress')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-spinner me-1"></i>Proses
                                    </span>
                                @elseif($queue->status === 'cancelled')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $queue->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('queues.show', $queue) }}" 
                                   class="btn btn-sm btn-info"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada riwayat kunjungan</p>
            </div>
            @endif
        </div>
    </div>
</div>
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
    
    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }
    
    .text-xs {
        font-size: 0.7rem;
    }
    
    .text-gray-800 {
        color: #5a5c69 !important;
    }

    @media print {
        .btn-toolbar, .btn, .no-print {
            display: none !important;
        }
        
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }
        
        body {
            background: white !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function exportToPDF() {
    alert('Fitur export PDF akan segera hadir!');
}
</script>
@endpush