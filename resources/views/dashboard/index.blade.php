@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard Admin</h2>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_items'] }}</h4>
                        <p class="mb-0">Total Barang</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_borrowings'] }}</h4>
                        <p class="mb-0">Total Peminjaman</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['pending_borrowings'] }}</h4>
                        <p class="mb-0">Menunggu Persetujuan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['active_users'] }}</h4>
                        <p class="mb-0">Pengguna Aktif</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Activities -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Barang</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBorrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->user->name }}</td>
                                <td>{{ $borrowing->item->name }}</td>
                                <td>{{ $borrowing->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($borrowing->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($borrowing->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($borrowing->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($borrowing->status == 'returned')
                                        <span class="badge bg-info">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('items.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-boxes"></i> Kelola Barang
                    </a>
                    <a href="{{ route('borrowings.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-handshake"></i> Kelola Peminjaman
                    </a>
                    <a href="{{ route('items.create') }}" class="btn btn-outline-warning">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Ringkasan Status</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Simple chart for status distribution
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Disetujui', 'Menunggu', 'Ditolak', 'Dikembalikan'],
            datasets: [{
                data: [
                    {{ $borrowings->where('status', 'approved')->count() }},
                    {{ $borrowings->where('status', 'pending')->count() }},
                    {{ $borrowings->where('status', 'rejected')->count() }},
                    {{ $borrowings->where('status', 'returned')->count() }}
                ],
                backgroundColor: [
                    '#28a745',
                    '#ffc107', 
                    '#dc3545',
                    '#17a2b8'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush