@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header" style="background-color: #A7E399;">
        <h4 class="mb-0"><i class="fas fa-clipboard-list"></i> Form Peminjaman Barang</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('borrowings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Row 1: Barang, Jumlah, No HP -->
            <div class="row">
                <div class="col-12 col-md-5 mb-3">
                    <label for="item_id" class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                    <select class="form-select @error('item_id') is-invalid @enderror" id="item_id" name="item_id" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            @if($item->canBeBorrowed())
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} (Tersedia: {{ $item->available_quantity }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-6 col-md-3 mb-3">
                    <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                           id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                    @error('quantity')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6 col-md-4 mb-3">
                    <label for="phone_number" class="form-label">No. HP <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                           id="phone_number" name="phone_number" value="{{ old('phone_number') }}" 
                           placeholder="0812xxxxxxxx" required>
                    @error('phone_number')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Row 2: Dates -->
            <div class="row">
                <div class="col-12 col-sm-6 mb-3">
                    <label for="borrow_date" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('borrow_date') is-invalid @enderror" 
                           id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}" required>
                    @error('borrow_date')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 col-sm-6 mb-3">
                    <label for="return_date" class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('return_date') is-invalid @enderror" 
                           id="return_date" name="return_date" value="{{ old('return_date') }}" required>
                    @error('return_date')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Purpose -->
            <div class="mb-3">
                <label for="purpose" class="form-label">Keperluan Peminjaman <span class="text-danger">*</span></label>
                <textarea class="form-control @error('purpose') is-invalid @enderror" 
                          id="purpose" name="purpose" rows="3" required 
                          placeholder="Jelaskan keperluan peminjaman barang...">{{ old('purpose') }}</textarea>
                @error('purpose')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- File Upload -->
            <div class="mb-3">
                <label for="letter" class="form-label">Upload Surat Permohonan Peminjaman <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="file" class="form-control @error('letter') is-invalid @enderror" 
                           id="letter" name="letter" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                    <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                </div>
                <small class="text-muted d-block mt-2">
                    <i class="fas fa-info-circle"></i> Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Maks: 2MB)
                </small>
                @error('letter')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-lightbulb"></i> Informasi Penting:</strong>
                <ul class="mb-0 mt-2 small">
                    <li>Surat permohonan harus disertakan dengan aplikasi peminjaman</li>
                    <li>Peminjaman harus disetujui oleh admin sebelum diambil</li>
                    <li>Pastikan barang tersedia pada tanggal yang diminta</li>
                    <li>Hubungi admin jika ada pertanyaan atau kendala</li>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="btn flex-grow-1 flex-sm-grow-0" style="background-color: #48B3AF; color: white;">
                    <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary flex-grow-1 flex-sm-grow-0">
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
        }
        .btn {
            min-height: 44px;
        }
    }
</style>

<script>
    // Set min date untuk tanggal pinjam ke hari ini
    document.getElementById('borrow_date').min = new Date().toISOString().split('T')[0];
    
    // Set min date untuk tanggal kembali berdasarkan tanggal pinjam
    document.getElementById('borrow_date').addEventListener('change', function() {
        document.getElementById('return_date').min = this.value;
    });
</script>
@endsection