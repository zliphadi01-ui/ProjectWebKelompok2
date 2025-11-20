@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Pendaftaran</h3>
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('pendaftaran.update', ['id' => $data->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Poli</label>
                    <input type="text" name="poli" class="form-control" value="{{ old('poli', $data->poli) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Terdaftar" {{ $data->status == 'Terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                        <option value="Dalam Proses" {{ $data->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="Selesai" {{ $data->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ $data->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('pendaftaran.list') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

