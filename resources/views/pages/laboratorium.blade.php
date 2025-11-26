@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Laboratorium</h2>
    <button class="btn btn-primary"><i class="bi-plus-circle me-2"></i> Permintaan Baru</button>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #4e73df, #224abe);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1">Total Permintaan Hari Ini</h6>
                <h2 class="mb-0 fw-bold">12</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #1cc88a, #13855c);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1">Selesai Diperiksa</h6>
                <h2 class="mb-0 fw-bold">8</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #f6c23e, #dda20a);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1">Menunggu Hasil</h6>
                <h2 class="mb-0 fw-bold">4</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian Pemeriksaan Lab</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Nama Pasien</th>
                        <th>No. RM</th>
                        <th>Jenis Pemeriksaan</th>
                        <th>Dokter Pengirim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>08:30</td>
                        <td class="fw-bold">Budi Santoso</td>
                        <td>RM-2311001</td>
                        <td>Darah Lengkap, Gula Darah</td>
                        <td>dr. Andi Sp.PD</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="bi-printer"></i> Cetak</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>09:15</td>
                        <td class="fw-bold">Siti Aminah</td>
                        <td>RM-2311005</td>
                        <td>Urinalisa</td>
                        <td>dr. Budi Sp.A</td>
                        <td><span class="badge bg-warning text-dark">Proses</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary"><i class="bi-pencil"></i> Input Hasil</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>09:45</td>
                        <td class="fw-bold">Rudi Hartono</td>
                        <td>RM-2311012</td>
                        <td>Rontgen Thorax</td>
                        <td>dr. Citra Sp.P</td>
                        <td><span class="badge bg-secondary">Menunggu</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary"><i class="bi-play-fill"></i> Proses</button>
                        </td>
                    </tr>
                     <tr>
                        <td>4</td>
                        <td>10:00</td>
                        <td class="fw-bold">Dewi Sartika</td>
                        <td>RM-2311020</td>
                        <td>Kolesterol Total</td>
                        <td>dr. Andi Sp.PD</td>
                        <td><span class="badge bg-secondary">Menunggu</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary"><i class="bi-play-fill"></i> Proses</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
