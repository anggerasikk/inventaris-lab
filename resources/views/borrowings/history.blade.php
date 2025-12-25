@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="mb-0">Riwayat Peminjaman Saya</h2>
    <a href="{{ route('borrowings.create') }}" class="btn" style="background-color: #48B3AF; color: white;">
        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Ajukan Peminjaman Baru</span>
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($borrowings->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">Barang</th>
                            <th class="text-center text-nowrap">Jumlah</th>
                            <th class="text-nowrap">Tgl Pinjam</th>
                            <th class="text-nowrap">Tgl Kembali</th>
                            <th class="text-center text-nowrap">Status</th>
                            <th class="text-center text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $borrowing)
                        <tr>
                            <td class="align-middle">
                                <strong>{{ $borrowing->item->name }}</strong>
                            </td>
                            <td class="text-center align-middle">{{ $borrowing->quantity }}</td>
                            <td class="text-nowrap align-middle">{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            <td class="text-nowrap align-middle">{{ $borrowing->return_date->format('d/m/Y') }}</td>
                            <td class="text-center align-middle">
                                @if($borrowing->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($borrowing->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($borrowing->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($borrowing->status == 'returned')
                                    <span class="badge bg-info">Kembali</span>
                                @else
                                    <span class="badge bg-secondary">{{ $borrowing->status }}</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#detailModal{{ $borrowing->id }}" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $borrowing->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detail Peminjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-nowrap">Barang</th>
                                                        <td>{{ $borrowing->item->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap">Jumlah</th>
                                                        <td>{{ $borrowing->quantity }} unit</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap">Tgl Pinjam</th>
                                                        <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap">Tgl Kembali</th>
                                                        <td>{{ $borrowing->return_date->format('d/m/Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap">Keperluan</th>
                                                        <td>{{ $borrowing->purpose }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap">Status</th>
                                                        <td>
                                                            @if($borrowing->status == 'pending')
                                                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                                            @elseif($borrowing->status == 'approved')
                                                                <span class="badge bg-success">Disetujui</span>
                                                            @elseif($borrowing->status == 'rejected')
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @elseif($borrowing->status == 'returned')
                                                                <span class="badge bg-info">Dikembalikan</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if($borrowing->admin_notes)
                                                    <tr>
                                                        <th class="text-nowrap">Catatan Admin</th>
                                                        <td>
                                                            <small class="text-muted d-block p-2 bg-light rounded">
                                                                {{ $borrowing->admin_notes }}
                                                            </small>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-inbox me-2 text-muted fa-2x float-start"></i>
                <h5 class="mt-1">Belum Ada Riwayat Peminjaman</h5>
                <p class="mb-0">Anda belum mengajukan peminjaman apapun. <a href="{{ route('borrowings.create') }}">Ajukan peminjaman barang sekarang</a></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</div>

<style>
    @media (max-width: 576px) {
        h2 {
            font-size: 1.25rem;
        }
        .table-responsive {
            font-size: 0.9rem;
        }
        .btn {
            min-height: 44px;
        }
        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>
@endsection