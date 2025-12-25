@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="background-color: #A7E399;">
        <h4 class="mb-0">Tambah Barang Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Barang *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Kategori *</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        <option value="elektronik" {{ old('category') == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="alat" {{ old('category') == 'alat' ? 'selected' : '' }}>Alat Laboratorium</option>
                        <option value="bahan" {{ old('category') == 'bahan' ? 'selected' : '' }}>Bahan Kimia</option>
                        <option value="perkakas" {{ old('category') == 'perkakas' ? 'selected' : '' }}>Perkakas</option>
                        <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="quantity" class="form-label">Jumlah *</label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" min="0" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="location" class="form-label">Lokasi *</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="condition" class="form-label">Kondisi *</label>
                    <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                        <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Baik</option>
                        <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="broken" {{ old('condition') == 'broken' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('condition')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn" style="background-color: #48B3AF; color: white;">
                    Simpan Barang
                </button>
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection