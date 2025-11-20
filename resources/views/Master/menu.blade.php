@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Menu Master Data</h3>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Keadaan Akhir</h5>
                    <p class="card-text text-muted">Mengelola data kondisi pasien setelah perawatan selesai.</p>
                    <a href="{{ route('master-data.keadaan-akhir') }}" class="btn btn-outline-primary">Buka</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Pegawai</h5>
                    <p class="card-text text-muted">Menampilkan daftar pegawai dan status aktifasi di unit layanan.</p>
                    <a href="{{ route('master-data.pegawai') }}" class="btn btn-outline-primary">Buka</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Vendor & Mitra</h5>
                    <p class="card-text text-muted">Mengatur data mitra dan penyedia jasa terkait pelayanan kesehatan.</p>
                    <a href="#" class="btn btn-outline-primary">Buka</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
