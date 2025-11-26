@extends('layouts.app')
@push('styles')
<style>
    :root{ --rme-accent:#0d6efd; --rme-accent-2:#0b5ed7; --rme-muted:#6c757d; }
    /* Card and header */
    .card { border-radius: 12px; box-shadow: 0 6px 20px rgba(15,23,42,0.06); }
    .card-header { background: linear-gradient(90deg,var(--rme-accent),var(--rme-accent-2)); color: #fff !important; font-weight: 700; font-size: 1.05rem; border-top-left-radius:12px; border-top-right-radius:12px; }

    /* Inputs and selects */
    .form-control, .form-select { font-size: 1rem; padding: .72rem .75rem; border-radius: 8px; }
    label { font-weight: 600; color: #222; font-size: .98rem; }

    /* Buttons */
    .btn-success { background: linear-gradient(180deg,#17a673,#138a5a); border: none; box-shadow: none; padding: .55rem 1.05rem; font-weight:600; }
    .btn-outline-secondary { border-radius: 8px; padding: .45rem .7rem; }

    /* Result list */
    #pasien_results { border-radius: 8px; border: 1px solid rgba(13,110,253,0.08); }
    #pasien_results .list-group-item { transition: background .12s, transform .06s; font-size: .96rem; padding: .6rem .9rem; }
    #pasien_results .list-group-item:hover { background: rgba(13,110,253,0.06); transform: translateY(-2px); }

    /* Slightly larger card body spacing */
    .card-body { padding: 1.3rem; }

    @media (max-width: 576px) {
        .form-control, .form-select { font-size: .95rem; }
        .card { margin: 0 8px; }
    }
</style>
@endpush
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span class="fw-bold">Form Pendaftaran Pasien Baru</span>
        <a href="{{ route('pendaftaran.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('pendaftaran.store-baru') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label>Nama Pasien</label>
                <input type="text" name="nama" id="nama" class="form-control" required placeholder="Nama Lengkap Pasien">
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" 
                    placeholder="Masukkan 16 digit NIK..."
                    required 
                    pattern="[0-9]{16}"
                    maxlength="16"
                    minlength="16"
                    title="NIK harus terdiri dari 16 angka."
                >
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control" placeholder="08xxxxxxxxxx">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="2" placeholder="Alamat Lengkap"></textarea>
            </div>
            <div class="mb-3">
                <label>Poli Tujuan</label>
                <select name="poli" id="poli" class="form-select" required>
                    <option value="">-- Pilih Poli --</option>
                    @foreach($poliList as $poli)
                        <option value="{{ $poli }}">{{ $poli }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">Simpan & Daftar</button>
            </div>
        </form>
    </div>
</div>
@endsection
