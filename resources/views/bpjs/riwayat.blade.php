@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary fw-bold mb-4">Riwayat Peserta BPJS</h2>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form class="row g-3" action="{{ route('riwayat-peserta-bpjs') }}" method="GET">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Masukkan No. Kartu BPJS / NIK" value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari Riwayat</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="timeline">
                @if($riwayat && $riwayat->count() > 0)
                    @foreach($riwayat as $index => $item)
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 text-center me-3" style="width: 80px;">
                            <div class="fw-bold text-muted">{{ $item->created_at->format('d M') }}</div>
                            <div class="small text-muted">{{ $item->created_at->format('Y') }}</div>
                        </div>
                        <div class="flex-grow-1 border-start border-3 {{ $index == 0 ? 'border-primary' : 'border-secondary' }} ps-4 pb-3 position-relative">
                            <div class="position-absolute top-0 start-0 translate-middle {{ $index == 0 ? 'bg-primary' : 'bg-secondary' }} rounded-circle" style="width: 12px; height: 12px;"></div>
                            <h5 class="fw-bold {{ $index == 0 ? 'text-primary' : 'text-dark' }}">Rawat Jalan - {{ $item->poli }}</h5>
                            <p class="mb-1"><strong>Nama:</strong> {{ $item->pasien->nama ?? $item->nama }}</p>
                            <p class="mb-1"><strong>No. BPJS:</strong> {{ $item->pasien->no_bpjs ?? '-' }}</p>
                            <small class="text-muted">No. Daftar: {{ $item->no_daftar }} | Status: 
                                @if($item->status == 'Menunggu')
                                    <span class="text-warning fw-bold">Menunggu</span>
                                @elseif($item->status == 'Selesai')
                                    <span class="text-success fw-bold">Selesai</span>
                                @else
                                    <span class="text-primary fw-bold">{{ $item->status }}</span>
                                @endif
                            </small>
                        </div>
                    </div>
                    @endforeach
                @elseif($search)
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-search fs-1 d-block mb-3"></i>
                        <h5 class="fw-normal">Tidak ada riwayat ditemukan</h5>
                        <p class="small mb-0">Coba cari dengan No. BPJS atau NIK yang berbeda</p>
                    </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    <h5 class="fw-normal">Belum ada riwayat peserta BPJS</h5>
                    <p class="small mb-0">Silakan masukkan No. Kartu BPJS atau NIK untuk melihat riwayat</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
