<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Laboratorium - @yield('title', 'Sistem')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #476EAE;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1;
        }
        
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        /* Style untuk Widget Menu */
        .widget-card {
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            border-radius: 0.75rem;
            border: none;
            height: 100%;
        }
        
        .widget-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        
        .widget-icon {
            font-size: 3rem;
            opacity: 0.75;
        }
        
        .text-light-shadow {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        /* Header Responsive */
        header {
            background-color: var(--primary-color) !important;
        }
        
        header .navbar-brand {
            white-space: nowrap;
        }
        
        .dropdown-menu {
            min-width: 250px;
        }
        
        /* Responsive Container */
        @media (max-width: 992px) {
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }
        }
        
        @media (max-width: 576px) {
            header {
                padding: 0.5rem 0 !important;
            }
            
            header .container {
                padding-left: 8px;
                padding-right: 8px;
            }
            
            .navbar-brand {
                font-size: 1rem;
            }
            
            .dropdown-toggle::after {
                display: none;
            }
            
            .widget-card .card-body {
                padding: 1.5rem 0.5rem !important;
            }
            
            .widget-icon {
                font-size: 2rem;
            }
            
            .card-title {
                font-size: 1rem;
            }
            
            .card-text {
                font-size: 0.85rem;
            }
            
            main {
                margin-top: 0.5rem !important;
            }
            
            .g-4 {
                --bs-gutter-x: 0.75rem;
                --bs-gutter-y: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <header class="py-2 py-sm-3 shadow-sm" style="background-color: #476EAE;">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <a class="navbar-brand text-white" href="{{ url('/') }}">
                <i class="fas fa-flask"></i> <span class="d-none d-sm-inline">Inventaris Lab</span><span class="d-sm-none">Lab</span>
            </a>

            <ul class="navbar-nav ms-auto flex-row align-items-center gap-1">
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> <span class="d-none d-sm-inline">Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> <span class="d-none d-sm-inline">Register</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-1" href="#" id="navbarDropdown" 
                            role="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ Auth::user()->name }}">
                            <i class="fas fa-user-circle"></i> 
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                            <li>
                                <div class="dropdown-header text-dark">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                    <br>
                                    <small class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('items.list') }}"><i class="fas fa-list me-2"></i> Lihat Barang</a></li>
                            <li><a class="dropdown-item" href="{{ route('borrowings.create') }}"><i class="fas fa-hand-holding me-2"></i> Pinjam Barang</a></li>
                            <li><a class="dropdown-item" href="{{ route('borrowings.history') }}"><i class="fas fa-history me-2"></i> Riwayat Saya</a></li>
                            @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.items.index') }}"><i class="fas fa-boxes me-2"></i> Kelola Barang</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.items.create') }}"><i class="fas fa-plus me-2"></i> Tambah Barang</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </header>
    
    <main class="container mt-3 mt-md-4">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }} 
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }} 
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i> {{ session('info') }} 
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }} 
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Content -->
        @auth
            <div class="card shadow-sm mb-4">
                <div class="card-body py-2 py-md-3">
                    <h5 class="card-title text-primary mb-1"><i class="fas fa-home me-2"></i>Selamat Datang!</h5>
                    <p class="card-text mb-0">Anda telah masuk ke Sistem Inventaris Laboratorium.</p>
                </div>
            </div>

            <div class="row g-3 g-md-4 mb-5">
                @if(Auth::user()->isAdmin())
                    <div class="col-12">
                        <div class="row g-3 g-md-4 justify-content-center"> 
                            <div class="col-12 col-sm-6 col-lg-4">
                                <a href="{{ route('admin.items.index') }}" class="text-decoration-none">
                                    <div class="card widget-card bg-success text-white shadow-sm">
                                        <div class="card-body text-center p-3 p-sm-4">
                                            <i class="fas fa-boxes widget-icon mb-3 d-block"></i>
                                            <h5 class="card-title text-white">Data Barang</h5>
                                            <p class="card-text small text-light-shadow mb-0">Kelola Data Barang Lab</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-12 col-sm-6 col-lg-4">
                                <a href="{{ route('borrowings.index') }}" class="text-decoration-none">
                                    <div class="card widget-card bg-warning text-dark shadow-sm position-relative">
                                        <div class="card-body text-center p-3 p-sm-4">
                                            <i class="fas fa-handshake widget-icon mb-3 d-block"></i>
                                            <h5 class="card-title text-dark">Peminjaman</h5>
                                            <p class="card-text small mb-0">Kelola Permintaan Peminjaman</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-12 col-sm-6 col-lg-4">
                                <a href="{{ route('reports.index') }}" class="text-decoration-none">
                                    <div class="card widget-card bg-info text-white shadow-sm">
                                        <div class="card-body text-center p-3 p-sm-4">
                                            <i class="fas fa-chart-bar widget-icon mb-3 d-block"></i>
                                            <h5 class="card-title text-white">Laporan</h5>
                                            <p class="card-text small text-light-shadow mb-0">Lihat Laporan Inventaris</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> 
                    </div>

                @else
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="{{ route('borrowings.create') }}" class="text-decoration-none">
                            <div class="card widget-card bg-primary text-white shadow-sm">
                                <div class="card-body text-center p-3 p-sm-4">
                                    <i class="fas fa-hand-holding widget-icon mb-3 d-block"></i>
                                    <h5 class="card-title text-white">Pinjam Barang</h5>
                                    <p class="card-text small text-light-shadow mb-0">Ajukan Permintaan</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="{{ route('borrowings.history') }}" class="text-decoration-none">
                            <div class="card widget-card bg-secondary text-white shadow-sm">
                                <div class="card-body text-center p-3 p-sm-4">
                                    <i class="fas fa-history widget-icon mb-3 d-block"></i>
                                    <h5 class="card-title text-white">Riwayat Saya</h5>
                                    <p class="card-text small text-light-shadow mb-0">Lihat Riwayat Peminjaman</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="{{ route('items.list') }}" class="text-decoration-none">
                            <div class="card widget-card bg-success text-white shadow-sm">
                                <div class="card-body text-center p-3 p-sm-4">
                                    <i class="fas fa-boxes widget-icon mb-3 d-block"></i>
                                    <h5 class="card-title text-white">Data Barang</h5>
                                    <p class="card-text small text-light-shadow mb-0">Lihat Stok & Ketersediaan</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="row">
                <div class="col-12">
                    @yield('title_menu')
                    @yield('content') 
                </div>
            </div>

        @else
            <div class="row justify-content-center py-5">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                    @yield('content')
                </div>
            </div>
        @endauth
    </main>

    <footer class="bg-light mt-5 py-3 py-md-4 shadow-sm">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <h6 class="text-primary mb-1">
                        <i class="fas fa-flask"></i> Sistem Inventaris Laboratorium
                    </h6>
                    <p class="text-muted small mb-0">
                        Pendidikan Teknik Informatika dan Komputer
                    </p>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <p class="text-muted small mb-1">
                        &copy; {{ date('Y') }} Inventaris Lab. All rights reserved.
                    </p>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-code"></i> Built with Laravel & Bootstrap
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    @stack('scripts')
</body>
</html>