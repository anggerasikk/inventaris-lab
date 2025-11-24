<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Laboratorium</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #476EAE 0%, #48B3AF 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .brand-logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
        }
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="text-white">
                        <h1 class="display-4 fw-bold mb-4">
                            <i class="fas fa-flask me-3"></i>
                            Sistem Inventaris Laboratorium
                        </h1>
                        <p class="lead mb-4">
                            Kelola barang inventaris laboratorium dengan mudah dan efisien. 
                            Sistem lengkap untuk admin, dosen, dan mahasiswa.
                        </p>
                        
                        <div class="d-flex gap-3 flex-wrap">
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-light btn-lg px-4">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row g-4">
                        <!-- Feature 1 -->
                        <div class="col-md-6">
                            <div class="card feature-card shadow-lg h-100">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3" style="color: #476EAE;">
                                        <i class="fas fa-boxes fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">Manajemen Barang</h5>
                                    <p class="text-muted">Kelola data barang inventaris dengan fitur CRUD lengkap</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="col-md-6">
                            <div class="card feature-card shadow-lg h-100">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3" style="color: #48B3AF;">
                                        <i class="fas fa-handshake fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">Sistem Peminjaman</h5>
                                    <p class="text-muted">Proses peminjaman barang dengan approval system</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="col-md-6">
                            <div class="card feature-card shadow-lg h-100">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3" style="color: #A7E399;">
                                        <i class="fas fa-chart-bar fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">Laporan & Statistik</h5>
                                    <p class="text-muted">Dashboard lengkap dengan grafik dan laporan</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Feature 4 -->
                        <div class="col-md-6">
                            <div class="card feature-card shadow-lg h-100">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3" style="color: #F6FF99;">
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold">Multi-Role</h5>
                                    <p class="text-muted">Akses berbeda untuk Admin, Dosen, dan Mahasiswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Simple animation for feature cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.feature-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>