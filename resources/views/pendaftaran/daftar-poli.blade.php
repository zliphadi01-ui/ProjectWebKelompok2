@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow col-md-6 mx-auto">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Daftar Berobat (Pasien Lama)</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Pasien:</strong> {{ $pasien->nama }} <br>
                <strong>No. RM:</strong> {{ $pasien->no_rm }}
            </div>

            <form action="{{ route('pendaftaran.store-poli') }}" method="POST">
                @csrf
                {{-- ID Pasien Disembunyikan --}}
                <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Poli Tujuan</label>
                    <select name="poli" class="form-select" required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach($poliList as $poli)
                            <option value="{{ $poli }}">{{ $poli }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Daftarkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection