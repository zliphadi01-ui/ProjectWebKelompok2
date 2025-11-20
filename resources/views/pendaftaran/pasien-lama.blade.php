@extends('layouts.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">Cari Pasien Lama</div>
    <div class="card-body">
        <form action="{{ route('pasien.pencarian') }}" method="GET">
            <div class="mb-3">
                <label>Masukkan NIK atau Nama</label>
                <input type="text" name="q" class="form-control" placeholder="Cari data pasien lama...">
            </div>
            <button class="btn btn-primary">Cari</button>
        </form>
    </div>
</div>
@endsection
