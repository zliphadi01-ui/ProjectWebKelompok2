@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Pencarian Kartu Pasien</h3>

    <form class="row g-2 my-3" method="GET" action="{{ route('pasien.pencarian') }}">
        <div class="col-md-8">
            <input type="text" name="q" class="form-control" placeholder="Masukkan nama, No. RM, atau NIK" value="{{ $q ?? '' }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    @if(isset($results) && $results->count())
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead><tr><th>No RM</th><th>Nama</th><th>Jenis Kelamin</th><th>Umur</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($results as $p)
                    <tr>
                        <td>{{ $p->no_rm }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->jenis_kelamin }}</td>
                        <td>{{ $p->umur ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pasien.data') }}?q={{ urlencode($p->no_rm) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('pasien.cetak') }}?no_rm={{ $p->no_rm }}" class="btn btn-sm btn-outline-secondary">Cetak</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @elseif(isset($q))
        <p class="text-muted">Hasil tidak ditemukan untuk: <strong>{{ $q }}</strong></p>
    @endif
</div>
@endsection
