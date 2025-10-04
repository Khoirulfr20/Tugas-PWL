<!-- resources/views/users/index.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users-cog me-2 text-primary"></i>
        Kelola User / Akun
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Tambah User Baru
        </a>
    </div>
</div>

<!-- STATISTICS ROW -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total User
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $users->total() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Admin
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $users->where('role', 'admin')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Petugas
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $users->where('role', 'petugas')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Aktif
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $users->where('is_active', true)->count() }}
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
        <form method="GET" action="{{ route('users.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari User</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Nama atau email..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ request('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- USERS TABLE -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama</th>
                        <th width="25%">Email</th>
                        <th width="12%">Role</th>
                        <th width="10%">Status</th>
                        <th width="13%">Terakhir Login</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td class="text-center">{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2">
                                    <div class="avatar-circle bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-info ms-1">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-envelope me-1 text-muted"></i>
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <i class="fas fa-check-circle text-success ms-1" title="Email Verified"></i>
                            @endif
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">
                                    <i class="fas fa-crown me-1"></i>Admin
                                </span>
                            @else
                                <span class="badge bg-primary">
                                    <i class="fas fa-user-md me-1"></i>Petugas
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->last_login_at)
                                <small>{{ $user->last_login_at->diffForHumans() }}</small>
                            @else
                                <small class="text-muted">Belum pernah</small>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirmDelete('{{ $user->name }}', {{ $user->medicalRecords->count() ?? 0 }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary btn-sm" disabled title="Tidak dapat menghapus akun sendiri">
                                    <i class="fas fa-ban"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $users->links() }}
        </div>
        @else
        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada User</h4>
            <p class="text-muted">Mulai tambahkan user baru untuk mengelola aplikasi</p>
            <a href="{{ route('users.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-user-plus me-2"></i>Tambah User Pertama
            </a>
        </div>
        @endif
    </div>
</div>

<!-- INFO ALERT -->
<div class="alert alert-info mt-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Catatan Penting:</strong>
    <ul class="mb-0 mt-2">
        <li><strong>Admin</strong> memiliki akses penuh ke semua fitur termasuk kelola user dan master data</li>
        <li><strong>Petugas</strong> hanya dapat mengelola pasien, antrian, dan rekam medis</li>
        <li>User yang tidak aktif tidak dapat login ke sistem</li>
        <li>Anda tidak dapat menghapus akun Anda sendiri</li>
    </ul>
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
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(userName, recordCount) {
    let message = `Yakin ingin menghapus user "${userName}"?\n\n`;
    
    if (recordCount > 0) {
        message += `User ini memiliki ${recordCount} rekam medis.\n`;
        message += `Rekam medis akan tetap tersimpan dengan nama dokter ini.\n\n`;
    }
    
    message += `Tindakan ini tidak dapat dibatalkan!`;
    
    return confirm(message);
}
</script>
@endpush