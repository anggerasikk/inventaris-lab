@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #F6FF99;">
        <h4 class="mb-0">Detail Barang</h4>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Nama Barang</th>
                        <td>{{ $item->name }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $item->category }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Stok</th>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $item->location }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>
                            @if($item->condition == 'good')
                                <span class="badge bg-success">Baik</span>
                            @elseif($item->condition == 'damaged')
                                <span class="badge bg-warning">Rusak Ringan</span>
                            @else
                                <span class="badge bg-danger">Rusak Berat</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Dibuat Pada</th>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diupdate Pada</th>
                        <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($item->description)
        <div class="mt-3">
            <h5>Deskripsi</h5>
            <p>{{ $item->description }}</p>
        </div>
        @endif

        <div class="mt-4">
            <div class="d-flex gap-2">
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning flex-fill">Edit Barang</a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline flex-fill">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus Barang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection