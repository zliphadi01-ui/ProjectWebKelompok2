@extends('layouts.app')

@section('content')
<h3>Detail Rawat Inap</h3>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Pasien</dt>
            <dd class="col-sm-9">{{ $item->pasien?->nama ?? '-' }}</dd>

            <dt class="col-sm-3">Kamar</dt>
            <dd class="col-sm-9">{{ $item->kamar }}</dd>

            <dt class="col-sm-3">No Kamar</dt>
            <dd class="col-sm-9">{{ $item->no_kamar }}</dd>

            <dt class="col-sm-3">Tanggal Masuk</dt>
            <dd class="col-sm-9">{{ $item->tanggal_masuk }}</dd>

            <dt class="col-sm-3">Tanggal Keluar</dt>
            <dd class="col-sm-9">{{ $item->tanggal_keluar ?? '-' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ $item->status }}</dd>

            <dt class="col-sm-3">Diagnosis</dt>
            <dd class="col-sm-9">{{ $item->diagnosis }}</dd>

            <dt class="col-sm-3">Catatan</dt>
            <dd class="col-sm-9">{{ $item->notes }}</dd>
        </dl>

        <a href="{{ route('rawat-inap.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('rawat-inap.edit', $item->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection
