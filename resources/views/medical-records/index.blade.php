<!-- resources/views/medical-records/index.blade.php -->
@extends('layouts.app')

@section('title', 'Rekam Medis Pasien')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-medical me-2 text-primary"></i>
        Rekam Medis Pasien
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('medical-records.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Rekam Medis Baru
        </a>
    </div>
</div>

<!-- STATISTICS ROW -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Rekam Medis
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $records->total() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Bulan Ini
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $monthlyCount ?? 0 }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Hari Ini
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $todayCount ?? 0 }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Total Pasien
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $uniquePatients ?? 0 }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER SECTION -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter me-2"></i>Pencarian & Filter
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('medical-records.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Pasien</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Nama atau No. Pasien" 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label for="start_date" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="start_date" name="start_date" 
                       value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label for="end_date" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="end_date" name="end_date" 
                       value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <label for="doctor" class="form-label">Dokter</label>
                <select class="form-select" id="doctor" name="doctor">
                    <option value="">Semua Dokter</option>
                    @foreach($doctors ?? [] as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                    <button type="button" class="btn btn-success" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MEDICAL RECORDS TABLE -->
<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Rekam Medis
        </h6>
        <span class="badge bg-primary">{{ $records->total() }} rekam medis</span>
    </div>
    <div class="card-body">
        @if($records->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">No. Pasien</th>
                        <th width="15%">Nama Pasien</th>
                        <th width="20%">Keluhan Utama</th>
                        <th width="15%">Diagnosis</th>
                        <th width="10%">Dokter</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $index => $record)
                    <tr>
                        <td class="text-center">{{ $records->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $record->examination_date->format('d M Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $record->examination_date->diffForHumans() }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $record->patient->patient_number }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-2">
                                    <div class="avatar-circle bg-info text-white">
                                        {{ strtoupper(substr($record->patient->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <strong>{{ $record->patient->name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-{{ $record->patient->gender === 'L' ? 'mars' : 'venus' }} me-1"></i>
                                        {{ $record->patient->age }} tahun
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <small>{{ Str::limit($record->chief_complaint, 60) }}</small>
                        </td>
                        <td>
                            <small>{{ Str::limit($record->diagnosis, 50) }}</small>
                            @if($record->treatments->count() > 0)
                                <br>
                                <span class="badge bg-success mt-1">
                                    {{ $record->treatments->count() }} tindakan
                                </span>
                            @endif
                        </td>
                        <td>
                            <small>
                                <i class="fas fa-user-md me-1 text-primary"></i>
                                {{ $record->user->name }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('medical-records.show', $record) }}" 
                                   class="btn btn-info" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('medical-records.edit', $record) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-success" 
                                        onclick="printRecord({{ $record->id }})"
                                        title="Print">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $records->links() }}
        </div>
        @else
        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <i class="fas fa-file-medical fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Rekam Medis</h4>
            <p class="text-muted">
                @if(request()->hasAny(['search', 'start_date', 'end_date', 'doctor']))
                    Tidak ada rekam medis yang sesuai dengan filter yang dipilih
                @else
                    Mulai tambahkan rekam medis baru untuk memulai
                @endif
            </p>
            @if(!request()->hasAny(['search', 'start_date', 'end_date', 'doctor']))
            <a href="{{ route('medical-records.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i>Tambah Rekam Medis Pertama
            </a>
            @else
            <a href="{{ route('medical-records.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-redo me-2"></i>Reset Filter
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }
    
    @media print {
        .btn-toolbar, .btn-group, .card-header, .pagination, .filter-section {
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
function printRecord(recordId) {
    window.open(`/medical-records/${recordId}/print`, '_blank');
}

// Auto-submit form when date is selected
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    if (startDateInput && endDateInput) {
        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value) {
                // Auto submit if both dates are selected
                // document.querySelector('form').submit();
            }
        });
    }
});
</script>
@endpush