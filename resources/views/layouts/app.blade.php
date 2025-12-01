<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Laboratorium - @yield('title', 'Sistem')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        /* Style untuk Widget Menu */
        .widget-card {
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            border-radius: 0.75rem;
            border: none;
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
    </style>
</head>
<body>
    <header class="py-3 shadow-sm" style="background-color: #476EAE;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-white" href="{{ url('/') }}">
                <i class="fas fa-flask"></i> Inventaris Lab
            </a>

            <ul class="navbar-nav ms-auto flex-row align-items-center">
                @guest
                    <li class="nav-item me-2">
                        <a class="nav-link text-white" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" 
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> 
                            {{ Auth::user()->name }} 
                            <small class="text-light text-light-shadow">
                                ({{ ucfirst(Auth::user()->role) }})
                            </small>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <div class="dropdown-header text-dark">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('borrowings.create') }}"><i class="fas fa-hand-holding me-2"></i> Pinjam Barang</a></li>
                            <li><a class="dropdown-item" href="{{ route('borrowings.history') }}"><i class="fas fa-history me-2"></i> Riwayat Saya</a></li>
                            @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('items.create') }}"><i class="fas fa-plus me-2"></i> Tambah Barang</a></li>
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
    <main class="container mt-4">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle me-2"></i> {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle me-2"></i> <strong>Terjadi kesalahan:</strong> <ul class="mb-0 mt-2"> @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert"><i class="fas fa-info-circle me-2"></i> {{ session('info') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        
        @auth
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-home me-2"></i>Selamat Datang!</h5>
                    <p class="card-text">Anda telah masuk ke Sistem Inventaris Laboratorium.</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                @if(Auth::user()->isAdmin())
                    <div class="col-12">
                        <div class="row g-4 justify-content-center"> 
                            
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('items.index') }}" class="text-decoration-none">
                                    <div class="card widget-card bg-success text-white shadow">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-boxes widget-icon mb-3"></i>
                                            <h5 class="card-title text-white">Data Barang</h5>
                                            <p class="card-text small text-light-shadow">Kelola Data Barang Lab</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-6 col-lg-4">
                                @php $pendingCount = 1; @endphp
                                <a href="{{ route('borrowings.index') }}" class="text-decoration-none">
                                    <div class="card widget-card bg-warning text-dark shadow position-relative">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-handshake widget-icon mb-3"></i>
                                            @if($pendingCount > 0)
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $pendingCount }}<span class="visually-hidden">permintaan baru</span></span>
                                            @endif
                                            <h5 class="card-title text-dark">Peminjaman</h5>
                                            <p class="card-text small">Kelola Permintaan Peminjaman</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('reports.index') }}" class="text-decoration-none">
                                    <div class="card widget-card bg-info text-white shadow">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-chart-bar widget-icon mb-3"></i>
                                            <h5 class="card-title text-white">Laporan</h5>
                                            <p class="card-text small text-light-shadow">Lihat Laporan Inventaris</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> 
                    </div>

                @else
                    <div class="col-md-6 col-lg-4"><a href="{{ route('borrowings.create') }}" class="text-decoration-none"><div class="card widget-card bg-primary text-white shadow"><div class="card-body text-center p-4"><i class="fas fa-hand-holding widget-icon mb-3"></i><h5 class="card-title text-white">Pinjam Barang</h5><p class="card-text small text-light-shadow">Ajukan Permintaan Peminjaman</p></div></div></a></div>
                    <div class="col-md-6 col-lg-4"><a href="{{ route('borrowings.history') }}" class="text-decoration-none"><div class="card widget-card bg-secondary text-white shadow"><div class="card-body text-center p-4"><i class="fas fa-history widget-icon mb-3"></i><h5 class="card-title text-white">Riwayat Saya</h5><p class="card-text small text-light-shadow">Lihat Riwayat Peminjaman Anda</p></div></div></a></div>
                    <div class="col-md-6 col-lg-4"><a href="{{ route('items.index') }}" class="text-decoration-none"><div class="card widget-card bg-success text-white shadow"><div class="card-body text-center p-4"><i class="fas fa-boxes widget-icon mb-3"></i><h5 class="card-title text-white">Data Barang</h5><p class="card-text small text-light-shadow">Lihat Stok dan Ketersediaan Barang</p></div></div></a></div>
                @endif
            </div>
            
            <div class="row mt-4">
                <div class="col-lg-8 mb-4">
                    <h3 class="mb-3 text-dark"><i class="fas fa-home me-2 text-primary"></i>Dashboard Utama</h3>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @yield('content') 
                            <p class="text-muted mt-3 mb-0">
                                <i class="fas fa-table me-1"></i> Area ini dapat diisi dengan tabel data peminjaman/pengembalian terbaru, notifikasi, atau statistik khusus.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light text-primary">
                            <i class="fas fa-info-circle me-2"></i>Informasi Umum
                        </div>
                        <div class="card-body">
                            <p class="card-text">Silakan gunakan widget di atas untuk navigasi cepat ke fitur utama sistem.</p>
                            <p class="small text-muted border-top pt-2 mt-3 mb-0">
                                Sistem ini dibangun untuk memfasilitasi pengelolaan inventaris laboratorium secara efisien.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="row justify-content-center pt-5 pb-5"> 
                <div class="col-md-6">
                    @yield('content')
                </div>
            </div>
        @endauth

    </main>

    <footer class="bg-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">
                        <i class="fas fa-flask"></i> Sistem Inventaris Laboratorium
                    </h6>
                    <p class="text-muted small mb-0">
                        Pendidikan Teknik Informatika dan Komputer
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted small mb-0">
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
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    @stack('scripts')
</body>
</html>