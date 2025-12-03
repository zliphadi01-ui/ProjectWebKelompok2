@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Pembuatan Surat Rujukan BPJS</h2>
        <button class="btn btn-outline-secondary"><i class="bi-clock-history me-2"></i> Riwayat Rujukan</button>
    </div>

    <div class="card border-0 shadow-lg">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 fw-bold">Form Rujukan Berjenjang (V-Claim)</h6>
        </div>
        <div class="card-body p-4">
            <form>
                <h5 class="text-muted mb-3 border-bottom pb-2">Data Pasien</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. Kartu BPJS</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Masukkan No. Kartu">
                            <button class="btn btn-secondary" type="button">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Pasien">
                    </div>
                </div>

                <h5 class="text-muted mb-3 border-bottom pb-2 mt-4">Data Rujukan</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Rujukan</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Pelayanan</label>
                        <select class="form-select">
                            <option>-- Pilih Pelayanan --</option>
                            <option>Rawat Jalan</option>
                            <option>Rawat Inap</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Diagnosa (ICD-10)</label>
                        <input type="text" class="form-control" placeholder="Contoh: I10 - Essential Hypertension">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Dirujuk Ke (PPK Rujukan)</label>
                        <input type="text" class="form-control" placeholder="Cari RS Rujukan...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Poli Rujukan</label>
                        <select class="form-select">
                            <option>-- Pilih Poli --</option>
                            <option>JANTUNG</option>
                            <option>BEDAH</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Catatan / Alasan Rujukan</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-light me-md-2" type="button">Batal</button>
                    <button class="btn btn-primary px-5 fw-bold" type="button"><i class="bi-printer me-2"></i> Simpan & Cetak Rujukan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
