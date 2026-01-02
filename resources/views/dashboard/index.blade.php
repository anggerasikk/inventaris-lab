{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin - Sistem Inventaris Lab')

@section('content')
<div class="container-fluid">
    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h1 class="h3 mb-0">Inventaris Lab</h1>
                    <p class="mb-0 text-muted">Selamat Datang, {{ Auth::user()->name }}!</p>
                    <p class="mb-0">Anda telah masuk ke Sistem Inventaris Laboratorium.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Widget Cards for Quick Navigation -->
    <div class="row mb-4">
        <!-- Data Barang Widget -->
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.items.index') }}" class="text-decoration-none">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-box fa-3x mb-3"></i>
                        <h5 class="card-title">Data Barang</h5>
                        <p class="card-text">Kelola Data Barang Lab</p>
                        <div class="mt-3">
                            <span class="badge bg-light text-primary fs-6">{{ $totalItems }} Item</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Peminjaman Widget -->
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.borrowings.index') }}" class="text-decoration-none">
                <div class="card text-white bg-success h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-hand-holding fa-3x mb-3"></i>
                        <h5 class="card-title">Peminjaman</h5>
                        <p class="card-text">Kelola Permintaan Peminjaman</p>
                        <div class="mt-3">
                            <span class="badge bg-light text-success fs-6">{{ $pendingBorrowings }} Menunggu</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Laporan Widget -->
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.reports.index') }}" class="text-decoration-none">
                <div class="card text-white bg-info h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-bar fa-3x mb-3"></i>
                        <h5 class="card-title">Laporan</h5>
                        <p class="card-text">Lihat Laporan Inventaris</p>
                        <div class="mt-3">
                            <span class="badge bg-light text-info fs-6">{{ $totalBorrowings }} Transaksi</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pengembalian Widget -->
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.borrowings.history') }}" class="text-decoration-none">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-undo fa-3x mb-3"></i>
                        <h5 class="card-title">Riwayat</h5>
                        <p class="card-text">Lihat Riwayat Peminjaman</p>
                        <div class="mt-3">
                            <span class="badge bg-light text-warning fs-6">{{ $approvedBorrowings }} Disetujui</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Dashboard Utama Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Utama
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Area ini dapat diisi dengan tabel data peminjaman/pengembalian terbaru, notifikasi, atau statistik khusus.</p>
                    <!-- Notifications -->
                    <div class="mb-3">
                        <h6>Notifikasi</h6>
                        @if($pendingList->count() || $upcomingReturns->count() || $newUsers->count())
                            <ul class="list-group">
                                @foreach($pendingList as $p)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>Permintaan Peminjaman</strong>
                                            <div class="small">{{ $p->user->name ?? 'Pengguna' }} meminta "{{ $p->item->name ?? 'Barang' }}"</div>
                                        </div>
                                        <span class="badge bg-warning">Menunggu</span>
                                    </li>
                                @endforeach

                                @foreach($upcomingReturns as $r)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>Pengembalian Mendekat</strong>
                                            <div class="small">{{ $r->user->name ?? 'Pengguna' }} akan mengembalikan "{{ $r->item->name ?? 'Barang' }}" pada {{ $r->return_date->format('d/m/Y') }}</div>
                                        </div>
                                        <span class="badge bg-info">{{ $r->return_date->diffForHumans() }}</span>
                                    </li>
                                @endforeach

                                @foreach($newUsers as $u)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>Akun Baru</strong>
                                            <div class="small">{{ $u->name }} mendaftar pada {{ $u->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                        <span class="badge bg-success">Baru</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted small">Tidak ada notifikasi baru.</div>
                        @endif
                    </div>
                    
                    <!-- Recent Peminjaman Table -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-history me-2"></i>Peminjaman Terbaru (7 Hari Terakhir)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if($recentBorrowings->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Peminjam</th>
                                                        <th>Alat</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentBorrowings as $borrowing)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $borrowing->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>
                                                            <div>{{ $borrowing->borrower_name }}</div>
                                                            <small class="text-muted">{{ $borrowing->borrower_id }}</small>
                                                        </td>
                                                        <td>{{ $borrowing->item->name ?? 'N/A' }}</td>
                                                        <td>
                                                            @if($borrowing->status == 'pending')
                                                                <span class="badge bg-warning">Menunggu</span>
                                                            @elseif($borrowing->status == 'approved')
                                                                <span class="badge bg-success">Disetujui</span>
                                                            @else
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($borrowing->status == 'pending')
                                                                <a href="{{ route('admin.borrowings.approve', $borrowing->id) }}" 
                                                                   class="btn btn-sm btn-success" 
                                                                   onclick="return confirm('Setujui peminjaman ini?')">
                                                                    <i class="fas fa-check"></i>
                                                                </a>
                                                                <a href="{{ route('admin.borrowings.reject', $borrowing->id) }}" 
                                                                   class="btn btn-sm btn-danger" 
                                                                   onclick="return confirm('Tolak peminjaman ini?')">
                                                                    <i class="fas fa-times"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-end mt-2">
                                            <a href="{{ route('admin.borrowings.index') }}" class="btn btn-sm btn-outline-primary">
                                                Lihat Semua Peminjaman <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data peminjaman dalam 7 hari terakhir.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Sidebar -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-chart-pie me-2"></i>Statistik Cepat
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Total Item
                                            <span class="badge bg-primary rounded-pill">{{ $totalItems }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Total Peminjaman
                                            <span class="badge bg-success rounded-pill">{{ $totalBorrowings }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Menunggu Approval
                                            <span class="badge bg-warning rounded-pill">{{ $pendingBorrowings }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Disetujui
                                            <span class="badge bg-info rounded-pill">{{ $approvedBorrowings }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Persentase Approval
                                            <span class="badge bg-secondary rounded-pill">
                                                @if($totalBorrowings > 0)
                                                    {{ round(($approvedBorrowings / $totalBorrowings) * 100, 1) }}%
                                                @else
                                                    0%
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.items.create') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Item Baru
                                        </a>
                                        <a href="{{ route('admin.reports.export') }}" class="btn btn-outline-success">
                                            <i class="fas fa-file-excel me-2"></i>Export Laporan
                                        </a>
                                        <a href="{{ route('admin.borrowings.index') . '?status=pending' }}" class="btn btn-outline-warning">
                                            <i class="fas fa-clock me-2"></i>Lihat Pending
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Umum Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Umum
                    </h5>
                </div>
                <div class="card-body">
                    <p>Silakan gunakan widget di atas untuk navigasi cepat ke fitur utama sistem.</p>
                    <p class="mb-0">
                        Sistem ini dibangun untuk memfasilitasi pengelolaan inventaris laboratorium secara efektif dan efisien.
                        <br>
                        <small class="text-muted">www.salabarantlab.odonti.com/uploads/2019/12/01/2025</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tambahkan efek hover pada card widget
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card.h-100');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection