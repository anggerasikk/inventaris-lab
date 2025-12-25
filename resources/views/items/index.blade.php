@extends('layouts.app')
@section('title_menu')
    {{-- Ini adalah Judul Dinamis yang menggantikan "Dashboard Utama" --}}
    <h3 class="mb-3 text-dark"><i class="fas fa-boxes me-2 text-success"></i>Manajemen Data Barang</h3>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="mb-0">Daftar Barang Inventaris</h2>
    <a href="{{ route('admin.items.create') }}" class="btn" style="background-color: #48B3AF; color: white;">
        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Tambah Barang Baru</span>
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($items->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">Nama Barang</th>
                            <th class="text-center text-nowrap">Kategori</th>
                            <th class="text-center text-nowrap">Jumlah</th>
                            <th class="text-nowrap">Lokasi</th>
                            <th class="text-center text-nowrap">Kondisi</th>
                            <th class="text-center text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td class="align-middle">
                                <strong>{{ $item->name }}</strong>
                                <small class="text-muted d-block d-md-none">{{ $item->category }}</small>
                            </td>
                            <td class="text-center align-middle d-none d-md-table-cell">
                                <span class="badge bg-secondary">{{ ucfirst($item->category) }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge {{ $item->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td class="align-middle d-none d-lg-table-cell">{{ $item->location }}</td>
                            <td class="text-center align-middle">
                                @if($item->condition == 'good')
                                    <span class="badge bg-success text-nowrap"><i class="fas fa-check"></i> <span class="d-none d-md-inline">Baik</span></span>
                                @elseif($item->condition == 'damaged')
                                    <span class="badge bg-warning text-dark text-nowrap"><i class="fas fa-exclamation"></i> <span class="d-none d-md-inline">Rusak</span></span>
                                @else
                                    <span class="badge bg-danger text-nowrap"><i class="fas fa-times"></i> <span class="d-none d-md-inline">Berat</span></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm d-flex flex-wrap gap-1 justify-content-center" role="group">
                                    <a href="{{ route('items.show', $item->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                    </a>
                                    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                    </a>
                                    <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                            <i class="fas fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-inbox me-2 text-muted fa-2x float-start"></i>
                <h5 class="mt-1">Belum Ada Data Barang</h5>
                <p class="mb-0">Tidak ada data barang di sistem. <a href="{{ route('admin.items.create') }}">Tambahkan barang baru sekarang</a></p>
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
            font-size: 0.85rem;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        .badge {
            font-size: 0.75rem;
        }
    }
</style>
@endsection