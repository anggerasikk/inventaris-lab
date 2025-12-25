@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header" style="background-color: #A7E399;">
        <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Barang Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.items.store') }}" method="POST">
            @csrf
            
            <!-- Row 1: Name and Category -->
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Cth: Voltmeter Digital" required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-md-6 mb-3">
                    <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="elektronik" {{ old('category') == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="alat" {{ old('category') == 'alat' ? 'selected' : '' }}>Alat Laboratorium</option>
                        <option value="bahan" {{ old('category') == 'bahan' ? 'selected' : '' }}>Bahan Kimia</option>
                        <option value="perkakas" {{ old('category') == 'perkakas' ? 'selected' : '' }}>Perkakas</option>
                        <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Masukkan deskripsi detail barang...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Row 2: Quantity, Location, Condition -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="0" required>
                    @error('quantity')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="Cth: Rak A1" required>
                    @error('location')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <label for="condition" class="form-label">Kondisi <span class="text-danger">*</span></label>
                    <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                        <option value="good" {{ old('condition', 'good') == 'good' ? 'selected' : '' }}>Baik</option>
                        <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="broken" {{ old('condition') == 'broken' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('condition')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Availability Status -->
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" 
                           {{ old('is_available', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_available">
                        Barang tersedia untuk dipinjam
                    </label>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Pastikan semua data barang diisi dengan benar sebelum menyimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 flex-column flex-sm-row">
                <button type="submit" class="btn flex-grow-1 flex-sm-grow-0" style="background-color: #48B3AF; color: white;">
                    <i class="fas fa-save"></i> Simpan Barang
                </button>
                <a href="{{ route('admin.items.index') }}" class="btn btn-secondary flex-grow-1 flex-sm-grow-0">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .card-header h4 {
            font-size: 1.1rem;
        }
        .form-label {
            font-size: 0.95rem;
            font-weight: 600;
        }
        .btn {
            min-height: 44px;
        }
        .alert {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
        </form>
    </div>
</div>
@endsection