<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th class="text-nowrap">Peminjam</th>
                <th class="text-nowrap">Barang</th>
                <th class="text-center text-nowrap">Jumlah</th>
                <th class="text-nowrap">Tgl Pinjam</th>
                <th class="text-nowrap">Tgl Kembali</th>
                <th class="text-center text-nowrap">Surat</th>
                <th class="text-center text-nowrap">Status</th>
                @if($showActions)
                    <th class="text-center text-nowrap">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $borrowing)
            <tr>
                <td class="align-middle">
                    <strong>{{ $borrowing->user->name }}</strong><br>
                    <small class="text-muted d-block">{{ $borrowing->borrower_type }} - {{ $borrowing->phone_number }}</small>
                </td>
                <td class="align-middle">{{ $borrowing->item->name }}</td>
                <td class="text-center align-middle">{{ $borrowing->quantity }}</td>
                <td class="text-nowrap align-middle">{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                <td class="text-nowrap align-middle">{{ $borrowing->return_date->format('d/m/Y') }}</td>
                <td class="text-center align-middle">
                    @if($borrowing->letter_path)
                        <a href="{{ asset('storage/' . $borrowing->letter_path) }}" 
                           target="_blank" class="btn btn-sm btn-primary" title="Lihat Surat">
                            <i class="fas fa-file-pdf"></i> <span class="d-none d-sm-inline">Lihat</span>
                        </a>
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                </td>
                <td class="text-center align-middle">
                    @if($borrowing->status == 'pending')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif($borrowing->status == 'approved')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($borrowing->status == 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                    @elseif($borrowing->status == 'returned')
                        <span class="badge bg-info">Kembali</span>
                    @endif
                </td>
                @if($showActions)
                <td class="align-middle">
                    @if($borrowing->status == 'pending')
                        <div class="btn-group btn-group-sm d-flex flex-wrap gap-1" role="group">
                            <form action="{{ route('borrowings.approve', $borrowing->id) }}" method="POST" class="flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100" title="Setujui">
                                    <i class="fas fa-check"></i>
                                    <span class="d-none d-md-inline">Setujui</span>
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal{{ $borrowing->id }}" title="Tolak">
                                <i class="fas fa-times"></i>
                                <span class="d-none d-md-inline">Tolak</span>
                            </button>
                        </div>
                    @elseif($borrowing->status == 'approved')
                        <form action="{{ route('borrowings.mark-returned', $borrowing->id) }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-info w-100" title="Barang sudah dikembalikan">
                                <i class="fas fa-check-circle"></i>
                                <span class="d-none d-md-inline">Kembali</span>
                            </button>
                        </form>
                    @endif
                </td>
                @endif
            </tr>

            <!-- Modal Tolak -->
            @if($borrowing->status == 'pending')
            <div class="modal fade" id="rejectModal{{ $borrowing->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('borrowings.reject', $borrowing->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="admin_notes_{{ $borrowing->id }}" class="form-label">Alasan Penolakan *</label>
                                    <textarea class="form-control" id="admin_notes_{{ $borrowing->id }}" name="admin_notes" rows="3" required></textarea>
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
                <td colspan="{{ $showActions ? 8 : 7 }}" class="text-center py-5">
                    <i class="fas fa-inbox text-muted fa-3x mb-3 d-block"></i>
                    <span class="text-muted">Tidak ada data peminjaman</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>