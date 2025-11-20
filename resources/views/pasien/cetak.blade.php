@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Cetak Kartu Pasien</h3>

    @if($pasien)
    <div class="card p-4 mt-3">
        <h5>{{ $pasien->nama }} ({{ $pasien->no_rm }})</h5>
        <p>NIK: {{ $pasien->nik ?? '-' }}</p>
        <p>TTL: {{ $pasien->tanggal_lahir ?? '-' }}</p>
        <p>Telepon: {{ $pasien->telepon ?? '-' }}</p>
        <p>Alamat: {{ $pasien->alamat ?? '-' }}</p>

        <a href="#" class="btn btn-primary mt-3" onclick="window.print()">Cetak / Print</a>
    </div>
    @else
    <div class="alert alert-info">Masukkan parameter no_rm pada query string untuk menampilkan pasien. Contoh: ?no_rm=RM-0001</div>
    @endif
</div>
@endsection
