@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Dashboard Rekam Medis</h2>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white bg-primary">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Total Pasien Terdaftar</h6>
                <h2 class="mb-0 fw-bold">{{ $totalPasien }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white bg-success">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Kunjungan Hari Ini</h6>
                <h2 class="mb-0 fw-bold">{{ $kunjunganHariIni }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white bg-warning">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Pasien Rawat Inap Aktif</h6>
                <h2 class="mb-0 fw-bold">{{ $rawatInapAktif }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white bg-info">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Permintaan Akses Menunggu</h6>
                <h2 class="mb-0 fw-bold">{{ $pendingRequestCount ?? 0 }}</h2>
                @if(($pendingRequestCount ?? 0) > 0)
                    <a href="{{ route('rekam-medis.requests', ['filter' => 'pending']) }}" class="btn btn-light btn-sm mt-2">
                        <i class="bi bi-eye me-1"></i>Lihat Permintaan
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <a href="{{ route('rekam-medis.pasien') }}" class="card border-0 shadow-sm h-100 card-hover text-decoration-none">
            <div class="card-body text-center p-5">
                <div class="avatar-lg bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi-folder2-open fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark">Data Pasien & EMR</h4>
                <p class="text-muted">Cari pasien dan lihat riwayat rekam medis elektronik (EMR) lengkap.</p>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('laporan.index') }}" class="card border-0 shadow-sm h-100 card-hover text-decoration-none">
            <div class="card-body text-center p-5">
                <div class="avatar-lg bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi-file-earmark-bar-graph fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark">Laporan & Statistik</h4>
                <p class="text-muted">Akses laporan kunjungan, morbiditas, dan statistik rumah sakit.</p>
            </div>
        </a>
    </div>
</div>

<style>
    .card-hover { transition: transform 0.2s; }
    .card-hover:hover { transform: translateY(-5px); }
</style>
@endsection
