<!-- resources/views/treatments/index.blade.php -->
@extends('layouts.app')

@section('title', 'Master Data Tindakan')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-procedures me-2 text-primary"></i>
        Master Data Tindakan Medis
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('treatments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Tindakan Baru
        </a>
    </div>
</div>

<!-- STATISTICS ROW -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Tindakan
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $treatments->total() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Aktif
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $treatments->where('is_active', true)->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Tidak Aktif
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $treatments->where('is_active', false)->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Rata-rata Harga
                </div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">
                    Rp {{ number_format($treatments->avg('price'), 0, ',', '.') }}
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
        <form method="GET" action="{{ route('treatments.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Tindakan</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Kode atau nama tindakan..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="code" {{ request('sort') === 'code' ? 'selected' : '' }}>Kode</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('treatments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TREATMENTS TABLE -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tindakan Medis</h6>
    </div>
    <div class="card-body">
        @if($treatments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Kode</th>
                        <th width="25%">Nama Tindakan</th>
                        <th width="30%">Deskripsi</th>
                        <th width="12%">Harga</th>
                        <th width="8%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($treatments as $index => $treatment)
                    <tr>
                        <td class="text-center">{{ $treatments->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-dark">{{ $treatment->code }}</span>
                        </td>
                        <td>
                            <strong>{{ $treatment->name }}</strong>
                        </td>
                        <td>
                            <small class="text-muted">{{ Str::limit($treatment->description, 80) }}</small>
                        </td>
                        <td>
                            <strong class="text-success">Rp {{ number_format($treatment->price, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            @if($treatment->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times me-1"></i>Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('treatments.edit', $treatment) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('treatments.destroy', $treatment) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus tindakan {{ $treatment->name }}?')">
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
            {{ $treatments->links() }}
        </div>
        @else
        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <i class="fas fa-procedures fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Tindakan</h4>
            <p class="text-muted">Mulai tambahkan master data tindakan medis</p>
            <a href="{{ route('treatments.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i>Tambah Tindakan Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush