{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2 text-primary"></i>
        Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download"></i> Export
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
        <a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Pasien
        </a>
    </div>
</div>

<!-- STATISTICS CARDS ROW -->
<div class="row mb-4">
    <!-- Total Pasien -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pasien
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['total_patients']) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrian Hari Ini -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Antrian Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="today-queue-count">
                            {{ number_format($stats['today_queue']) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list-ol fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sedang Menunggu -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="waiting-queue-count">
                            {{ number_format($stats['waiting_queue']) }}
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Antrian aktif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemeriksaan Hari Ini -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pemeriksaan Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['today_examinations']) }}
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-stethoscope me-1"></i>
                            Telah selesai
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DASHBOARD CONTENT ROW -->
<div class="row">
    <!-- PASIEN TERBARU CARD -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-plus me-2"></i>
                    Pasien Terbaru
                </h6>
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($recent_patients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Pasien</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_patients as $patient)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $patient->patient_number }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <div class="avatar-circle bg-primary text-white">
                                                {{ strtoupper(substr($patient->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <strong>{{ $patient->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-{{ $patient->gender === 'L' ? 'mars' : 'venus' }} me-1"></i>
                                                {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $patient->age ?? '-' }} tahun</td>
                                <td>
                                    <small>
                                        {{ $patient->created_at->format('d M Y') }}
                                        <br>
                                        <span class="text-muted">{{ $patient->created_at->diffForHumans() }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('patients.show', $patient) }}" 
                                           class="btn btn-outline-primary btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('queues.create') }}?patient_id={{ $patient->id }}" 
                                           class="btn btn-outline-success btn-sm" title="Buat Antrian">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada pasien terdaftar</p>
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Pasien Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ANTRIAN HARI INI CARD -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list-alt me-2"></i>
                    Antrian Hari Ini
                </h6>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <small class="text-muted">
                            <i class="fas fa-sync-alt me-1" id="refresh-icon"></i>
                            Auto-refresh (60s)
                        </small>
                    </div>
                    <a href="{{ route('queues.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> Kelola Antrian
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($today_queue->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="queue-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pasien</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="queue-table-body">
                            @foreach($today_queue as $queue)
                            <tr data-queue-id="{{ $queue->id }}" class="queue-row">
                                <td>
                                    <span class="badge bg-dark fs-6">{{ $queue->queue_number }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar-circle bg-info text-white">
                                                {{ strtoupper(substr($queue->patient->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <strong>{{ $queue->patient->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $queue->patient->patient_number }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-status 
                                        {{ $queue->status === 'waiting' ? 'bg-warning text-dark' : 
                                           ($queue->status === 'in_progress' ? 'bg-info' : 
                                           ($queue->status === 'completed' ? 'bg-success' : 'bg-secondary')) }}">
                                        @switch($queue->status)
                                            @case('waiting')
                                                <i class="fas fa-clock me-1"></i>Menunggu
                                                @break
                                            @case('in_progress')
                                                <i class="fas fa-spinner me-1"></i>Sedang Dilayani
                                                @break
                                            @case('completed')
                                                <i class="fas fa-check me-1"></i>Selesai
                                                @break
                                            @case('cancelled')
                                                <i class="fas fa-times me-1"></i>Dibatalkan
                                                @break
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        @if($queue->called_at)
                                            <span class="text-success">
                                                <i class="fas fa-play me-1"></i>
                                                {{ $queue->called_at->format('H:i') }}
                                            </span>
                                        @elseif($queue->completed_at)
                                            <span class="text-info">
                                                <i class="fas fa-check me-1"></i>
                                                {{ $queue->completed_at->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $queue->created_at->format('H:i') }}
                                            </span>
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if($queue->status === 'waiting')
                                            <button class="btn btn-success btn-sm" 
                                                    onclick="updateQueueStatus({{ $queue->id }}, 'in_progress')"
                                                    title="Panggil Pasien">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        @elseif($queue->status === 'in_progress')
                                            <button class="btn btn-info btn-sm" 
                                                    onclick="updateQueueStatus({{ $queue->id }}, 'completed')"
                                                    title="Selesai">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        
                                        @if($queue->status !== 'completed' && $queue->status !== 'cancelled')
                                            <button class="btn btn-danger btn-sm" 
                                                    onclick="updateQueueStatus({{ $queue->id }}, 'cancelled')"
                                                    title="Batalkan">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada antrian hari ini</p>
                    <a href="{{ route('queues.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Buat Antrian Baru
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- QUICK ACTIONS ROW -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('patients.create') }}" class="btn btn-outline-primary btn-lg w-100 h-100">
                            <div class="text-center py-3">
                                <i class="fas fa-user-plus fa-2x mb-2"></i>
                                <br>
                                <strong>Pasien Baru</strong>
                                <br>
                                <small class="text-muted">Daftarkan pasien baru</small>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('queues.create') }}" class="btn btn-outline-success btn-lg w-100 h-100">
                            <div class="text-center py-3">
                                <i class="fas fa-list-plus fa-2x mb-2"></i>
                                <br>
                                <strong>Antrian Baru</strong>
                                <br>
                                <small class="text-muted">Tambah ke antrian</small>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-info btn-lg w-100 h-100">
                            <div class="text-center py-3">
                                <i class="fas fa-file-medical-alt fa-2x mb-2"></i>
                                <br>
                                <strong>Rekam Medis</strong>
                                <br>
                                <small class="text-muted">Input pemeriksaan</small>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-warning btn-lg w-100 h-100">
                            <div class="text-center py-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <br>
                                <strong>Laporan</strong>
                                <br>
                                <small class="text-muted">Lihat statistik</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Dashboard specific styles */
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
    
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
    }
    
    .queue-row {
        transition: background-color 0.3s ease;
    }
    
    .queue-row:hover {
        background-color: #f8f9fa;
    }
    
    .badge-status {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    /* Animation for refresh icon */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .spin {
        animation: spin 1s linear infinite;
    }
    
    /* Stats card improvements */
    .card.border-left-primary { border-left: 4px solid #007bff !important; }
    .card.border-left-success { border-left: 4px solid #28a745 !important; }
    .card.border-left-warning { border-left: 4px solid #ffc107 !important; }
    .card.border-left-info { border-left: 4px solid #17a2b8 !important; }
    .card.border-left-danger { border-left: 4px solid #dc3545 !important; }
    
    /* Quick action buttons */
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-info:hover,
    .btn-outline-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
        .h5 { font-size: 1.1rem; }
        .fa-2x { font-size: 1.5em !important; }
        .card-body { padding: 1rem; }
        .btn-group-sm .btn { padding: 0.125rem 0.25rem; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ✅ AUTO-REFRESH STATISTICS SETIAP 60 DETIK
    setInterval(function() {
        refreshDashboardStats();
        
        // Add visual feedback
        const refreshIcon = document.getElementById('refresh-icon');
        if (refreshIcon) {
            refreshIcon.classList.add('spin');
            setTimeout(() => {
                refreshIcon.classList.remove('spin');
            }, 1000);
        }
    }, 60000); // 60 detik
});

// Function to update queue status
function updateQueueStatus(queueId, status) {
    const confirmMessages = {
        'in_progress': 'Panggil pasien ini untuk pemeriksaan?',
        'completed': 'Tandai pemeriksaan sebagai selesai?',
        'cancelled': 'Batalkan antrian ini?'
    };

    if (confirm(confirmMessages[status])) {
        fetch(`/queues/${queueId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                
                // Reload page after 1 second to see changes
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showAlert('danger', 'Terjadi kesalahan saat memperbarui status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat memperbarui status');
        });
    }
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.querySelector('main .pt-3');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
}

function refreshDashboardStats() {
    // Fetch updated stats via AJAX
    fetch('/queues/ajax-stats', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update stat numbers
        document.getElementById('today-queue-count').textContent = data.total.toLocaleString();
        document.getElementById('waiting-queue-count').textContent = data.waiting.toLocaleString();
    })
    .catch(error => {
        console.log('Stats refresh skipped:', error);
    });
}
</script>
@endpush