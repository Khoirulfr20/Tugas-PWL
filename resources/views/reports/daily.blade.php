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
            <button type="button" class="btn btn-danger" onclick="exportToPDF()">
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
                               value="{{ $date }}"
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
                    {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM YYYY') }}
                </h3>
                <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($date)->diffForHumans() }}</p>
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
                            Total Kunjungan
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_visits'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-injured fa-2x text-gray-300"></i>
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
                            Selesai
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['completed'] }}
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
                            Dibatalkan
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['cancelled'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
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
                            Pasien Unik
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ $visits->unique('patient_id')->count() }}
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

<!-- VISITS LIST -->
@if($visits->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list me-2"></i>Daftar Kunjungan
        </h6>
        <span class="badge bg-primary">{{ $visits->count() }} kunjungan</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Waktu</th>
                        <th width="10%">No. Antrian</th>
                        <th width="15%">No. Rekam Medis</th>
                        <th width="25%">Nama Pasien</th>
                        <th width="15%">Keluhan</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visits as $index => $queue)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($queue->created_at)->format('H:i') }}</td>
                        <td class="text-center">
                            <span class="badge bg-dark">{{ $queue->queue_number }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $queue->patient->medical_record_number ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $queue->patient->name ?? '-' }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ $queue->patient->gender ?? '-' }}, 
                                {{ $queue->patient->date_of_birth ? \Carbon\Carbon::parse($queue->patient->date_of_birth)->age : '-' }} tahun
                            </small>
                        </td>
                        <td>
                            <small>{{ Str::limit($queue->complaint ?? '-', 50) }}</small>
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
                        <td class="text-center">
                            @if($queue->patient_id)
                                <a href="{{ route('reports.patient-history', $queue->patient_id) }}" 
                                   class="btn btn-sm btn-info"
                                   title="Lihat Riwayat">
                                    <i class="fas fa-history"></i>
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SUMMARY BY STATUS -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Ringkasan Status
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="fas fa-check-circle text-success me-2"></i>Selesai</span>
                        <strong>{{ $stats['completed'] }} ({{ $stats['total_visits'] > 0 ? round(($stats['completed'] / $stats['total_visits']) * 100, 1) : 0 }}%)</strong>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" 
                             role="progressbar" 
                             style="width: {{ $stats['total_visits'] > 0 ? ($stats['completed'] / $stats['total_visits']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="fas fa-times-circle text-danger me-2"></i>Dibatalkan</span>
                        <strong>{{ $stats['cancelled'] }} ({{ $stats['total_visits'] > 0 ? round(($stats['cancelled'] / $stats['total_visits']) * 100, 1) : 0 }}%)</strong>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-danger" 
                             role="progressbar" 
                             style="width: {{ $stats['total_visits'] > 0 ? ($stats['cancelled'] / $stats['total_visits']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="fas fa-clock text-info me-2"></i>Lainnya</span>
                        <strong>{{ $stats['total_visits'] - $stats['completed'] - $stats['cancelled'] }}</strong>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-info" 
                             role="progressbar" 
                             style="width: {{ $stats['total_visits'] > 0 ? (($stats['total_visits'] - $stats['completed'] - $stats['cancelled']) / $stats['total_visits']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i>Jam Tersibuk
                </h6>
            </div>
            <div class="card-body">
                @php
                    $hourlyData = $visits->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->created_at)->format('H:00');
                    })->map(function($items) {
                        return $items->count();
                    })->sortDesc()->take(5);
                @endphp

                @if($hourlyData->count() > 0)
                    @foreach($hourlyData as $hour => $count)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-clock me-2"></i>{{ $hour }}</span>
                            <strong>{{ $count }} kunjungan</strong>
                        </div>
                        <div class="progress" style="height: 15px;">
                            <div class="progress-bar bg-primary" 
                                 style="width: {{ ($count / $visits->count()) * 100 }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Tidak ada data</p>
                @endif
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
        <p class="text-muted">Tidak ada kunjungan pada tanggal {{ \Carbon\Carbon::parse($date)->isoFormat('D MMMM YYYY') }}</p>
        <a href="{{ route('reports.daily', ['date' => now()->format('Y-m-d')]) }}" class="btn btn-primary mt-3">
            <i class="fas fa-calendar me-2"></i>Lihat Hari Ini
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
    
    .text-gray-300 {
        color: #dddfeb !important;
    }

    .no-gutters {
        margin-right: 0;
        margin-left: 0;
    }

    .no-gutters > .col,
    .no-gutters > [class*="col-"] {
        padding-right: 0;
        padding-left: 0;
    }
    
    @media print {
        .btn-toolbar, .btn, .no-print, .card-header .badge {
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
    // Implementasi export PDF bisa menggunakan library seperti dompdf atau snappy
}
</script>
@endpush