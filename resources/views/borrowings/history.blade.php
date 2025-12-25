@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Riwayat Peminjaman Saya</h2>
    <a href="{{ route('borrowings.create') }}" class="btn" style="background-color: #48B3AF; color: white;">
        + Ajukan Peminjaman Baru
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                    <tr>
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
                            @else
                                <span class="badge bg-secondary">{{ $borrowing->status }}</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                    data-bs-target="#detailModal{{ $borrowing->id }}">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $borrowing->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <tr><th>Barang</th><td>{{ $borrowing->item->name }}</td></tr>
                                        <tr><th>Jumlah</th><td>{{ $borrowing->quantity }}</td></tr>
                                        <tr><th>Tanggal Pinjam</th><td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td></tr>
                                        <tr><th>Tanggal Kembali</th><td>{{ $borrowing->return_date->format('d/m/Y') }}</td></tr>
                                        <tr><th>Keperluan</th><td>{{ $borrowing->purpose }}</td></tr>
                                        <tr><th>Status</th><td>
                                            @if($borrowing->status == 'pending')
                                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                                            @elseif($borrowing->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($borrowing->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @if($borrowing->admin_notes)
                                                    <br><small>Alasan: {{ $borrowing->admin_notes }}</small>
                                                @endif
                                            @elseif($borrowing->status == 'returned')
                                                <span class="badge bg-info">Dikembalikan</span>
                                            @endif
                                        </td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada riwayat peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection