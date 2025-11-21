@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pendaftaran Pasien</h1>

    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- KOTAK PENCARIAN UTAMA --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 fw-bold"><i class="bi-search me-2"></i>Cari Data Pasien Terlebih Dahulu</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('pendaftaran.index') }}" method="GET">
                        <div class="input-group input-group-lg">
                            {{-- Input pencarian --}}
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Masukkan Nama, NIK, atau No. RM..." 
                                   value="{{ $query ?? '' }}" autofocus required>
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                        <small class="text-muted ms-1">
                            Sistem akan mengecek apakah pasien sudah terdaftar untuk mencegah duplikasi No. RM.
                        </small>
                    </form>
                </div>
            </div>

            {{-- LOGIKA HASIL PENCARIAN --}}
            @if(isset($query))
                @if(isset($pasiens) && $pasiens->count() > 0)
                    {{-- SKENARIO A: PASIEN DITEMUKAN --}}
                    <div class="card shadow mb-4 border-left-success">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-success">Hasil Pencarian: Ditemukan {{ $pasiens->count() }} Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No. RM</th>
                                            <th>Nama Pasien</th>
                                            <th>NIK</th>
                                            <th>Alamat</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pasiens as $p)
                                        <tr>
                                            <td class="fw-bold">{{ $p->no_rm }}</td>
                                            <td>
                                                {{ $p->nama }} <br>
                                                <small class="text-muted">{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} | {{ $p->tanggal_lahir }}</small>
                                            </td>
                                            <td>{{ $p->nik }}</td>
                                            <td>{{ $p->alamat }}</td>
                                            <td class="text-center">
                                                {{-- TOMBOL DAFTAR BEROBAT --}}
                                                <a href="{{ route('pendaftaran.daftar-poli', $p->id) }}" class="btn btn-success">
                                                    <i class="bi-clipboard-plus"></i> Daftar Berobat
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- SKENARIO B: PASIEN TIDAK DITEMUKAN --}}
                    <div class="alert alert-warning text-center py-5 shadow-sm" role="alert">
                        <i class="bi-exclamation-circle display-4 text-warning mb-3 d-block"></i>
                        <h4 class="alert-heading">Data Pasien Tidak Ditemukan</h4>
                        <p>
                            Tidak ada data pasien dengan kata kunci "<strong>{{ $query }}</strong>". <br>
                            Silakan buat data pasien baru.
                        </p>
                        <hr>
                        {{-- TOMBOL BUAT BARU --}}
                        <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary btn-lg">
                            <i class="bi-person-plus-fill me-2"></i> Buat Pasien Baru
                        </a>
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection