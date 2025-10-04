<!-- resources/views/reports/daily.blade.php -->
@extends('layouts.app')

@section('title', 'Laporan Harian')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calendar-day me-2 text-primary"></i>
        Laporan Harian
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Print
            </button>
            <button type="button" class="btn btn-danger">
                <i class="fas fa-file-pdf me-1"></i>PDF
            </button>
        </div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<!-- DATE SELECTOR -->
<div class="row mb-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form method="GET" action="{{ route('reports.daily') }}" class="row g-3">
                    <div class="col-md-8">
                        <label for="date" class="form-label">Pilih Tanggal</label>
                        <input type="date" 
                               class="form-control form-control-lg" 
                               id="date" 
                               name="date" 
                               value="{{ request('date', $selectedDate->format('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-search me-2"></i>Lihat Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DATE HEADER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-primary">
            <div class="card-body text-center">
                <h3 class="mb-1">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    {{ $selectedDate->isoFormat('dddd, D MMMM YYYY') }}
                </h3>
                <p class="text-muted mb-0">{{ $selectedDate->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- STATISTICS -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-success h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pemeriksaan
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_examinations'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-info h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Antrian Selesai
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['completed_queues'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-warning h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pendapatan
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-primary h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pasien
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_patients'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EXAMINATIONS LIST -->
@if($examinations->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list me-2"></i>Daftar Pemeriksaan
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Waktu</th>
                        <th width="15%">No. Pasien</th>
                        <th width="20%">Nama Pasien</th>
                        <th width="25%">Diagnosis</th>
                        <th width="10%">Dokter</th>
                        <th width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($examinations as $index => $record)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $record->created_at->format('H:i') }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $record->patient->patient_number }}</span>
                        </td>
                        <td>
                            <strong>{{ $record->patient->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $record->patient->age }} tahun</small>
                        </td>
                        <td>
                            <small>{{ Str::limit($record->diagnosis, 60) }}</small>
                        </td>
                        <td>
                            <small>{{ $record->user->name }}</small>
                        </td>
                        <td class="text-end">
                            <strong class="text-success">
                                Rp {{ number_format($record->total_cost, 0, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="6" class="text-end"><strong>TOTAL:</strong></td>
                        <td class="text-end">
                            <strong class="text-success">
                                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- TOP TREATMENTS -->
@if($topTreatments->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-procedures me-2"></i>Tindakan Terpopuler Hari Ini
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Rank</th>
                        <th width="50%">Tindakan</th>
                        <th width="20%">Jumlah</th>
                        <th width="20%">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topTreatments as $index => $item)
                    <tr>
                        <td class="text-center">
                            @if($index === 0)
                                <i class="fas fa-trophy fa-lg text-warning"></i>
                            @elseif($index === 1)
                                <i class="fas fa-medal fa-lg text-secondary"></i>
                            @elseif($index === 2)
                                <i class="fas fa-award fa-lg" style="color: #CD7F32;"></i>
                            @else
                                <span class="badge bg-primary">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td><strong>{{ $item['name'] }}</strong></td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $item['count'] }}x</span>
                        </td>
                        <td class="text-end">
                            <strong class="text-success">
                                Rp {{ number_format($item['revenue'], 0, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@else
<div class="card shadow">
    <div class="card-body text-center py-5">
        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">Tidak Ada Data</h4>
        <p class="text-muted">Tidak ada pemeriksaan pada tanggal ini</p>
    </div>
</div>
@endif
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
    
    .text-gray-300 {
        color: #dddfeb !important;
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
        
        .card-header {
            background-color: #f8f9fc !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        body {
            background: white !important;
        }
    }
</style>
@endpush