@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">Pencarian Data Pasien</h1>
                <p class="lead text-muted">Cari data pasien untuk cetak kartu, riwayat, atau informasi detail.</p>
            </div>

            <div class="card shadow-lg border-0 mb-5" style="border-radius: 1rem;">
                <div class="card-body p-5">
                    <form action="{{ route('pasien.pencarian') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 ps-4"><i class="bi-search fs-4 text-primary"></i></span>
                            <input type="text" name="q" class="form-control border-start-0 fs-6" placeholder="Ketik Nama, No. RM, atau NIK..." value="{{ $q ?? '' }}" autofocus>
                            <button class="btn btn-primary px-4 fw-bold" type="submit">CARI</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <small class="text-muted">Contoh: "Budi", "RM-001", "3509..."</small>
                    </div>
                </div>
            </div>

            @if(isset($results))
                @if($results->count() > 0)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-secondary">Hasil Pencarian ({{ $results->count() }})</h5>
                </div>
                <div class="row">
                    @foreach($results as $p)
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 shadow-sm h-100 hover-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="avatar rounded-circle bg-light text-primary d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                                    {{ substr($p->nama, 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bold mb-1">{{ $p->nama }}</h5>
                                    <p class="card-text text-muted small mb-1">
                                        <i class="bi-card-heading me-1"></i> {{ $p->no_rm }} &bull; 
                                        <i class="bi-person-vcard me-1"></i> {{ $p->nik ?? '-' }}
                                    </p>
                                    <p class="card-text text-muted small mb-0">
                                        <i class="bi-geo-alt me-1"></i> {{ Str::limit($p->alamat, 40) ?? '-' }}
                                    </p>
                                </div>
                                <div class="dropdown ms-2">
                                    <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                        <li><a class="dropdown-item" href="{{ route('pasien.show', $p->id) }}"><i class="bi-eye me-2 text-primary"></i> Detail</a></li>
                                        <li><a class="dropdown-item" href="{{ route('pasien.cetak', ['no_rm' => $p->no_rm]) }}" target="_blank"><i class="bi-printer me-2 text-secondary"></i> Cetak Kartu</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi-clock-history me-2 text-info"></i> Riwayat</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @elseif(isset($q))
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Not Found" style="width: 150px; opacity: 0.5;" class="mb-3">
                    <h4 class="text-muted">Data tidak ditemukan</h4>
                    <p class="text-muted">Coba kata kunci lain atau daftarkan pasien baru.</p>
                    <a href="{{ route('pasien.create') }}" class="btn btn-outline-primary mt-2">Daftar Pasien Baru</a>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<style>
    .hover-card { transition: transform 0.2s; }
    .hover-card:hover { transform: translateY(-5px); }
</style>
@endsection
