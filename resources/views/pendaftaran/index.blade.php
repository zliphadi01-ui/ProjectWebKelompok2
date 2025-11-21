@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pendaftaran Pasien</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Menampilkan pesan sukses atau error dari Controller --}}
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 fw-bold"><i class="bi-search me-2"></i>Cari Data Pasien</h6>
                </div>
                <div class="card-body text-center py-5">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('pendaftaran.index') }}" method="GET" class="mb-4">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control" placeholder="Masukkan Nama / NIK / No. RM..." value="{{ $query ?? '' }}" required>
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                        <small class="text-muted mt-2 d-block">Cari dulu sebelum input baru.</small>
                    </form>

                    {{-- Hasil Pencarian ditampilkan jika sudah ada query --}}
                    @if(isset($query))
                        <hr>
                        @if(isset($pasiens) && $pasiens->count() > 0)
                            <h5 class="text-success mb-3">Pasien Ditemukan: Silakan Daftar Poli</h5>
                            <div class="list-group text-start">
                                @foreach($pasiens as $p)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1 fw-bold">{{ $p->nama }}</h5>
                                        <small class="text-muted">RM: {{ $p->no_rm }} | NIK: {{ $p->nik }}</small>
                                    </div>
                                    <a href="{{ route('pendaftaran.daftar-poli', $p->id) }}" class="btn btn-success btn-sm">Daftar Poli</a>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning mt-3">
                                <p>Data pasien tidak ditemukan.</p>
                                <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary mt-2">
                                    <i class="bi-person-plus-fill"></i> Buat Pasien Baru
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