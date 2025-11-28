@extends('layouts.app')

@section('content')
<div class="container-fluid" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-danger fw-bold">Pendaftaran Pasien IGD</h2>
        <a href="{{ route('igd.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow-lg border-0 border-top border-5 border-danger">
        <div class="card-body p-5">
            <form action="{{ route('igd.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Cari Pasien (Nama / No RM / NIK)</label>
                    <select name="pasien_id" class="form-select form-select-lg" required>
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($pasienData as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->no_rm }}) - {{ $p->nik }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">Jika pasien baru belum ada, silakan daftar di menu Pendaftaran Pasien Baru terlebih dahulu (atau implementasikan Quick Register di sini).</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Keluhan Utama (Alasan Masuk)</label>
                    <textarea name="keluhan_utama" class="form-control" rows="3" placeholder="Contoh: Sesak nafas berat, nyeri dada kiri menjalar..." required></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-lg py-3 fw-bold">
                        <i class="bi-save me-2"></i> MASUKKAN KE IGD
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
