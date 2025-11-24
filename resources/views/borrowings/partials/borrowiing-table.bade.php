<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                @if($showActions)
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $borrowing)
            <tr>
                <td>
                    {{ $borrowing->user->name }}<br>
                    <small class="text-muted">{{ $borrowing->borrower_type }} - {{ $borrowing->phone_number }}</small>
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
                @if($showActions)
                <td>
                    @if($borrowing->status == 'pending')
                        <div class="btn-group">
                            <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal{{ $borrowing->id }}">Tolak</button>
                        </div>
                    @elseif($borrowing->status == 'approved')
                        <form action="{{ route('borrowings.mark-returned', $borrowing->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-info">Sudah Kembali</button>
                        </form>
                    @endif
                </td>
                @endif
            </tr>

            <!-- Modal Tolak -->
            @if($borrowing->status == 'pending')
            <div class="modal fade" id="rejectModal{{ $borrowing->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('borrowings.reject', $borrowing->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="admin_notes" class="form-label">Alasan Penolakan *</label>
                                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak Peminjaman</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @empty
            <tr>
                <td colspan="{{ $showActions ? 7 : 6 }}" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>