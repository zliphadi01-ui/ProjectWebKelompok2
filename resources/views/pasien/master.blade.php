@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Master Pasien</h3>
    <div class="card mt-3">
        <div class="card-body">
            <a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3">Tambah Pasien</a>
            <table class="table table-bordered">
                <thead><tr><th>No</th><th>No. RM</th><th>Nama</th><th>Tanggal Lahir</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($pasien as $p)
                    <tr>
                        <td>{{ $loop->iteration + ($pasien->currentPage()-1) * $pasien->perPage() }}</td>
                        <td>{{ $p->no_rm }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->tanggal_lahir ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pasien.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pasien.destroy', $p->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $pasien->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
