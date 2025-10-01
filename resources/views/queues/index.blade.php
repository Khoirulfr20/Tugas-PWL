<!-- resources/views/queues/index.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Antrian Pasien')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-list-ol me-2 text-primary"></i>
        Kelola Antrian Pasien
        <span class="badge bg-info ms-2" id="realtime-badge">
            <i class="fas fa-sync-alt"></i> Real-time
        </span>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('queues.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Antrian Baru
        </a>
    </div>
</div>

<!-- STATISTICS ROW -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Antrian Hari Ini
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-queue">
                    {{ $queues->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Menunggu
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="waiting-count">
                    {{ $queues->where('status', 'waiting')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Sedang Dilayani
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="progress-count">
                    {{ $queues->where('status', 'in_progress')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Selesai
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="completed-count">
                    {{ $queues->where('status', 'completed')->count() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER CARD -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter me-2"></i>Filter Antrian
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('queues.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="date" name="date" 
                       value="{{ request('date', today()->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="waiting" {{ request('status') === 'waiting' ? 'selected' : '' }}>Menunggu</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Sedang Dilayani</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Pasien</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Nama pasien..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('queues.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- QUEUE TABLE -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Antrian - {{ request('date', today()->format('d M Y')) }}
        </h6>
    </div>
    <div class="card-body">
        @if($queues->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="queue-table">
                <thead class="table-light">
                    <tr>
                        <th width="8%">No. Antrian</th>
                        <th width="20%">Nama Pasien</th>
                        <th width="12%">No. Pasien</th>
                        <th width="15%">Status</th>
                        <th width="25%">Keluhan</th>
                        <th width="10%">Waktu</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="queue-table-body">
                    @foreach($queues as $queue)
                    <tr data-queue-id="{{ $queue->id }}" class="queue-row">
                        <td class="text-center">
                            <span class="badge bg-dark fs-5">{{ $queue->queue_number }}</span>
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
                                    <small class="text-muted">
                                        <i class="fas fa-{{ $queue->patient->gender === 'L' ? 'mars' : 'venus' }}"></i>
                                        {{ $queue->patient->age }} tahun
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $queue->patient->patient_number }}</span>
                        </td>
                        <td>
                            <span class="badge badge-status 
                                {{ $queue->status === 'waiting' ? 'bg-warning' : 
                                   ($queue->status === 'in_progress' ? 'bg-info' : 
                                   ($queue->status === 'completed' ? 'bg-success' : 'bg-secondary')) }}">
                                @switch($queue->status)
                                    @case('waiting')
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                        @break
                                    @case('in_progress')
                                        <i class="fas fa-spinner fa-spin me-1"></i>Sedang Dilayani
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
                            <small>{{ $queue->complaint ?? '-' }}</small>
                        </td>
                        <td>
                            <small class="queue-time">
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
                            <div class="btn-group btn-group-sm action-buttons">
                                @if($queue->status === 'waiting')
                                    <button class="btn btn-success" 
                                            onclick="updateQueueStatus({{ $queue->id }}, 'in_progress')"
                                            title="Panggil Pasien">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button class="btn btn-danger" 
                                            onclick="updateQueueStatus({{ $queue->id }}, 'cancelled')"
                                            title="Batalkan">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @elseif($queue->status === 'in_progress')
                                    <button class="btn btn-info" 
                                            onclick="updateQueueStatus({{ $queue->id }}, 'completed')"
                                            title="Selesai">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-danger" 
                                            onclick="updateQueueStatus({{ $queue->id }}, 'cancelled')"
                                            title="Batalkan">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <i class="fas fa-calendar-check fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Antrian</h4>
            <p class="text-muted">Belum ada antrian untuk tanggal ini</p>
            <a href="{{ route('queues.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i>Buat Antrian Baru
            </a>
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
    
    .queue-row {
        transition: all 0.3s ease;
    }
    
    .queue-row:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }
    
    .badge-status {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    #realtime-badge i {
        animation: pulse 2s infinite;
    }
    
    .queue-row-highlight {
        animation: highlightRow 2s ease-out;
    }
    
    @keyframes highlightRow {
        0% { background-color: #fff3cd; }
        100% { background-color: transparent; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time updates dengan Pusher
    @if(config('broadcasting.default') === 'pusher')
    try {
        const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
            cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}'
        });

        const channel = pusher.subscribe('queue-updates');
        channel.bind('queue.updated', function(data) {
            updateQueueRowRealtime(data);
            updateStatistics();
        });
    } catch (error) {
        console.log('Pusher not configured:', error);
    }
    @endif
});

function updateQueueStatus(queueId, status) {
    const confirmMessages = {
        'in_progress': 'Panggil pasien ini untuk pemeriksaan?',
        'completed': 'Tandai pemeriksaan sebagai selesai?',
        'cancelled': 'Batalkan antrian ini?'
    };

    if (confirm(confirmMessages[status])) {
        // Show loading
        const row = document.querySelector(`tr[data-queue-id="${queueId}"]`);
        const actionCell = row.querySelector('.action-buttons');
        actionCell.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

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
                updateQueueRowLocal(row, status);
                updateStatistics();
            } else {
                showAlert('danger', 'Terjadi kesalahan saat memperbarui status');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat memperbarui status');
            location.reload();
        });
    }
}

function updateQueueRowLocal(row, status) {
    const statusCell = row.querySelector('.badge-status');
    const actionCell = row.querySelector('.action-buttons');
    
    // Update status badge
    updateStatusBadge(statusCell, status);
    
    // Update action buttons
    updateActionButtons(actionCell, row.dataset.queueId, status);
    
    // Add highlight effect
    row.classList.add('queue-row-highlight');
    setTimeout(() => row.classList.remove('queue-row-highlight'), 2000);
}

function updateQueueRowRealtime(data) {
    const row = document.querySelector(`tr[data-queue-id="${data.id}"]`);
    if (row) {
        const statusCell = row.querySelector('.badge-status');
        const timeCell = row.querySelector('.queue-time');
        const actionCell = row.querySelector('.action-buttons');
        
        updateStatusBadge(statusCell, data.status);
        updateActionButtons(actionCell, data.id, data.status);
        
        row.classList.add('queue-row-highlight');
        setTimeout(() => row.classList.remove('queue-row-highlight'), 2000);
    }
}

function updateStatusBadge(badge, status) {
    badge.className = 'badge badge-status';
    
    const statusConfig = {
        'waiting': { class: 'bg-warning', icon: 'fas fa-clock', text: 'Menunggu' },
        'in_progress': { class: 'bg-info', icon: 'fas fa-spinner fa-spin', text: 'Sedang Dilayani' },
        'completed': { class: 'bg-success', icon: 'fas fa-check', text: 'Selesai' },
        'cancelled': { class: 'bg-secondary', icon: 'fas fa-times', text: 'Dibatalkan' }
    };
    
    const config = statusConfig[status];
    badge.classList.add(config.class);
    badge.innerHTML = `<i class="${config.icon} me-1"></i>${config.text}`;
}

function updateActionButtons(cell, queueId, status) {
    let buttonsHtml = '<div class="btn-group btn-group-sm action-buttons">';
    
    if (status === 'waiting') {
        buttonsHtml += `
            <button class="btn btn-success" onclick="updateQueueStatus(${queueId}, 'in_progress')" title="Panggil">
                <i class="fas fa-play"></i>
            </button>
            <button class="btn btn-danger" onclick="updateQueueStatus(${queueId}, 'cancelled')" title="Batalkan">
                <i class="fas fa-times"></i>
            </button>
        `;
    } else if (status === 'in_progress') {
        buttonsHtml += `
            <button class="btn btn-info" onclick="updateQueueStatus(${queueId}, 'completed')" title="Selesai">
                <i class="fas fa-check"></i>
            </button>
            <button class="btn btn-danger" onclick="updateQueueStatus(${queueId}, 'cancelled')" title="Batalkan">
                <i class="fas fa-times"></i>
            </button>
        `;
    } else {
        buttonsHtml += '<span class="badge bg-secondary">-</span>';
    }
    
    buttonsHtml += '</div>';
    cell.innerHTML = buttonsHtml;
}

function updateStatistics() {
    fetch(window.location.href, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('total-queue').textContent = data.total;
        document.getElementById('waiting-count').textContent = data.waiting;
        document.getElementById('progress-count').textContent = data.in_progress;
        document.getElementById('completed-count').textContent = data.completed;
    });
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.querySelector('main > div');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
}
</script>
@endpush