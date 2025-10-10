<!-- resources/views/reports/monthly.blade.php -->
@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calendar-alt me-2 text-primary"></i>
        Laporan Bulanan
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
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<!-- MONTH SELECTOR -->
<div class="row mb-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form method="GET" action="{{ route('reports.monthly') }}" class="row g-3">
                    <div class="col-md-8">
                        <label for="month" class="form-label">Pilih Bulan & Tahun</label>
                        <input type="month" 
                               class="form-control form-control-lg" 
                               id="month" 
                               name="month" 
                               value="{{ $month }}"
                               max="{{ date('Y-m') }}">
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

<!-- MONTH HEADER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-info">
            <div class="card-body text-center">
                <h3 class="mb-1">
                    <i class="fas fa-calendar me-2 text-info"></i>
                    {{ $selectedMonth->isoFormat('MMMM YYYY') }}
                </h3>
                <p class="text-muted mb-0">
                    Periode: {{ $selectedMonth->copy()->startOfMonth()->format('d M Y') }} - 
                    {{ $selectedMonth->copy()->endOfMonth()->format('d M Y') }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- SUMMARY STATISTICS -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-primary h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Pasien Unik
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $stats['unique_patients'] }}
                </div>
                <small class="text-muted">Total Pasien</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-success h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Total Kunjungan
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $stats['total_visits'] }}
                </div>
                <small class="text-muted">Semua Status</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-info h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Selesai
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $stats['completed'] }}
                </div>
                <small class="text-muted">Kunjungan Selesai</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-warning h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Rata-rata/Hari
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $dailyStats->count() > 0 ? number_format($stats['total_visits'] / $dailyStats->count(), 1) : 0 }}
                </div>
                <small class="text-muted">Kunjungan</small>
            </div>
        </div>
    </div>
</div>

