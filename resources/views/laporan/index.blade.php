@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Pusat Laporan</h2>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <a href="{{ route('laporan.kunjungan') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
            <div class="card-body text-center p-5">
                <div class="avatar-lg bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi-people-fill fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark">Laporan Kunjungan</h4>
                <p class="text-muted">Statistik jumlah kunjungan pasien per hari dan per poliklinik.</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('laporan.diagnosa') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
            <div class="card-body text-center p-5">
                <div class="avatar-lg bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi-activity fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark">Laporan Morbiditas</h4>
                <p class="text-muted">10 Besar Penyakit (Top 10 Diagnosa) berdasarkan kode ICD-10.</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="#" class="card border-0 shadow-sm h-100 text-decoration-none card-hover grayscale">
            <div class="card-body text-center p-5">
                <div class="avatar-lg bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi-cash-coin fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark">Laporan Keuangan</h4>
                <p class="text-muted">Pendapatan klinik (Coming Soon).</p>
            </div>
        </a>
    </div>
</div>

<style>
    .card-hover { transition: transform 0.2s; }
    .card-hover:hover { transform: translateY(-5px); }
    .grayscale { filter: grayscale(100%); opacity: 0.6; cursor: not-allowed; }
</style>
@endsection
