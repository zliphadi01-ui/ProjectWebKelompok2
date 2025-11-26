@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pemeriksaan Medis (SOAP)</h1>
    <a href="{{ route('kunjungan.hari-ini') }}" class="btn btn-secondary">
        <i class="bi-arrow-left me-1"></i> Kembali
    </a>
</div>

{{-- 1. BLOK ERROR VALIDASI (PENTING AGAR TAU KENAPA GAGAL) --}}
@if ($errors->any())
    <div class="alert alert-danger shadow-sm border-left-danger">
        <h6 class="font-weight-bold"><i class="bi bi-exclamation-triangle-fill"></i> Gagal Menyimpan!</h6>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    {{-- KOLOM KIRI: DATA PASIEN --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-info text-white py-3">
                <h6 class="m-0 fw-bold"><i class="bi bi-person-circle"></i> Data Pasien</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('adminlte/dist/assets/img/avatar.png') }}" class="img-fluid rounded-circle" style="width: 80px;">
                    <h5 class="mt-2 fw-bold">{{ $pasien->nama ?? 'Nama Tidak Diketahui' }}</h5>
                    <span class="badge bg-primary">{{ $pasien->no_rm ?? '-' }}</span>
                </div>
                <hr>
                <table class="table table-sm table-borderless" style="font-size: 0.9rem;">
                    <tr><td class="text-muted">Gender:</td><td class="fw-bold">{{ $pasien->jenis_kelamin ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Umur:</td><td class="fw-bold">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age ?? '-' }} Tahun</td></tr>
                    <tr><td class="text-muted">Alergi:</td><td class="text-danger fw-bold">{{ $pasien->alergi ?? 'Tidak Ada' }}</td></tr>
                    <tr><td class="text-muted">Alamat:</td><td>{{Str::limit($pasien->alamat ?? '-', 30)}}</td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: FORM SOAP --}}
    <div class="col-md-8">
        <form action="{{ route('pemeriksaan.store') }}" method="POST">
            @csrf
            {{-- Input Hidden --}}
            <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id ?? '' }}">
            <input type="hidden" name="pasien_id" value="{{ $pasien->id ?? '' }}">

            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3 border-bottom-primary">
                    <h6 class="m-0 fw-bold text-primary">Rekam Medis (SOAP)</h6>
                </div>
                <div class="card-body">
                    
                    {{-- SUBJECTIVE --}}
                    <div class="mb-3">
                        <label class="fw-bold text-primary">S - Subjective (Keluhan)</label>
                        <textarea name="subjective" class="form-control" rows="3" placeholder="Keluhan pasien..." required>{{ old('subjective') }}</textarea>
                    </div>

                    {{-- OBJECTIVE --}}
                    <div class="mb-3">
                        <label class="fw-bold text-success">O - Objective (Pemeriksaan Fisik)</label>
                        
                        <div class="row g-2 mb-2 bg-light p-2 rounded border">
                            <div class="col-6 col-md-3">
                                <label class="small">Tensi (mmHg)</label>
                                <input type="text" name="tekanan_darah" class="form-control form-control-sm" placeholder="120/80" value="{{ old('tekanan_darah') }}">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small">Nadi (/mnt)</label>
                                <input type="text" name="nadi" class="form-control form-control-sm" placeholder="80" value="{{ old('nadi') }}">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small">Suhu (°C)</label>
                                <input type="text" name="suhu" class="form-control form-control-sm" placeholder="36" value="{{ old('suhu') }}">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small">Berat (Kg)</label>
                                <input type="text" name="berat_badan" class="form-control form-control-sm" placeholder="60" value="{{ old('berat_badan') }}">
                            </div>
                        </div>

                        <textarea name="objective" class="form-control" rows="3" placeholder="Hasil pemeriksaan fisik..." required>{{ old('objective') }}</textarea>
                    </div>

                    {{-- ASSESSMENT --}}
                    <div class="mb-3">
                        <label class="fw-bold text-warning">A - Assessment (Diagnosa)</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-warning text-white">ICD-10</span>
                            <input type="text" name="icd_code" class="form-control" placeholder="Kode (Opsional)" value="{{ old('icd_code') }}">
                        </div>
                        <input type="text" name="diagnosis" class="form-control mb-2 fw-bold" placeholder="Nama Diagnosa Utama (Wajib)" required value="{{ old('diagnosis') }}">
                        
                        {{-- Catatan Assessment dibuat tidak wajib di Controller --}}
                        <textarea name="assessment" class="form-control" rows="2" placeholder="Catatan tambahan diagnosa (Opsional)">{{ old('assessment') }}</textarea>
                    </div>

                    {{-- PLAN --}}
                    <div class="mb-3">
                        <label class="fw-bold text-info">P - Plan (Rencana/Terapi)</label>
                        <textarea name="plan" class="form-control" rows="3" placeholder="Rencana pengobatan & resep..." required>{{ old('plan') }}</textarea>
                    </div>

                </div>
                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                    <button type="submit" name="action" value="save" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Saja
                    </button>
                    <button type="submit" name="action" value="print" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Simpan & Cetak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection