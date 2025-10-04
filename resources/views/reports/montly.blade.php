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
            <button type="button" class="btn btn-danger">
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
                               value="{{ request('month', $selectedMonth->format('Y-m')) }}"
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
                    Periode: {{ $selectedMonth->startOfMonth()->format('d M Y') }} - {{ $selectedMonth->endOfMonth()->format('d M Y') }}
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
                    Total Pasien
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $stats['total_patients'] }}
                </div>
                <small class="text-muted">Pasien Unik</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-success h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Total Pemeriksaan
                </div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    {{ $stats['total_examinations'] }}
                </div>
                <small class="text-muted">Rekam Medis</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-warning h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Total Pendapatan
                </div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </div>
                <small class="text-muted">Semua Tindakan</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-info h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Rata-rata/Hari
                </div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                    {{ number_format($stats['avg_per_day'], 1) }}
                </div>
                <small class="text-muted">Pemeriksaan</small>
            </div>
        </div>
    </div>
</div>

<!-- DAILY BREAKDOWN -->
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
                        <th width="15%">Pasien</th>
                        <th width="15%">Pemeriksaan</th>
                        <th width="20%">Pendapatan</th>
                        <th width="25%">Visual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyStats as $stat)
                    <tr>
                        <td><strong>{{ \Carbon\Carbon::parse($stat['date'])->format('d') }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($stat['date'])->isoFormat('dddd') }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $stat['patients'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $stat['examinations'] }}</span>
                        </td>
                        <td class="text-end">
                            <strong class="text-success">
                                Rp {{ number_format($stat['revenue'], 0, ',', '.') }}
                            </strong>
                        </td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" 
                                     role="progressbar" 
                                     style="width: {{ $stats['total_examinations'] > 0 ? ($stat['examinations'] / $stats['total_examinations'] * 100) : 0 }}%"
                                     aria-valuenow="{{ $stat['examinations'] }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $stats['total_examinations'] }}">
                                    {{ $stat['examinations'] }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="2" class="text-end"><strong>TOTAL:</strong></td>
                        <td class="text-center">
                            <strong class="badge bg-primary">{{ $stats['total_patients'] }}</strong>
                        </td>
                        <td class="text-center">
                            <strong class="badge bg-success">{{ $stats['total_examinations'] }}</strong>
                        </td>
                        <td class="text-end">
                            <strong class="text-success">
                                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                            </strong>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- COMPARISON WITH PREVIOUS MONTH -->
@if(isset($comparison))
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-line me-2"></i>Perbandingan dengan Bulan Sebelumnya
        </h6>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-4">
                <h6 class="text-muted">Pasien</h6>
                <h3 class="mb-2">
                    @if($comparison['patients_diff'] > 0)
                        <i class="fas fa-arrow-up text-success"></i>
                        <span class="text-success">+{{ $comparison['patients_diff'] }}</span>
                    @elseif($comparison['patients_diff'] < 0)
                        <i class="fas fa-arrow-down text-danger"></i>
                        <span class="text-danger">{{ $comparison['patients_diff'] }}</span>
                    @else
                        <i class="fas fa-minus text-secondary"></i>
                        <span class="text-secondary">0</span>
                    @endif
                </h3>
                <small class="text-muted">
                    {{ abs($comparison['patients_percent']) }}%
                    {{ $comparison['patients_diff'] > 0 ? 'Naik' : ($comparison['patients_diff'] < 0 ? 'Turun' : 'Sama') }}
                </small>
            </div>

            <div class="col-md-4">
                <h6 class="text-muted">Pemeriksaan</h6>
                <h3 class="mb-2">
                    @if($comparison['examinations_diff'] > 0)
                        <i class="fas fa-arrow-up text-success"></i>
                        <span class="text-success">+{{ $comparison['examinations_diff'] }}</span>
                    @elseif($comparison['examinations_diff'] < 0)
                        <i class="fas fa-arrow-down text-danger"></i>
                        <span class="text-danger">{{ $comparison['examinations_diff'] }}</span>
                    @else
                        <i class="fas fa-minus text-secondary"></i>
                        <span class="text-secondary">0</span>
                    @endif
                </h3>
                <small class="text-muted">
                    {{ abs($comparison['examinations_percent']) }}%
                    {{ $comparison['examinations_diff'] > 0 ? 'Naik' : ($comparison['examinations_diff'] < 0 ? 'Turun' : 'Sama') }}
                </small>
            </div>

            <div class="col-md-4">
                <h6 class="text-muted">Pendapatan</h6>
                <h3 class="mb-2">
                    @if($comparison['revenue_diff'] > 0)
                        <i class="fas fa-arrow-up text-success"></i>
                        <span class="text-success">+Rp {{ number_format($comparison['revenue_diff'], 0, ',', '.') }}</span>
                    @elseif($comparison['revenue_diff'] < 0)
                        <i class="fas fa-arrow-down text-danger"></i>
                        <span class="text-danger">-Rp {{ number_format(abs($comparison['revenue_diff']), 0, ',', '.') }}</span>
                    @else
                        <i class="fas fa-minus text-secondary"></i>
                        <span class="text-secondary">Rp 0</span>
                    @endif
                </h3>
                <small class="text-muted">
                    {{ abs($comparison['revenue_percent']) }}%
                    {{ $comparison['revenue_diff'] > 0 ? 'Naik' : ($comparison['revenue_diff'] < 0 ? 'Turun' : 'Sama') }}
                </small>
            </div>
        </div>
    </div>
</div>
@endif

<!-- INSIGHTS -->
<div class="row">
    <div class="col-md-6">
        <div class="card shadow border-success h-100">
            <div class="card-header bg-success text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-pie me-2"></i>Insights
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li class="mb-2">
                        Hari tersibuk: <strong>{{ $insights['busiest_day'] ?? '-' }}</strong>
                        ({{ $insights['busiest_day_count'] ?? 0 }} pemeriksaan)
                    </li>
                    <li class="mb-2">
                        Hari terlenggang: <strong>{{ $insights['slowest_day'] ?? '-' }}</strong>
                        ({{ $insights['slowest_day_count'] ?? 0 }} pemeriksaan)
                    </li>
                    <li class="mb-0">
                        Rata-rata pemeriksaan per hari kerja: 
                        <strong>{{ number_format($stats['avg_per_day'], 1) }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow border-info h-100">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-lightbulb me-2"></i>Summary
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Total <strong>{{ $stats['total_examinations'] }}</strong> pemeriksaan dilakukan
                </p>
                <p class="mb-2">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Melayani <strong>{{ $stats['total_patients'] }}</strong> pasien unik
                </p>
                <p class="mb-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Pendapatan total <strong>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</strong>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress {
        background-color: #e9ecef;
    }
    
    .progress-bar {
        background-color: #007bff;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    @media print {
        .btn-toolbar, .btn {
            display: none !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }
    }
</style>
@endpush