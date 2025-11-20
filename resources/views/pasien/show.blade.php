@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pasien</h1>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>No. RM</th><td>{{ $pasien->no_rm }}</td></tr>
                <tr><th>Nama</th><td>{{ $pasien->nama }}</td></tr>
                <tr><th>NIK</th><td>{{ $pasien->nik }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>{{ $pasien->jenis_kelamin }}</td></tr>
                <tr><th>Tanggal Lahir</th><td>{{ $pasien->tanggal_lahir }}</td></tr>
                <tr><th>Telepon</th><td>{{ $pasien->telepon }}</td></tr>
                <tr><th>Email</th><td>{{ $pasien->email }}</td></tr>
                <tr><th>Alamat</th><td>{{ $pasien->alamat }}</td></tr>
            </table>

            <a href="{{ route('pasien.edit', ['id' => $pasien->id]) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('pasien.data') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
