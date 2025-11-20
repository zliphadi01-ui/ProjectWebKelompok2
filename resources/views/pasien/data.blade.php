@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Pasien</h3>
        <form class="d-flex" method="GET" action="{{ route('pasien.data') }}">
            <input type="text" name="q" class="form-control me-2" placeholder="Cari nama atau No. RM" value="{{ request('q') }}">
            <button class="btn btn-outline-primary">Cari</button>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>No. RM</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pasien as $p)
                    <tr>
                        <td>{{ $loop->iteration + ($pasien->currentPage()-1) * $pasien->perPage() }}</td>
                        <td>{{ $p->no_rm }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->jenis_kelamin }}</td>
                        <td>{{ $p->telepon ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pasien.show', $p->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('pasien.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-3">
                {{ $pasien->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
