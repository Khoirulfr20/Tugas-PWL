<!-- resources/views/reports/index.blade.php -->
@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-chart-line me-2 text-primary"></i>
        Laporan & Statistik
    </h1>
</div>

<!-- INTRO SECTION -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Sistem Pelaporan
                        </h4>
                        <p class="text-muted mb-0">
                            Akses berbagai jenis laporan untuk analisis data rekam medis, riwayat pasien, 
                            dan statistik kunjungan. Semua laporan dapat dicetak atau diexport ke format PDF.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <i class="fas fa-file-alt fa-5x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- REPORT MENU CARDS -->
<div class="row">
    <!-- 1. RIWAYAT PASIEN -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card shadow h-100 report-card">
            <div class="card-body text-center p-4">
                <div class="report-icon mb-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-history fa-3x text-white"></i>
                    </div>
                </div>
                <h4 class="mb-3">Riwayat Pasien</h4>
                <p class="text-muted mb-4">
                    Lihat riwayat lengkap rekam medis per pasien. 
                    Mencakup semua kunjungan, diagnosis, dan tindakan yang pernah dilakukan.
                </p>
                <div class="d-grid gap-2">
                    <a href="{{ route('reports.patient-history') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Buka Laporan
                    </a>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-check-circle me-1"></i>Export PDF
                        <i class="fas fa-check-circle ms-2 me-1"></i>Timeline View
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. LAPORAN HARIAN -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card shadow h-100 report-card">
            <div class="card-body text-center p-4">
                <div class="report-icon mb-3">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-calendar-day fa-3x text-white"></i>
                    </div>
                </div>
                <h4 class="mb-3">Laporan Harian</h4>
                <p class="text-muted mb-4">
                    Statistik kunjungan dan tindakan per hari. 
                    Lihat total pasien, pemeriksaan, dan pendapatan harian.
                </p>
                <div class="d-grid gap-2">
                    <a href="{{ route('reports.daily') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-calendar-alt me-2"></i>Buka Laporan
                    </a>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-check-circle me-1"></i>Filter Tanggal
                        <i class="fas fa-check-circle ms-2 me-1"></i>Export Data
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. LAPORAN BULANAN -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card shadow h-100 report-card">
            <div class="card-body text-center p-4">
                <div class="report-icon mb-3">
                    <div class="icon-circle bg-info">
                        <i class="fas fa-calendar-alt fa-3x text-white"></i>
                    </div>
                </div>
                <h4 class="mb-3">Laporan Bulanan</h4>
                <p class="text-muted mb-4">
                    Ringkasan statistik bulanan dengan breakdown per hari. 
                    Analisis tren kunjungan dan pendapatan per bulan.
                </p>
                <div class="d-grid gap-2">
                    <a href="{{ route('reports.monthly') }}" class="btn btn-info btn-lg">
                        <i class="fas fa-chart-bar me-2"></i>Buka Laporan
                    </a>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-check-circle me-1"></i>Charts & Graphs
                        <i class="fas fa-check-circle ms-2 me-1"></i>Comparison
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. LAPORAN TINDAKAN -->
    <div class="col-lg-6 col-md-6 mb-4">
        <div class="card shadow h-100 report-card">
            <div class="card-body text-center p-4">
                <div class="report-icon mb-3">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-procedures fa-3x text-white"></i>
                    </div>
                </div>
                <h4 class="mb-3">Laporan Tindakan</h4>
                <p class="text-muted mb-4">
                    Statistik tindakan medis yang paling sering dilakukan. 
                    Analisis popularitas dan pendapatan per tindakan.
                </p>
                <div class="d-grid gap-2">
                    <button class="btn btn-warning btn-lg" disabled>
                        <i class="fas fa-hourglass-half me-2"></i>Coming Soon
                    </button>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>Dalam Pengembangan
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QUICK STATS -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Statistik Keseluruhan
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                            <h3 class="mb-0">{{ $stats['total_patients'] ?? 0 }}</h3>
                            <small class="text-muted">Total Pasien</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <i class="fas fa-file-medical fa-2x text-success mb-2"></i>
                            <h3 class="mb-0">{{ $stats['total_records'] ?? 0 }}</h3>
                            <small class="text-muted">Total Rekam Medis</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                            <h3 class="mb-0">{{ $stats['this_month'] ?? 0 }}</h3>
                            <small class="text-muted">Kunjungan Bulan Ini</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-item">
                            <i class="fas fa-procedures fa-2x text-warning mb-2"></i>
                            <h3 class="mb-0">{{ $stats['total_treatments'] ?? 0 }}</h3>
                            <small class="text-muted">Total Tindakan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- INFO CARDS -->
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow border-info h-100">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-lightbulb me-2"></i>Tips Menggunakan Laporan
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li class="mb-2">Gunakan filter tanggal untuk melihat data periode tertentu</li>
                    <li class="mb-2">Klik tombol Print atau PDF untuk menyimpan laporan</li>
                    <li class="mb-2">Laporan dapat diakses kapan saja sesuai kebutuhan</li>
                    <li class="mb-0">Data diupdate secara real-time setiap ada input baru</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow border-success h-100">
            <div class="card-header bg-success text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-star me-2"></i>Fitur Laporan
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Export ke PDF untuk arsip digital
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Print friendly format
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Filter dan pencarian fleksibel
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        Visual charts dan graphs
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .report-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .report-card:hover {
        transform: translateY(-10px);
        border-color: #007bff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    
    .icon-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .stat-item {
        padding: 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
</style>
@endpush