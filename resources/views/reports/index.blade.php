@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Laporan Peminjaman</h2>
    <div>
        <button class="btn btn-success" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('reports.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="borrower_type" class="form-label">Jenis Peminjam</label>
                    <select class="form-select" id="borrower_type" name="borrower_type">
                        <option value="">Semua</option>
                        <option value="mahasiswa" {{ request('borrower_type') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ request('borrower_type') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Report Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                    <tr>
                        <td>{{ $borrowing->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            {{ $borrowing->user->name }}<br>
                            <small class="text-muted">{{ $borrowing->borrower_type }}</small>
                        </td>
                        <td>{{ $borrowing->item->name }}</td>
                        <td>{{ $borrowing->quantity }}</td>
                        <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                        <td>{{ $borrowing->return_date->format('d/m/Y') }}</td>
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
                        <td>{{ Str::limit($borrowing->purpose, 50) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowings->count() > 0)
        <div class="mt-3">
            <div class="alert alert-info">
                <strong>Total Data: {{ $borrowings->count() }} records</strong>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection