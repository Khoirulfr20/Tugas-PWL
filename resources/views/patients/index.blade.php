<!-- resources/views/patients/index.blade.php -->
@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2 text-primary"></i>
        Data Pasien
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Pasien Baru
        </a>
    </div>
</div>

<!-- SEARCH & FILTER SECTION -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter me-2"></i>Pencarian & Filter
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('patients.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Pasien</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Nama, No. Pasien, atau Telepon" 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="">Semua</option>
                    <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">
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

<!-- PATIENTS TABLE -->
<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Pasien ({{ $patients->total() }})
        </h6>
        <span class="badge bg-primary">Total: {{ $patients->total() }} pasien</span>
    </div>
    <div class="card-body">
        @if($patients->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">No. Pasien</th>
                        <th width="20%">Nama</th>
                        <th width="10%">Jenis Kelamin</th>
                        <th width="8%">Umur</th>
                        <th width="12%">Telepon</th>
                        <th width="15%">Tanggal Daftar</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $index => $patient)
                    <tr>
                        <td class="text-center">{{ $patients->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $patient->patient_number }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-2">
                                    <div class="avatar-circle bg-primary text-white">
                                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                                    </div>
                                </div>
                                <strong>{{ $patient->name }}</strong>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-{{ $patient->gender === 'L' ? 'mars text-primary' : 'venus text-danger' }} me-1"></i>
                            {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td>{{ $patient->age ?? '-' }} tahun</td>
                        <td>
                            <i class="fas fa-phone me-1 text-muted"></i>
                            {{ $patient->phone }}
                        </td>
                        <td>
                            <small>
                                {{ $patient->created_at->format('d M Y, H:i') }}
                                <br>
                                <span class="text-muted">{{ $patient->created_at->diffForHumans() }}</span>
                            </small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('patients.show', $patient) }}" 
                                   class="btn btn-info" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('patients.edit', $patient) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('queues.create') }}?patient_id={{ $patient->id }}" 
                                   class="btn btn-success" 
                                   title="Buat Antrian">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <form action="{{ route('patients.destroy', $patient) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus pasien {{ $patient->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $patients->links() }}
        </div>
        @else
        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Data Pasien</h4>
            <p class="text-muted">Mulai tambahkan pasien baru untuk memulai</p>
            <a href="{{ route('patients.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i>Tambah Pasien Pertama
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
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }
    
    @media print {
        .btn-toolbar, .btn-group, .card-header {
            display: none !important;
        }
    }
</style>
@endpush