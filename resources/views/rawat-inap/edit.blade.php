@extends('layouts.app')

@section('content')
<h3>Edit Rawat Inap</h3>

<form method="POST" action="{{ route('rawat-inap.update', $item->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Pasien</label>
        <select name="pasien_id" class="form-select">
            <option value="">-- Pilih Pasien (opsional) --</option>
            @foreach($pasien as $p)
                <option value="{{ $p->id }}" {{ $item->pasien_id == $p->id ? 'selected' : '' }}>{{ $p->no_rm ?? '' }} - {{ $p->nama ?? $p->nama_lengkap ?? 'Pasien' }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Kamar</label>
            <input type="text" name="kamar" value="{{ $item->kamar }}" class="form-control" />
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">No Kamar</label>
            <input type="text" name="no_kamar" value="{{ $item->no_kamar }}" class="form-control" />
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Masuk</label>
        <input type="datetime-local" name="tanggal_masuk" value="{{ optional($item->tanggal_masuk)->format('Y-m-d\TH:i') }}" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Keluar</label>
        <input type="datetime-local" name="tanggal_keluar" value="{{ optional($item->tanggal_keluar)->format('Y-m-d\TH:i') }}" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <input type="text" name="status" value="{{ $item->status }}" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Diagnosis</label>
        <textarea name="diagnosis" class="form-control" rows="3">{{ $item->diagnosis }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control" rows="2">{{ $item->notes }}</textarea>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('rawat-inap.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
