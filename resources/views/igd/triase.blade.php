@extends('layouts.app')

@section('content')
<div class="container-fluid" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Formulir Triase</h2>
        <a href="{{ route('igd.index') }}" class="btn btn-secondary">Batal</a>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-1">{{ $pendaftaran->pasien->nama }}</h5>
                    <p class="mb-0 text-muted">{{ $pendaftaran->pasien->no_rm }} | {{ $pendaftaran->pasien->jenis_kelamin }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="text-muted small">Waktu Masuk</div>
                    <div class="fw-bold">{{ $pendaftaran->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('igd.store-triase', $pendaftaran->id) }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- Kategori Triase --}}
            <div class="col-md-12">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold">1. Kategori Kegawatdaruratan (ATS)</div>
                    <div class="card-body">
                        <div class="row g-3 text-center">
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="kategori" id="merah" value="Merah" required>
                                <label class="btn btn-outline-danger w-100 py-3 h-100 d-flex flex-column justify-content-center" for="merah">
                                    <i class="bi-exclamation-triangle-fill fs-1 mb-2"></i>
                                    <span class="fw-bold">MERAH</span>
                                    <small>Resusitasi Segera</small>
                                </label>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="kategori" id="kuning" value="Kuning">
                                <label class="btn btn-outline-warning w-100 py-3 h-100 d-flex flex-column justify-content-center" for="kuning">
                                    <i class="bi-lightning-fill fs-1 mb-2"></i>
                                    <span class="fw-bold">KUNING</span>
                                    <small>Gawat Darurat</small>
                                </label>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="kategori" id="hijau" value="Hijau">
                                <label class="btn btn-outline-success w-100 py-3 h-100 d-flex flex-column justify-content-center" for="hijau">
                                    <i class="bi-person-check-fill fs-1 mb-2"></i>
                                    <span class="fw-bold">HIJAU</span>
                                    <small>Tidak Gawat</small>
                                </label>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="kategori" id="hitam" value="Hitam">
                                <label class="btn btn-outline-dark w-100 py-3 h-100 d-flex flex-column justify-content-center" for="hitam">
                                    <i class="bi-x-circle-fill fs-1 mb-2"></i>
                                    <span class="fw-bold">HITAM</span>
                                    <small>Meninggal (DOA)</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tanda Vital --}}
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">2. Tanda Vital Awal</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tekanan Darah (mmHg)</label>
                                <input type="text" name="tensi" class="form-control" placeholder="120/80">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nadi (bpm)</label>
                                <input type="number" name="nadi" class="form-control" placeholder="80">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Suhu (°C)</label>
                                <input type="text" name="suhu" class="form-control" placeholder="36.5">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pernafasan (x/menit)</label>
                                <input type="number" name="rr" class="form-control" placeholder="20">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Saturasi Oksigen (%)</label>
                                <input type="number" name="spo2" class="form-control" placeholder="98">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keluhan --}}
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">3. Keluhan Utama & Anamnesa Singkat</div>
                    <div class="card-body">
                        <textarea name="keluhan_utama" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 d-grid">
                <button type="submit" class="btn btn-primary btn-lg py-3">Simpan Triase & Lanjut Periksa</button>
            </div>
        </div>
    </form>
</div>
@endsection
