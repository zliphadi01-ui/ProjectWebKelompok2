@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">
        <i class="bi-card-text me-2"></i>
        Cetak Kartu Pasien
    </h3>

    @if($pasien)
    <div class="card shadow-sm border-0 p-4 mt-3 rounded-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">{{ $pasien->nama }} 
                <span class="text-muted">({{ $pasien->no_rm }})</span>
            </h5>

            {{-- FOTO PASIEN --}}
            <img src="{{ $pasien->foto 
                ? asset('storage/pasien/'.$pasien->foto) 
                : 'https://via.placeholder.com/100?text=Pasien' }}"
                 class="rounded shadow-sm"
                 alt="Foto Pasien"
                 width="90" height="90"
                 style="object-fit: cover; border: 2px solid #ddd;">
        </div>

        <hr>

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold text-secondary">NIK</div>
            <div class="col-md-8">{{ $pasien->nik ?? '-' }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold text-secondary">Tanggal Lahir</div>
            <div class="col-md-8">{{ $pasien->tanggal_lahir ?? '-' }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold text-secondary">Telepon</div>
            <div class="col-md-8">{{ $pasien->telepon ?? '-' }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold text-secondary">Alamat</div>
            <div class="col-md-8">{{ $pasien->alamat ?? '-' }}</div>
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary px-4 py-2 fw-semibold" onclick="window.print()">
                <i class="bi-printer me-2"></i> Cetak / Print
            </a>
        </div>

    </div>

    @else
    <div class="alert alert-info d-flex align-items-center">
        <i class="bi-info-circle me-2 fs-5"></i>
        Masukkan parameter <strong>no_rm</strong> pada query string untuk menampilkan pasien.
        <span class="ms-2">Contoh: <code>?no_rm=RM-0001</code></span>
    </div>
    @endif
</div>

{{-- Styling khusus print --}}
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }
    }
</style>
@endsection
