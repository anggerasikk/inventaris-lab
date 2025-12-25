@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Barang Inventaris</h2>
    <a href="{{ route('items.create') }}" class="btn" style="background-color: #48B3AF; color: white;">
        + Tambah Barang Baru
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->location }}</td>
                        <td>
                            @if($item->condition == 'good')
                                <span class="badge bg-success">Baik</span>
                            @elseif($item->condition == 'damaged')
                                <span class="badge bg-warning">Rusak Ringan</span>
                            @else
                                <span class="badge bg-danger">Rusak Berat</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('items.show', $item->id) }}" class="btn btn-sm btn-info flex-fill">Lihat</a>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning flex-fill">Edit</a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data barang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection