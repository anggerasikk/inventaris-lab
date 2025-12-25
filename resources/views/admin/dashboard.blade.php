@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-md-3">
        <div class="stat-card card-1">
            <div class="row">
                <div class="col-8">
                    <h5>Total Alat</h5>
                    <h2>{{ $totalItems }}</h2>
                </div>
                <div class="col-4 text-end">
                    <i class="fas fa-flask"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card card-2">
            <div class="row">
                <div class="col-8">
                    <h5>Total Peminjaman</h5>
                    <h2>{{ $totalBorrowings }}</h2>
                </div>
                <div class="col-4 text-end">
                    <i class="fas fa-exchange-alt"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card card-3">
            <div class="row">
                <div class="col-8">
                    <h5>Menunggu Approval</h5>
                    <h2>{{ $pendingBorrowings }}</h2>
                </div>
                <div class="col-4 text-end">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card card-4">
            <div class="row">
                <div class="col-8">
                    <h5>Disetujui</h5>
                    <h2>{{ $approvedBorrowings }}</h2>
                </div>
                <div class="col-4 text-end">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Peminjaman Terbaru -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Peminjaman Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $borrowing)
                            <tr>
                                <td>
                                    <strong>{{ $borrowing->borrower_name }}</strong><br>
                                    <small>{{ $borrowing->identifier }}</small>
                                </td>
                                <td>{{ $borrowing->item->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if($borrowing->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($borrowing->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($borrowing->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-info">Dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.borrowings.index') }}?status={{ $borrowing->status }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.borrowings.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-2"></i>Lihat Semua Peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alat Stok Sedikit -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Stok Menipis</h5>
            </div>
            <div class="card-body">
                @forelse($lowStockItems as $item)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ $item->name }}</strong><br>
                    <small>Kode: {{ $item->code }}</small>
                    <div class="mt-2">
                        <span class="badge bg-danger">Stok: {{ $item->stock }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted">
                    <i class="fas fa-check-circle fa-2x mb-3"></i>
                    <p>Semua stok aman</p>
                </div>
                @endforelse
                
                @if($lowStockItems->count() > 0)
                <a href="{{ route('admin.items.index') }}" class="btn btn-warning w-100">
                    <i class="fas fa-box me-2"></i>Kelola Stok
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Chart Peminjaman -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik Peminjaman {{ date('Y') }}</h5>
            </div>
            <div class="card-body">
                <canvas id="borrowingsChart" height="100" data-monthly-data="{{ json_encode($borrowingsByMonth->toArray()) }}"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Configuration
    const ctx = document.getElementById('borrowingsChart').getContext('2d');
    const chartElement = document.getElementById('borrowingsChart');
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    // Get data from HTML attribute
    const monthlyData = JSON.parse(chartElement.getAttribute('data-monthly-data') || '{}');
    
    // Fill empty months with 0
    const chartData = [];
    for(let i = 1; i <= 12; i++) {
        chartData.push(monthlyData[i] || 0);
    }
    
    const borrowingsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: chartData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush