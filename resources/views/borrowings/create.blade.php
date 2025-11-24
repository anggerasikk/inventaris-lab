@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="background-color: #A7E399;">
        <h4 class="mb-0">Form Peminjaman Barang</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('borrowings.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="item_id" class="form-label">Pilih Barang *</label>
                    <select class="form-select @error('item_id') is-invalid @enderror" id="item_id" name="item_id" required>
                        <option value="">Pilih Barang</option>
                        @foreach($items as $item)
                            @if($item->canBeBorrowed())
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} (Tersedia: {{ $item->available_quantity }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="quantity" class="form-label">Jumlah *</label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                           id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="phone_number" class="form-label">No. HP *</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                           id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="borrow_date" class="form-label">Tanggal Pinjam *</label>
                    <input type="date" class="form-control @error('borrow_date') is-invalid @enderror" 
                           id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}" required>
                    @error('borrow_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="return_date" class="form-label">Tanggal Kembali *</label>
                    <input type="date" class="form-control @error('return_date') is-invalid @enderror" 
                           id="return_date" name="return_date" value="{{ old('return_date') }}" required>
                    @error('return_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="purpose" class="form-label">Keperluan Peminjaman *</label>
                <textarea class="form-control @error('purpose') is-invalid @enderror" 
                          id="purpose" name="purpose" rows="3" required>{{ old('purpose') }}</textarea>
                @error('purpose')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info">
                <strong>Informasi:</strong><br>
                - Peminjaman harus disetujui oleh admin<br>
                - Pastikan barang tersedia pada tanggal yang diminta<br>
                - Hubungi admin jika ada pertanyaan
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn" style="background-color: #48B3AF; color: white;">
                    Ajukan Peminjaman
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Set min date untuk tanggal pinjam ke hari ini
    document.getElementById('borrow_date').min = new Date().toISOString().split('T')[0];
    
    // Set min date untuk tanggal kembali berdasarkan tanggal pinjam
    document.getElementById('borrow_date').addEventListener('change', function() {
        document.getElementById('return_date').min = this.value;
    });
</script>
@endsection