<!-- STATUS BREAKDOWN -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Status Kunjungan
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                            <h4 class="mb-0">{{ $stats['completed'] }}</h4>
                            <small class="text-muted">Selesai</small>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ $stats['total_visits'] > 0 ? ($stats['completed'] / $stats['total_visits']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="fas fa-spinner fa-3x text-warning mb-2"></i>
                            <h4 class="mb-0">{{ $stats['in_progress'] }}</h4>
                            <small class="text-muted">Dalam Proses</small>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-warning" 
                                     style="width: {{ $stats['total_visits'] > 0 ? ($stats['in_progress'] / $stats['total_visits']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="fas fa-times-circle fa-3x text-danger mb-2"></i>
                            <h4 class="mb-0">{{ $stats['cancelled'] }}</h4>
                            <small class="text-muted">Dibatalkan</small>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-danger" 
                                     style="width: {{ $stats['total_visits'] > 0 ? ($stats['cancelled'] / $stats['total_visits']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="fas fa-clock fa-3x text-info mb-2"></i>
                            <h4 class="mb-0">{{ $stats['waiting'] }}</h4>
                            <small class="text-muted">Menunggu</small>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-info" 
                                     style="width: {{ $stats['total_visits'] > 0 ? ($stats['waiting'] / $stats['total_visits']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DAILY BREAKDOWN -->
@if($dailyStats->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-bar me-2"></i>Breakdown Harian
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Hari</th>
                        <th width="12%">Total</th>
                        <th width="12%">Selesai</th>
                        <th width="12%">Dibatalkan</th>
                        <th width="39%">Visual Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyStats as $stat)
                    <tr>
                        <td><strong>{{ \Carbon\Carbon::parse($stat->date)->format('d/m') }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($stat->date)->isoFormat('dddd') }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $stat->total }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $stat->completed }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger">{{ $stat->cancelled }}</span>
                        </td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                @if($stat->completed > 0)
                                <div class="progress-bar bg-success" 
                                     role="progressbar" 
                                     style="width: {{ ($stat->completed / $stat->total) * 100 }}%"
                                     title="Selesai: {{ $stat->completed }}">
                                    {{ $stat->completed }}
                                </div>
                                @endif
                                @if($stat->cancelled > 0)
                                <div class="progress-bar bg-danger" 
                                     role="progressbar" 
                                     style="width: {{ ($stat->cancelled / $stat->total) * 100 }}%"
                                     title="Dibatalkan: {{ $stat->cancelled }}">
                                    {{ $stat->cancelled }}
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="2" class="text-end"><strong>TOTAL:</strong></td>
                        <td class="text-center">
                            <strong class="badge bg-primary">{{ $stats['total_visits'] }}</strong>
                        </td>
                        <td class="text-center">
                            <strong class="badge bg-success">{{ $stats['completed'] }}</strong>
                        </td>
                        <td class="text-center">
                            <strong class="badge bg-danger">{{ $stats['cancelled'] }}</strong>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- INSIGHTS -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow border-success h-100">
            <div class="card-header bg-success text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-line me-2"></i>Statistik Harian
                </h6>
            </div>
            <div class="card-body">
                @php
                    $maxDay = $dailyStats->sortByDesc('total')->first();
                    $minDay = $dailyStats->where('total', '>', 0)->sortBy('total')->first();
                @endphp
                <ul class="mb-0">
                    @if($maxDay)
                    <li class="mb-2">
                        Hari tersibuk: 
                        <strong>{{ \Carbon\Carbon::parse($maxDay->date)->isoFormat('dddd, D MMMM') }}</strong>
                        <br>
                        <small class="text-muted">({{ $maxDay->total }} kunjungan)</small>
                    </li>
                    @endif
                    
                    @if($minDay)
                    <li class="mb-2">
                        Hari paling sepi: 
                        <strong>{{ \Carbon\Carbon::parse($minDay->date)->isoFormat('dddd, D MMMM') }}</strong>
                        <br>
                        <small class="text-muted">({{ $minDay->total }} kunjungan)</small>
                    </li>
                    @endif
                    
                    <li class="mb-0">
                        Rata-rata kunjungan per hari: 
                        <strong>{{ number_format($stats['total_visits'] / max($dailyStats->count(), 1), 1) }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow border-info h-100">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>Ringkasan Bulan Ini
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Total <strong>{{ $stats['total_visits'] }}</strong> kunjungan tercatat
                </p>
                <p class="mb-2">
                    <i class="fas fa-users text-primary me-2"></i>
                    Melayani <strong>{{ $stats['unique_patients'] }}</strong> pasien unik
                </p>
                <p class="mb-2">
                    <i class="fas fa-check-double text-success me-2"></i>
                    <strong>{{ $stats['completed'] }}</strong> kunjungan selesai 
                    ({{ $stats['total_visits'] > 0 ? round(($stats['completed'] / $stats['total_visits']) * 100, 1) : 0 }}%)
                </p>
                <p class="mb-0">
                    <i class="fas fa-calendar-check text-info me-2"></i>
                    Beroperasi <strong>{{ $dailyStats->count() }}</strong> hari dalam bulan ini
                </p>
            </div>
        </div>
    </div>
</div>

@else
<!-- EMPTY STATE -->
<div class="card shadow">
    <div class="card-body text-center py-5">
        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">Tidak Ada Data</h4>
        <p class="text-muted">
            Tidak ada kunjungan pada bulan {{ $selectedMonth->isoFormat('MMMM YYYY') }}
        </p>
        <a href="{{ route('reports.monthly', ['month' => now()->format('Y-m')]) }}" class="btn btn-primary mt-3">
            <i class="fas fa-calendar me-2"></i>Lihat Bulan Ini
        </a>
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
    
    .progress {
        background-color: #e9ecef;
    }
    
    .progress-bar {
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
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

        .progress {
            border: 1px solid #ddd;
        }

        .progress-bar {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function exportToPDF() {
    alert('Fitur export PDF akan segera hadir!');
    // Implementasi export PDF bisa menggunakan library seperti dompdf
}
</script>
@endpush