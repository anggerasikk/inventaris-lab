@extends('layouts.app') 

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                    <!-- User Notifications -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>Notifikasi Saya</strong>
                        </div>
                        <div class="card-body">
                            @if(isset($recentApprovals) && $recentApprovals->count())
                                <h6>Peminjaman Disetujui</h6>
                                <ul class="list-group mb-2">
                                    @foreach($recentApprovals as $a)
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div>
                                                <div><strong>{{ $a->item->name ?? 'Barang' }}</strong></div>
                                                <div class="small text-muted">Disetujui pada {{ $a->updated_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                            <span class="badge bg-success">Disetujui</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(isset($upcomingReturns) && $upcomingReturns->count())
                                <h6>Pengembalian Mendekat</h6>
                                <ul class="list-group">
                                    @foreach($upcomingReturns as $u)
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div>
                                                <div><strong>{{ $u->item->name ?? 'Barang' }}</strong></div>
                                                <div class="small text-muted">Tanggal kembali: {{ $u->return_date->format('d/m/Y') }}</div>
                                            </div>
                                            <span class="badge bg-info">{{ $u->return_date->diffForHumans() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if((!isset($recentApprovals) || !$recentApprovals->count()) && (!isset($upcomingReturns) || !$upcomingReturns->count()))
                                <div class="text-muted">Tidak ada notifikasi.</div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection