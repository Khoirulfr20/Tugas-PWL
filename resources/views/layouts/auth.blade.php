<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - {{ config('app.name', 'Rekam Medis Gigi') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Auth Styles -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0b5ed7;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --light-color: #495057;
            --dark-color: #212529;
            --dental-blue: #1e40af;
            --dental-light: #dbeafe;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            background: linear-gradient(135deg, var(--dental-blue) 0%, #3b82f6 100%);
            color: white;
            text-align: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .auth-header .logo {
            position: relative;
            z-index: 2;
        }

        .auth-header .logo i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .auth-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .auth-header p {
            opacity: 0.9;
            font-size: 0.95rem;
            position: relative;
            z-index: 2;
        }

        .auth-body {
            padding: 2.5rem;
        }

        /* ============================================ */
        /* FORM STYLES - FIXED FOR VISIBILITY */
        /* ============================================ */
        
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .form-label i {
            color: #6c757d;
        }

        /* INPUT STYLES - TEXT CLEARLY VISIBLE */
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #ffffff;
            color: #212529;
            font-weight: 400;
        }

        /* Placeholder Style */
        .form-control::placeholder {
            color: #6c757d;
            opacity: 0.6;
        }

        /* Focus State */
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            background: #ffffff;
            color: #212529;
            transform: translateY(-2px);
            outline: none;
        }

        /* Invalid State */
        .form-control.is-invalid {
            border-color: var(--danger-color);
            background: #fff5f5;
            color: #212529;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.875rem;
            color: var(--danger-color);
            margin-top: 0.5rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* ============================================ */
        /* PASSWORD TOGGLE BUTTON */
        /* ============================================ */
        
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper .form-control {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #6c757d;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #495057;
            transform: translateY(-50%) scale(1.1);
        }

        .password-toggle:focus {
            outline: none;
            color: var(--primary-color);
        }

        .password-toggle i {
            font-size: 1.1rem;
            pointer-events: none;
        }

        /* ============================================ */
        /* AUTOFILL FIX */
        /* ============================================ */
        
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #212529 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* ============================================ */
        /* CHECKBOX & REMEMBER ME */
        /* ============================================ */

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            cursor: pointer;
            color: var(--dental-light);
            font-size: 0.95rem;
        }

        /* ============================================ */
        /* BUTTON STYLES */
        /* ============================================ */

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
            background: linear-gradient(135deg, var(--primary-dark) 0%, #0a58ca 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:active::before {
            width: 300px;
            height: 300px;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .btn-login.loading .loading-spinner {
            display: inline-block;
        }

        .btn-login.loading .btn-text {
            opacity: 0.7;
        }

        /* ============================================ */
        /* FOOTER */
        /* ============================================ */

        .auth-footer {
            text-align: center;
            padding: 1.5rem 2.5rem 2.5rem;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
        }

        .auth-footer p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* ============================================ */
        /* RESPONSIVE DESIGN */
        /* ============================================ */

        @media (max-width: 576px) {
            .auth-container {
                max-width: 100%;
                margin: 0;
            }
            
            .auth-body {
                padding: 2rem 1.5rem;
            }
            
            .auth-header {
                padding: 1.5rem;
            }
            
            .auth-header h1 {
                font-size: 1.5rem;
            }
        }

        /* ============================================ */
        /* DARK MODE SUPPORT */
        /* ============================================ */

        @media (prefers-color-scheme: dark) {
            .auth-card {
                background: rgba(30, 30, 30, 0.95);
            }
            
            .form-label {
                color: #f8f9fa;
            }
            
            .form-control {
                background: #2d3748;
                border-color: #4a5568;
                color: #f8f9fa;
            }
            
            .form-control:focus {
                background: #1a202c;
                color: #f8f9fa;
            }

            input:-webkit-autofill,
            input:-webkit-autofill:hover,
            input:-webkit-autofill:focus {
                -webkit-box-shadow: 0 0 0 30px #2d3748 inset !important;
                -webkit-text-fill-color: #f8f9fa !important;
            }
        }

        /* Success animation */
        .success-checkmark {
            display: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--success-color);
            position: relative;
            margin-right: 8px;
        }

        .success-checkmark::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="logo">
                    <i class="fas fa-tooth"></i>
                    <h1>@yield('header-title', 'Rekam Medis Gigi')</h1>
                    <p>@yield('header-subtitle', 'Sistem Informasi Rumah Sakit Gigi dan Mulut')</p>
                </div>
            </div>

            <!-- Body Content -->
            <div class="auth-body">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p>&copy; {{ date('Y') }} Dental Medical Records. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Auth Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation enhancement
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;
                        
                        // Re-enable button after 10 seconds to prevent permanent disabled state
                        setTimeout(() => {
                            submitBtn.classList.remove('loading');
                            submitBtn.disabled = false;
                        }, 10000);
                    }
                });
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });

                // Clear error state on input
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                        const feedback = this.parentElement.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.style.display = 'none';
                        }
                    }
                });
            });

            // ============================================
            // PASSWORD TOGGLE FUNCTIONALITY - FIXED
            // ============================================
            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const wrapper = this.closest('.password-wrapper');
                    const input = wrapper.querySelector('input');
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    alert.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Enter key to submit form
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                const form = e.target.closest('form');
                if (form) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        e.preventDefault();
                        submitBtn.click();
                    }
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>