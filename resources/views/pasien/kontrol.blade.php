@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Data Pasien Kontrol</h3>
    <div class="card mt-3">
        <div class="card-body">
            <p class="text-muted">Pilih pasien untuk melihat riwayat kontrol atau mendaftar kontrol.</p>
            <ul class="list-group">
                @foreach($pasien as $p)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $p->nama }}</strong> <br>
                        <small>No. RM: {{ $p->no_rm }}</small>
                    </div>
                    <div>
                        <a href="#" class="btn btn-sm btn-primary">Daftar Kontrol</a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
