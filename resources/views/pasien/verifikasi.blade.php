@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Verifikasi Pasien</h1>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->no_rm }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->tanggal_lahir }}</td>
                                <td>
                                    <a href="{{ route('pasien.show', ['id' => $p->id]) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ route('pasien.edit', ['id' => $p->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('pasien.destroy', ['id' => $p->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus pasien ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pasien untuk diverifikasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
