@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h3>{{ $title ?? 'Halaman' }}</h3>
        <p class="text-muted">Halaman ini dibuat otomatis sebagai placeholder yang terhubung ke database bila tersedia.</p>

        @if(!empty($counts))
            <div class="row">
                @foreach($counts as $k => $v)
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded bg-light">
                            <strong>{{ ucfirst($k) }}</strong>
                            <div class="fs-4">{{ $v }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">Belum ada tabel terkait di database atau tidak ada data untuk ditampilkan.</div>
        @endif

        {{-- Simple action area: link to lists if model/tables exist --}}
        <div class="mt-4">
            @if(Schema::hasTable('pasien'))
                <a href="{{ url('/pasien/data') }}" class="btn btn-primary me-2">Telusuri Pasien</a>
            @endif
            @if(Schema::hasTable('pendaftarans'))
                <a href="{{ url('/pendaftaran/list') }}" class="btn btn-secondary">List Pendaftaran</a>
            @endif
        </div>
    </div>
</div>
@endsection
