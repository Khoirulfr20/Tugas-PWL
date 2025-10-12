<!-- resources/views/layouts/app.blade.php -->
<!-- LAYOUT UTAMA UNTUK HALAMAN APLIKASI SETELAH LOGIN -->
<!-- ================================================== -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Dynamic Title -->
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Rekam Medis Gigi') }}</title>
    
    <!-- External CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom App Styles -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --header-bg: #ffffff;
            --text-primary: #2c3e50;
            --border-color: #dee2e6;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            font-size: 14px;
        }

        /* NAVBAR STYLING */
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: var(--header-bg) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.4rem;
        }

        .navbar-brand i {
            color: #e74c3c;
            margin-right: 0.5rem;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: calc(100vh - 56px);
            padding: 0;
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link {
            color: #ffffff;
            padding: 1rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            border-left-color: var(--primary-color);
            color: #ffffff;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            border-left-color: #ffffff;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
        }

        /* MAIN CONTENT STYLING */
        .main-content {
            padding: 1.5rem;
            background-color: #ffffff;
            min-height: calc(100vh - 56px);
        }

        /* ALERT STYLING */
        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CARD STYLING */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid var(--border-color);
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        /* BUTTON STYLING */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* TABLE STYLING */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        /* RESPONSIVE SIDEBAR */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 56px;
                width: 250px;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        /* UTILITY CLASSES */
        .border-left-primary { border-left: 4px solid var(--primary-color) !important; }
        .border-left-success { border-left: 4px solid var(--success-color) !important; }
        .border-left-warning { border-left: 4px solid var(--warning-color) !important; }
        .border-left-danger { border-left: 4px solid var(--danger-color) !important; }
        .border-left-info { border-left: 4px solid var(--info-color) !important; }

        .text-gray-800 { color: #5a5c69 !important; }
        .text-xs { font-size: 0.7rem !important; }
    </style>
    
    <!-- Additional CSS dari child templates -->
    @stack('styles')
</head>
<body>
    <!-- TOP NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <!-- Brand/Logo -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-tooth"></i>
                Rekam Medis Gigi
            </a>
            
            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler d-lg-none" type="button" onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Right Side Menu -->
            <div class="navbar-nav ms-auto">
                <!-- Notification Icon (Optional) -->
                <div class="nav-item dropdown me-3">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger badge-sm">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Antrian baru: John Doe</a></li>
                        <li><a class="dropdown-item" href="#">Jadwal pemeriksaan besok</a></li>
                        <li><a class="dropdown-item" href="#">Laporan bulanan siap</a></li>
                    </ul>
                </div>

                <!-- User Dropdown -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ auth()->user()->name }}
                        <span class="badge bg-primary ms-1">{{ ucfirst(auth()->user()->role) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-cog me-2"></i>Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="container-fluid" style="margin-top: 56px;">
        <div class="row">
            <!-- SIDEBAR NAVIGATION -->
            <nav class="col-md-2 d-md-block sidebar" id="sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>

                        <!-- Data Pasien -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}" 
                               href="{{ route('patients.index') }}">
                                <i class="fas fa-users"></i>
                                Data Pasien
                            </a>
                        </li>

                        <!-- Antrian -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('queues.*') ? 'active' : '' }}" 
                               href="{{ route('queues.index') }}">
                                <i class="fas fa-list-ol"></i>
                                Antrian Pasien
                            </a>
                        </li>

                       <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('medical-records.*') ? 'active' : '' }}" 
                               href="{{ route('medical-records.index') }}">
                                <i class="fas fa-file-medical"></i>
                                Rekam Medis
                            </a>
                        </li>

                        <!-- ADMIN ONLY MENU -->
                        @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <hr class="sidebar-divider my-3" style="border-color: #ffffff33;">
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('treatments.*') ? 'active' : '' }}" 
                               href="{{ route('treatments.index') }}">
                                <i class="fas fa-procedures"></i>
                                Master Tindakan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" 
                               href="{{ route('users.index') }}">
                                <i class="fas fa-user-cog"></i>
                                Kelola User
                            </a>
                        </li>
                        @endif

                        <!-- Reports -->
                        <li class="nav-item">
                            <hr class="sidebar-divider my-3" style="border-color: #ffffff33;">
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
                               href="{{ route('reports.index') }}">
                                <i class="fas fa-chart-line"></i>
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- MAIN CONTENT AREA -->
            <main class="col-md-10 ms-sm-auto main-content">
                <!-- SUCCESS/ERROR ALERTS -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- PAGE CONTENT -->
                <div class="pt-3 pb-2 mb-3">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- JAVASCRIPT LIBRARIES -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ❌ PUSHER SCRIPT DIHAPUS - TIDAK DIGUNAKAN LAGI -->
    
    <!-- Custom JavaScript -->
    <script>
        // Mobile Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.navbar-toggler');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Confirmation for delete actions
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
            return confirm(message);
        }

        // ❌ PUSHER INITIALIZATION DIHAPUS - TIDAK DIGUNAKAN LAGI
    </script>

    <!-- Additional Scripts dari child templates -->
    @stack('scripts')
</body>
</html>