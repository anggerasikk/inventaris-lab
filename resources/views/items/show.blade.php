@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: #F6FF99;">
        <h4 class="mb-0"><i class="fas fa-info-circle"></i> Detail Barang</h4>
        <a href="{{ Auth::user()->isAdmin() ? route('admin.items.index') : route('items.list') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <div class="card border-light">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Informasi Barang</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th class="text-nowrap">Nama Barang</th>
                                    <td><strong>{{ $item->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Kategori</th>
                                    <td>
                                        <span class="badge bg-secondary">{{ $item->category }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Jumlah Stok</th>
                                    <td>
                                        <span class="badge {{ $item->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->quantity }} unit
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Lokasi</th>
                                    <td>{{ $item->location }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Kondisi</th>
                                    <td>
                                        @if($item->condition == 'good')
                                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Baik</span>
                                        @elseif($item->condition == 'damaged')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Rusak Ringan</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Rusak Berat</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-light">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Riwayat Sistem</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th class="text-nowrap">Dibuat Pada</th>
                                    <td class="text-nowrap">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Diupdate Pada</th>
                                    <td class="text-nowrap">{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">Status</th>
                                    <td>
                                        @if($item->is_available)
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Tersedia</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-ban"></i> Tidak Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        @if($item->description)
        <div class="mt-4">
            <h6 class="mb-3"><i class="fas fa-align-left"></i> Deskripsi Barang</h6>
            <div class="alert alert-light border">
                {{ $item->description }}
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-4">
            <div class="d-flex gap-2 flex-column flex-sm-row">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-warning flex-grow-1">
                        <i class="fas fa-edit"></i> Edit Barang
                    </a>
                    <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                            <i class="fas fa-trash"></i> Hapus Barang
                        </button>
                    </form>
                @else
                    @if($item->quantity > 0)
                        <a href="{{ route('borrowings.create', ['item_id' => $item->id]) }}" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-hand-holding"></i> Pinjam Barang Ini
                        </a>
                    @else
                        <button class="btn btn-secondary flex-grow-1" disabled>
                            <i class="fas fa-times-circle"></i> Stok Tidak Tersedia
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .table-responsive {
            font-size: 0.9rem;
        }
        .btn {
            min-height: 44px;
            font-size: 0.95rem;
        }
        .card {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection