@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Kasir & Pembayaran</h2>
    <div class="btn-group">
        <button class="btn btn-outline-secondary">Riwayat Transaksi</button>
        <button class="btn btn-primary"><i class="bi-plus-circle me-2"></i> Transaksi Baru</button>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Pendapatan Hari Ini</h6>
                        <h3 class="mb-0 fw-bold">Rp 4.500.000</h3>
                    </div>
                    <i class="bi-cash-coin fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 text-muted">Belum Dibayar</h6>
                        <h3 class="mb-0 fw-bold text-danger">Rp 850.000</h3>
                    </div>
                    <i class="bi-exclamation-circle fs-1 text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 text-muted">Total Transaksi</h6>
                        <h3 class="mb-0 fw-bold text-dark">24</h3>
                    </div>
                    <i class="bi-receipt fs-1 text-dark opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tagihan Pasien (Belum Lunas)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No. Tagihan</th>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>INV-2311-001</td>
                        <td>26 Nov 2025</td>
                        <td class="fw-bold">Budi Santoso</td>
                        <td>Poli Umum</td>
                        <td class="fw-bold text-primary">Rp 150.000</td>
                        <td><span class="badge bg-danger">Belum Lunas</span></td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="bi-cash me-1"></i> Bayar</button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi-printer"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>INV-2311-002</td>
                        <td>26 Nov 2025</td>
                        <td class="fw-bold">Siti Aminah</td>
                        <td>Poli Anak</td>
                        <td class="fw-bold text-primary">Rp 200.000</td>
                        <td><span class="badge bg-danger">Belum Lunas</span></td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="bi-cash me-1"></i> Bayar</button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi-printer"></i></button>
                        </td>
                    </tr>
                     <tr>
                        <td>INV-2311-003</td>
                        <td>26 Nov 2025</td>
                        <td class="fw-bold">Ahmad Dahlan</td>
                        <td>Poli Gigi</td>
                        <td class="fw-bold text-primary">Rp 500.000</td>
                        <td><span class="badge bg-danger">Belum Lunas</span></td>
                        <td>
                            <button class="btn btn-sm btn-success"><i class="bi-cash me-1"></i> Bayar</button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi-printer"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
