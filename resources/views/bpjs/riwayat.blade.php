@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary fw-bold mb-4">Riwayat Peserta BPJS</h2>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Masukkan No. Kartu BPJS / NIK">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Cari Riwayat</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="timeline">
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 text-center me-3" style="width: 80px;">
                        <div class="fw-bold text-muted">26 Nov</div>
                        <div class="small text-muted">2025</div>
                    </div>
                    <div class="flex-grow-1 border-start border-3 border-primary ps-4 pb-3 position-relative">
                        <div class="position-absolute top-0 start-0 translate-middle bg-primary rounded-circle" style="width: 12px; height: 12px;"></div>
                        <h5 class="fw-bold text-primary">Rawat Jalan - Poli Penyakit Dalam</h5>
                        <p class="mb-1">Diagnosa: <span class="badge bg-secondary">I10 - Essential (primary) hypertension</span></p>
                        <p class="mb-1">Dokter: dr. Andi Sp.PD</p>
                        <small class="text-muted">No. SEP: 1301R0011123V00001 | Status: <span class="text-success fw-bold">Klaim Diajukan</span></small>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 text-center me-3" style="width: 80px;">
                        <div class="fw-bold text-muted">10 Okt</div>
                        <div class="small text-muted">2025</div>
                    </div>
                    <div class="flex-grow-1 border-start border-3 border-secondary ps-4 pb-3 position-relative">
                        <div class="position-absolute top-0 start-0 translate-middle bg-secondary rounded-circle" style="width: 12px; height: 12px;"></div>
                        <h5 class="fw-bold text-dark">Rawat Jalan - Poli Mata</h5>
                        <p class="mb-1">Diagnosa: <span class="badge bg-secondary">H52.1 - Myopia</span></p>
                        <p class="mb-1">Dokter: dr. Budi Sp.M</p>
                        <small class="text-muted">No. SEP: 1301R0011123V00999 | Status: <span class="text-success fw-bold">Klaim Dibayar</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
