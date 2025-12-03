@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold"><i class="bi-hospital me-2"></i>Poli Eksekutif BPJS (V-Claim)</h2>
    <div class="badge bg-primary fs-6">Online <i class="bi-wifi ms-1"></i></div>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 fw-bold">Buat SEP (Surat Eligibilitas Peserta)</h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Kartu BPJS</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="0001234567890">
                                <button class="btn btn-outline-primary" type="button">Cari Peserta</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal SEP</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Poli Tujuan</label>
                            <select class="form-select">
                                <option>Poli Penyakit Dalam</option>
                                <option>Poli Jantung</option>
                                <option>Poli Mata</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Asal Rujukan</label>
                            <select class="form-select">
                                <option>Faskes Tingkat 1</option>
                                <option>Faskes Tingkat 2</option>
                                <option>IGD</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diagnosa Awal (ICD-10)</label>
                        <input type="text" class="form-control" placeholder="Ketik kode atau nama diagnosa...">
                    </div>
                    <button type="button" class="btn btn-primary w-100 fw-bold">Simpan & Cetak SEP</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Status Klaim</h5>
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent d-flex justify-content-between">
                        <span>Total SEP Hari Ini</span>
                        <span class="fw-bold">45</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex justify-content-between">
                        <span>Menunggu Verifikasi</span>
                        <span class="fw-bold text-warning">12</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex justify-content-between">
                        <span>Klaim Disetujui</span>
                        <span class="fw-bold text-primary">30</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex justify-content-between">
                        <span>Klaim Ditolak</span>
                        <span class="fw-bold text-danger">3</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-dark">Riwayat Pembuatan SEP Hari Ini</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>No. SEP</th>
                    <th>No. Kartu</th>
                    <th>Nama Peserta</th>
                    <th>Poli</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1301R0011123V00001</td>
                    <td>0001234567890</td>
                    <td>BUDI SANTOSO</td>
                    <td>PENYAKIT DALAM</td>
                    <td><span class="badge bg-primary">Terbit</span></td>
                    <td><button class="btn btn-sm btn-outline-secondary"><i class="bi-printer"></i></button></td>
                </tr>
                <tr>
                    <td>1301R0011123V00002</td>
                    <td>0009876543210</td>
                    <td>SITI AMINAH</td>
                    <td>MATA</td>
                    <td><span class="badge bg-primary">Terbit</span></td>
                    <td><button class="btn btn-sm btn-outline-secondary"><i class="bi-printer"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
