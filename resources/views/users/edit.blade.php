<!-- resources/views/users/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-edit me-2 text-primary"></i>
        Edit User
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- INFO BANNER -->
<div class="row mb-4">
    <div class="col-lg-8 mx-auto">
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong>Edit User:</strong> {{ $user->name }}
                    <br>
                    <small>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">{{ ucfirst($user->role) }}</span>
                        @if($user->id === auth()->id())
                            <span class="badge bg-warning ms-1">Ini adalah akun Anda</span>
                        @endif
                    </small>
                </div>
            </div>
        </div>

        @if($user->id === auth()->id())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian:</strong> Anda sedang mengedit akun Anda sendiri. Berhati-hatilah saat mengubah role atau menonaktifkan akun.
        </div>
        @endif
    </div>
</div>

<!-- FORM CARD -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- INFORMASI AKUN -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- UBAH PASSWORD -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-key me-2"></i>Ubah Password
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Kosongkan field password jika tidak ingin mengubah password
                    </div>

                    <div class="row">
                        <!-- Password Baru -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 6 karakter">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ketik ulang password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye" id="toggleIconConfirm"></i>
                                </button>
                            </div>
                            <small id="password-match-message" class="text-muted"></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROLE & STATUS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-shield-alt me-2"></i>Role & Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Role / Hak Akses <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check form-check-lg">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="role" 
                                           id="roleAdmin" 
                                           value="admin" 
                                           {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="roleAdmin">
                                        <strong class="text-danger">
                                            <i class="fas fa-crown me-1"></i>Admin
                                        </strong>
                                        <br>
                                        <small class="text-muted">Akses penuh ke semua fitur</small>
                                    </label>
                                </div>
                                <div class="form-check form-check-lg">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="role" 
                                           id="rolePetugas" 
                                           value="petugas" 
                                           {{ old('role', $user->role) === 'petugas' ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="rolePetugas">
                                        <strong class="text-primary">
                                            <i class="fas fa-user-md me-1"></i>Petugas
                                        </strong>
                                        <br>
                                        <small class="text-muted">Akses ke pasien, antrian, dan rekam medis</small>
                                    </label>
                                </div>
                            </div>
                            @error('role')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status Akun <span class="text-danger">*</span>
                            </label>
                            <div class="card border-{{ $user->is_active ? 'success' : 'secondary' }}">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong id="status-label" class="text-{{ $user->is_active ? 'success' : 'secondary' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </strong>
                                        </label>
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        User yang tidak aktif tidak dapat login
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- USAGE STATISTICS -->
            @if($user->medicalRecords->count() > 0)
            <div class="card shadow mb-4 border-info">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Total Rekam Medis</small>
                            <h4 class="mb-0 text-primary">{{ $user->medicalRecords->count() }}</h4>
                            <small class="text-muted">rekam medis</small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Terakhir Input</small>
                            <h6 class="mb-0">
                                {{ $user->medicalRecords()->latest()->first()?->created_at?->format('d M Y') ?? '-' }}
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Terakhir Login</small>
                            <h6 class="mb-0">
                                {{ $user->last_login_at?->format('d M Y, H:i') ?? 'Belum pernah' }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- CHANGE LOG -->
            <div class="card shadow mb-4 border-warning">
                <div class="card-header bg-warning text-dark py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-history me-2"></i>Informasi Perubahan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Dibuat Pada:</small>
                            <strong>{{ $user->created_at->format('d F Y, H:i') }}</strong>
                            <br>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Terakhir Diubah:</small>
                            <strong>{{ $user->updated_at->format('d F Y, H:i') }}</strong>
                            <br>
                            <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- DANGER ZONE -->
        @if($user->id !== auth()->id())
        <div class="card shadow mb-4 border-danger">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Hapus User</strong>
                        <p class="text-muted mb-0">
                            @if($user->medicalRecords->count() > 0)
                                User ini memiliki {{ $user->medicalRecords->count() }} rekam medis. 
                                Rekam medis akan tetap tersimpan tetapi tanpa nama dokter.
                            @else
                                User ini belum memiliki rekam medis dan dapat dihapus dengan aman.
                            @endif
                        </p>
                    </div>
                    <form action="{{ route('users.destroy', $user) }}" 
                          method="POST" 
                          onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Hapus User
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            <i class="fas fa-ban me-2"></i>
            <strong>Tidak dapat menghapus:</strong> Anda tidak dapat menghapus akun Anda sendiri.
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-check-lg {
        padding: 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .form-check-lg:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const togglePassword = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const toggleIconConfirm = document.getElementById('toggleIconConfirm');
    const passwordMatchMessage = document.getElementById('password-match-message');
    const statusCheckbox = document.getElementById('is_active');
    const statusLabel = document.getElementById('status-label');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
    });

    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
        passwordConfirmInput.type = type;
        toggleIconConfirm.classList.toggle('fa-eye');
        toggleIconConfirm.classList.toggle('fa-eye-slash');
    });

    // Password match validation
    function checkPasswordMatch() {
        if (!passwordInput.value && !passwordConfirmInput.value) {
            passwordMatchMessage.textContent = '';
            return;
        }

        if (passwordConfirmInput.value === '') {
            passwordMatchMessage.textContent = '';
            return;
        }

        if (passwordInput.value === passwordConfirmInput.value) {
            passwordMatchMessage.textContent = '✓ Password cocok';
            passwordMatchMessage.className = 'text-success';
        } else {
            passwordMatchMessage.textContent = '✗ Password tidak cocok';
            passwordMatchMessage.className = 'text-danger';
        }
    }

    passwordInput.addEventListener('input', checkPasswordMatch);
    passwordConfirmInput.addEventListener('input', checkPasswordMatch);

    // Status toggle
    statusCheckbox.addEventListener('change', function() {
        if (this.checked) {
            statusLabel.textContent = 'Aktif';
            statusLabel.className = 'text-success';
        } else {
            statusLabel.textContent = 'Tidak Aktif';
            statusLabel.className = 'text-secondary';
        }
    });
});

function confirmDelete() {
    const userName = '{{ $user->name }}';
    const recordCount = {{ $user->medicalRecords->count() }};
    
    let message = `Yakin ingin menghapus user "${userName}"?\n\n`;
    
    if (recordCount > 0) {
        message += `User ini memiliki ${recordCount} rekam medis.\n`;
        message += `Rekam medis akan tetap tersimpan.\n\n`;
    }
    
    message += `Tindakan ini tidak dapat dibatalkan!`;
    
    return confirm(message);
}
</script>
@endpush