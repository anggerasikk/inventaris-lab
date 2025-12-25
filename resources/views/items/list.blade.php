@extends('layouts.app')
@section('title_menu')
    {{-- Ini adalah Judul Dinamis yang menggantikan "Dashboard Utama" --}}
    <h3 class="mb-3 text-dark"><i class="fas fa-boxes me-2 text-success"></i>Daftar Barang Inventaris</h3>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Barang yang Tersedia untuk Dipinjam</h5>
            </div>
            <div class="card-body">
                @if($items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap">Nama Barang</th>
                                    <th class="text-nowrap">Kategori</th>
                                    <th class="text-center text-nowrap">Jumlah</th>
                                    <th class="text-nowrap">Lokasi</th>
                                    <th class="text-nowrap">Kondisi</th>
                                    <th class="text-center text-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>
                                        <strong class="d-block">{{ $item->name }}</strong>
                                        <small class="text-muted d-block d-md-none">{{ $item->location }}</small>
                                    </td>
                                    <td class="align-middle">
                                        @php
                                            $categoryLabels = [
                                                'elektronik' => 'Elektronik',
                                                'alat' => 'Alat',
                                                'bahan' => 'Bahan',
                                                'perkakas' => 'Perkakas',
                                                'lainnya' => 'Lainnya'
                                            ];
                                        @endphp
                                        <span class="badge bg-secondary text-nowrap">{{ $categoryLabels[$item->category] ?? $item->category }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        @php $available = $item->available_quantity; @endphp
                                        <span class="badge {{ $available > 0 ? 'bg-success' : 'bg-danger' }} text-nowrap">
                                            {{ $available }} <span class="d-none d-sm-inline">unit</span>
                                        </span>
                                    </td>
                                    <td class="align-middle d-none d-md-table-cell">{{ $item->location }}</td>
                                    <td class="align-middle">
                                        @if($item->condition == 'good')
                                            <span class="badge bg-success text-nowrap"><i class="fas fa-check-circle"></i> <span class="d-none d-md-inline">Baik</span></span>
                                        @elseif($item->condition == 'damaged')
                                            <span class="badge bg-warning text-dark text-nowrap"><i class="fas fa-exclamation-circle"></i> <span class="d-none d-md-inline">Rusak</span></span>
                                        @else
                                            <span class="badge bg-danger text-nowrap"><i class="fas fa-times-circle"></i> <span class="d-none d-md-inline">Berat</span></span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-sm btn-info d-inline-block" title="Lihat Detail">
                                            <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Belum ada data barang</strong> yang tersedia untuk dipinjam saat ini.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.9rem;
        }
        .table td, .table th {
            padding: 0.5rem;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
    }
</style>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
        transition: background-color 0.3s ease;
    }
</style>
@endsection
