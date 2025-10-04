<!-- resources/views/users/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus me-2 text-primary"></i>
        Tambah User Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- FORM CARD -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <form action="{{ route('users.store') }}" method="POST" id="userForm">
            @csrf
            
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
                                   value="{{ old('name') }}" 
                                   required
                                   placeholder="Masukkan nama lengkap"
                                   autofocus>
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
                                   value="{{ old('email') }}" 
                                   required
                                   placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Email akan digunakan untuk login</small>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
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
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
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
                                           {{ old('role') === 'admin' ? 'checked' : '' }}
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
                                           {{ old('role', 'petugas') === 'petugas' ? 'checked' : '' }}
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
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong id="status-label" class="text-success">Aktif</strong>
                                        </label>
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        User yang tidak aktif tidak dapat login
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Role Info Box -->
                        <div class="col-12">
                            <div class="alert alert-info" id="role-info">
                                <strong><i class="fas fa-info-circle me-2"></i>Hak Akses Petugas:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Mengelola data pasien</li>
                                    <li>Mengelola antrian pasien</li>
                                    <li>Input & edit rekam medis</li>
                                    <li>Melihat laporan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PREVIEW CARD -->
            <div class="card shadow mb-4 border-primary">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-eye me-2"></i>Preview User
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="user-avatar-large" id="preview-avatar">
                                <div class="avatar-circle-large bg-primary text-white">
                                    U
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="mb-1" id="preview-name">Nama User</h5>
                            <p class="mb-1">
                                <i class="fas fa-envelope me-1 text-muted"></i>
                                <span id="preview-email">email@example.com</span>
                            </p>
                            <p class="mb-0">
                                <span class="badge bg-primary" id="preview-role">
                                    <i class="fas fa-user-md me-1"></i>Petugas
                                </span>
                                <span class="badge bg-success ms-1" id="preview-status">
                                    <i class="fas fa-check me-1"></i>Aktif
                                </span>
                            </p>
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
                            <i class="fas fa-save me-2"></i>Simpan User
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-circle-large {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
    }
    
    .form-check-lg {
        padding: 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .form-check-lg:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }
    
    .form-check-lg input:checked ~ label {
        font-weight: 600;
    }
    
    .form-check-lg:has(input:checked) {
        background-color: #f8f9fa;
        border-color: #007bff;
    }

    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const roleInputs = document.querySelectorAll('input[name="role"]');
    const statusCheckbox = document.getElementById('is_active');
    const statusLabel = document.getElementById('status-label');
    const roleInfo = document.getElementById('role-info');
    
    // Preview elements
    const previewAvatar = document.querySelector('#preview-avatar .avatar-circle-large');
    const previewName = document.getElementById('preview-name');
    const previewEmail = document.getElementById('preview-email');
    const previewRole = document.getElementById('preview-role');
    const previewStatus = document.getElementById('preview-status');
    
    // Password toggle
    const togglePassword = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const toggleIconConfirm = document.getElementById('toggleIconConfirm');
    const passwordMatchMessage = document.getElementById('password-match-message');

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
        if (passwordConfirmInput.value === '') {
            passwordMatchMessage.textContent = '';
            passwordMatchMessage.className = 'text-muted';
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

    // Update preview on input
    nameInput.addEventListener('input', function() {
        const name = this.value || 'Nama User';
        previewName.textContent = name;
        previewAvatar.textContent = name.substring(0, 1).toUpperCase();
    });

    emailInput.addEventListener('input', function() {
        previewEmail.textContent = this.value || 'email@example.com';
    });

    roleInputs.forEach(input => {
        input.addEventListener('change', function() {
            updateRolePreview();
            updateRoleInfo();
        });
    });

    statusCheckbox.addEventListener('change', function() {
        updateStatusLabel();
        updateStatusPreview();
    });

    function updateRolePreview() {
        const selectedRole = document.querySelector('input[name="role"]:checked');
        if (selectedRole) {
            const role = selectedRole.value;
            if (role === 'admin') {
                previewRole.className = 'badge bg-danger';
                previewRole.innerHTML = '<i class="fas fa-crown me-1"></i>Admin';
                previewAvatar.className = 'avatar-circle-large bg-danger text-white';
            } else {
                previewRole.className = 'badge bg-primary';
                previewRole.innerHTML = '<i class="fas fa-user-md me-1"></i>Petugas';
                previewAvatar.className = 'avatar-circle-large bg-primary text-white';
            }
        }
    }

    function updateRoleInfo() {
        const selectedRole = document.querySelector('input[name="role"]:checked');
        if (selectedRole && selectedRole.value === 'admin') {
            roleInfo.className = 'alert alert-danger';
            roleInfo.innerHTML = `
                <strong><i class="fas fa-crown me-2"></i>Hak Akses Admin:</strong>
                <ul class="mb-0 mt-2">
                    <li>Semua hak akses petugas</li>
                    <li>Kelola user/akun</li>
                    <li>Kelola master data tindakan</li>
                    <li>Akses penuh ke semua fitur</li>
                </ul>
            `;
        } else {
            roleInfo.className = 'alert alert-info';
            roleInfo.innerHTML = `
                <strong><i class="fas fa-info-circle me-2"></i>Hak Akses Petugas:</strong>
                <ul class="mb-0 mt-2">
                    <li>Mengelola data pasien</li>
                    <li>Mengelola antrian pasien</li>
                    <li>Input & edit rekam medis</li>
                    <li>Melihat laporan</li>
                </ul>
            `;
        }
    }

    function updateStatusLabel() {
        if (statusCheckbox.checked) {
            statusLabel.textContent = 'Aktif';
            statusLabel.className = 'text-success';
        } else {
            statusLabel.textContent = 'Tidak Aktif';
            statusLabel.className = 'text-secondary';
        }
    }

    function updateStatusPreview() {
        if (statusCheckbox.checked) {
            previewStatus.className = 'badge bg-success ms-1';
            previewStatus.innerHTML = '<i class="fas fa-check me-1"></i>Aktif';
        } else {
            previewStatus.className = 'badge bg-secondary ms-1';
            previewStatus.innerHTML = '<i class="fas fa-times me-1"></i>Tidak Aktif';
        }
    }

    // Form validation
    document.getElementById('userForm').addEventListener('submit', function(e) {
        if (passwordInput.value !== passwordConfirmInput.value) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            passwordConfirmInput.focus();
            return false;
        }

        if (passwordInput.value.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter!');
            passwordInput.focus();
            return false;
        }
    });

    // Initialize
    updateRolePreview();
    updateRoleInfo();
    updateStatusLabel();
    updateStatusPreview();
});
</script>
@endpush