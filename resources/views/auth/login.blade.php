<!-- resources/views/auth/login.blade.php -->
<!-- HALAMAN LOGIN YANG MENGGUNAKAN LAYOUT AUTH -->
<!-- ========================================= -->

@extends('layouts.auth')

@section('title', 'Login')
@section('header-title', 'Selamat Datang')
@section('header-subtitle', 'Silakan login untuk mengakses sistem rekam medis')

@section('content')
<form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf
    
     <!-- EMAIL INPUT -->
    <div class="form-group">
        <label for="email" class="form-label">
            <i class="fas fa-envelope"></i>
            Email Address
        </label>
        <input type="text" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autocomplete="email" 
               autofocus
               placeholder="Masukkan email Anda">
        
        @error('email')
            <div class="invalid-feedback d-block">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- PASSWORD INPUT -->
    <div class="form-group">
        <label for="password" class="form-label">
            <i class="fas fa-lock"></i>
            Password
        </label>
        <div class="password-wrapper">
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   placeholder="Masukkan password Anda">
            
            <!-- Password Toggle Button -->
            <button type="button" 
                    class="password-toggle"
                    tabindex="-1">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        
        @error('password')
            <div class="invalid-feedback d-block">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- REMEMBER ME CHECKBOX -->
    <div class="remember-me">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                Ingat saya
            </label>
        </div>
    </div>
    
    <!-- LOGIN BUTTON -->
    <div class="d-grid">
        <button type="submit" class="btn btn-login">
            <div class="loading-spinner"></div>
            <div class="success-checkmark"></div>
            <span class="btn-text">
                <i class="fas fa-sign-in-alt me-2"></i>
                Login
            </span>
        </button>
    </div>
</form>

<!-- LOGIN HELP SECTION -->
<div class="mt-4 text-center">
    <p class="text-muted mb-2">
        <small>
            <i class="fas fa-info-circle me-1"></i>
            Lupa password? Hubungi administrator
        </small>
    </p>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles khusus untuk halaman login */
    .password-toggle {
        padding: 4px 8px !important;
        font-size: 0.9rem;
    }
    
    .password-toggle:hover i {
        color: var(--primary-color) !important;
    }
    
    /* Loading animation untuk demo credentials */
    @if(app()->environment('local'))
    .demo-credential {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .demo-credential:hover {
        background-color: rgba(13, 110, 253, 0.1);
        border-radius: 4px;
        padding: 2px 4px;
    }
    @endif
    
    /* Form validation styling */
    .form-control.is-invalid {
        padding-right: 3.5rem;
    }
    
    .form-control.is-invalid + .password-toggle {
        right: 2.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    // Enhanced form submission
    loginForm.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const btnText = submitBtn.querySelector('.btn-text');
        const spinner = submitBtn.querySelector('.loading-spinner');
        
        // Show loading state
        submitBtn.disabled = true;
        spinner.style.display = 'inline-block';
        btnText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        
        // Simulate processing time (remove this in production)
        setTimeout(() => {
            // If validation passes, the form will submit naturally
            // If fails, re-enable button
            submitBtn.disabled = false;
            spinner.style.display = 'none';
            btnText.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login';
        }, 10000);
    });
    
    // Auto-focus on email input
    emailInput.focus();
    
    // Enter key handling
    passwordInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            loginForm.submit();
        }
    });
    
    @if(app()->environment('local'))
    // Demo credential quick fill (Development only)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('demo-credential')) {
            const credentials = e.target.dataset;
            emailInput.value = credentials.email;
            passwordInput.value = credentials.password;
            
            // Add visual feedback
            emailInput.style.backgroundColor = '#e8f5e8';
            passwordInput.style.backgroundColor = '#e8f5e8';
            
            setTimeout(() => {
                emailInput.style.backgroundColor = '';
                passwordInput.style.backgroundColor = '';
            }, 1000);
        }
    });
    
    // Add click handlers to demo credentials
    const demoCredentials = [
        { email: 'admin@dental.com', password: 'admin123', role: 'Admin' },
        { email: 'doctor@dental.com', password: 'doctor123', role: 'Dokter' },
        { email: 'petugas@dental.com', password: 'petugas123', role: 'Petugas' }
    ];
    
    const alertDiv = document.querySelector('.alert-info');
    if (alertDiv) {
        const content = alertDiv.innerHTML;
        let newContent = content.replace(/admin@dental\.com \/ admin123/g, 
            '<span class="demo-credential text-primary" data-email="admin@dental.com" data-password="admin123">admin@dental.com / admin123</span>');
        newContent = newContent.replace(/doctor@dental\.com \/ doctor123/g, 
            '<span class="demo-credential text-primary" data-email="doctor@dental.com" data-password="doctor123">doctor@dental.com / doctor123</span>');
        newContent = newContent.replace(/petugas@dental\.com \/ petugas123/g, 
            '<span class="demo-credential text-primary" data-email="petugas@dental.com" data-password="petugas123">petugas@dental.com / petugas123</span>');
        alertDiv.innerHTML = newContent;
    }
    @endif
    
    // Clear error states on input
    [emailInput, passwordInput].forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback') || 
                               this.parentNode.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.style.display = 'none';
                }
            }
        });
    });
    
    // Password strength indicator (optional)
    passwordInput.addEventListener('input', function() {
        // You can add password strength checking here
    });
});
</script>
@endpush