@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pendaftaran Pasien</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Menampilkan pesan sukses atau error dari Controller --}}
            @if(session('success')) <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> @endif
            @if(session('error')) <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> @endif

            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary"><i class="bi-search me-2"></i>Cari Data Pasien Lama</h6>
                    <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bi-person-plus-fill me-1"></i> Pasien Baru
                    </a>
                </div>
                <div class="card-body text-center py-5">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('pendaftaran.index') }}" method="GET" class="mb-4">
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="bi-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control border-start-0" placeholder="Masukkan Nama / NIK / No. RM..." value="{{ $query ?? '' }}" required>
                            <button class="btn btn-primary px-4" type="submit">Cari</button>
                        </div>
                        <small class="text-muted mt-5 d-block">Cari pasien yang sudah pernah berobat sebelumnya.</small>
                    </form>

                    {{-- Hasil Pencarian ditampilkan jika sudah ada query --}}
                    @if(isset($query))
                        <hr>
                        @if(isset($pasiens) && $pasiens->count() > 0)
                            <div class="text-start">
                                <h5 class="text-success mb-3 fw-bold"><i class="bi-check-circle-fill me-2"></i>Pasien Ditemukan</h5>
                                <div class="list-group shadow-sm">
                                    @foreach($pasiens as $p)
                                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">
                                                {{ $p->nama }}
                                                @if($p->jenis_pembayaran == 'BPJS')
                                                    <span class="badge bg-success ms-2">BPJS</span>
                                                @endif
                                            </h5>
                                            <div class="text-muted small">
                                                <span class="me-3"><i class="bi-card-heading me-1"></i> RM: {{ $p->no_rm }}</span>
                                                <span class="me-3"><i class="bi-person-vcard me-1"></i> NIK: {{ $p->nik }}</span>
                                                @if($p->jenis_pembayaran == 'BPJS' && $p->no_bpjs)
                                                    <span class="me-3"><i class="bi-shield-fill-check me-1 text-success"></i> BPJS: {{ $p->no_bpjs }}</span>
                                                @endif
                                                <span><i class="bi-geo-alt me-1"></i> {{ $p->alamat ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('pendaftaran.daftar-poli', $p->id) }}" class="btn btn-success rounded-pill px-4">
                                            Daftar Poli <i class="bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning mt-4 p-4 shadow-sm border-0" style="background-color: #fff3cd; color: #856404;">
                                <h4 class="alert-heading fw-bold"><i class="bi-exclamation-triangle-fill me-2"></i>Data tidak ditemukan!</h4>
                                <p>Pasien dengan kata kunci <strong>"{{ $query }}"</strong> tidak ditemukan di database.</p>
                                <hr>
                                <p class="mb-0">Apakah ini pasien baru?</p>
                                <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary mt-3 px-4 rounded-pill shadow-sm">
                                    <i class="bi-person-plus-fill me-2"></i> Buat Pasien Baru
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection