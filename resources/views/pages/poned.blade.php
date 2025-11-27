@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold"><i class="bi-activity me-2"></i> PONED (Pelayanan Obstetri Neonatal Emergensi Dasar)</h2>
    <button class="btn btn-primary rounded-pill"><i class="bi-plus-circle me-2"></i> Pasien Baru</button>
</div>

{{-- STATS CARDS --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #e83e8c, #c21766);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Ibu Melahirkan</h6>
                <h2 class="mb-0 fw-bold">3</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #6f42c1, #59359a);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Bayi Baru Lahir</h6>
                <h2 class="mb-0 fw-bold">3</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #fd7e14, #d96706);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Kamar Tersedia</h6>
                <h2 class="mb-0 fw-bold">4</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #20c997, #16936d);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Pasien Pulang</h6>
                <h2 class="mb-0 fw-bold">1</h2>
            </div>
        </div>
    </div>
</div>

{{-- PATIENT LIST --}}
<div class="card shadow border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Daftar Pasien PONED Saat Ini</h6>
        <div class="input-group input-group-sm" style="width: 250px;">
            <input type="text" class="form-control" placeholder="Cari pasien...">
            <button class="btn btn-outline-secondary" type="button"><i class="bi-search"></i></button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. RM</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Waktu Masuk</th>
                        <th>Dokter PJ</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-bold text-primary">RM-00921</td>
                        <td>
                            <div class="fw-bold">Ny. Siti Rohmah</div>
                            <small class="text-muted">32 Th • G2P1A0</small>
                        </td>
                        <td>Persalinan Normal</td>
                        <td>Hari ini, 04:30</td>
                        <td>dr. Sp.OG</td>
                        <td><span class="badge bg-warning text-dark">Observasi</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary rounded-pill">Detail</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-bold text-primary">RM-00922</td>
                        <td>
                            <div class="fw-bold">By. Ny. Siti Rohmah</div>
                            <small class="text-muted">0 Hari • Laki-laki</small>
                        </td>
                        <td>Perawatan BBL</td>
                        <td>Hari ini, 06:15</td>
                        <td>dr. Sp.A</td>
                        <td><span class="badge bg-success">Stabil</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary rounded-pill">Detail</button>
                        </td>
                    </tr>
                     <tr>
                        <td class="ps-4 fw-bold text-primary">RM-00918</td>
                        <td>
                            <div class="fw-bold">Ny. Dewi</div>
                            <small class="text-muted">25 Th • KPD</small>
                        </td>
                        <td>Observasi KPD</td>
                        <td>Kemarin, 22:00</td>
                        <td>dr. Sp.OG</td>
                        <td><span class="badge bg-danger">High Risk</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary rounded-pill">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
