@extends('layouts.app')

@section('title_menu')
    {{-- Ini adalah Judul Dinamis yang menggantikan "Dashboard Utama" --}}
    <h3 class="mb-3 text-dark"><i class="fas fa-book-reader me-2 text-success"></i>Manajemen Peminjaman</h3>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="mb-0">Manajemen Peminjaman</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <ul class="nav nav-tabs flex-nowrap overflow-auto" id="borrowingTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-nowrap" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                    Menunggu <span class="badge bg-warning ms-1">{{ $borrowings->where('status', 'pending')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                    Disetujui <span class="badge bg-success ms-1">{{ $borrowings->where('status', 'approved')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">
                    Semua Data
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Tab Pending -->
            <div class="tab-pane fade show active" id="pending">
                @include('borrowings.partials.borrowing-table', [
                    'borrowings' => $borrowings->where('status', 'pending'),
                    'showActions' => true
                ])
            </div>

            <!-- Tab Approved -->
            <div class="tab-pane fade" id="approved">
                @include('borrowings.partials.borrowing-table', [
                    'borrowings' => $borrowings->where('status', 'approved'),
                    'showActions' => true
                ])
            </div>

            <!-- Tab All -->
            <div class="tab-pane fade" id="all">
                @include('borrowings.partials.borrowing-table', [
                    'borrowings' => $borrowings,
                    'showActions' => true
                ])
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }
        .nav-link {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
        }
        h2 {
            font-size: 1.25rem;
        }
    }
</style>
@endsection