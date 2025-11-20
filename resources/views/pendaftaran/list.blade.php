@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        Daftar Pendaftaran Pasien
    </div>

    <div class="card-body">
        {{-- Tampilkan notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tabel data --}}
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>No Daftar</th>
                    <th>Nama</th>
                    <th>Poli</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pendaftaran as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->no_daftar }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->poli }}</td>
                    <td>{{ $p->status }}</td>
                    <td>{{ $p->created_at ? $p->created_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <a href="{{ route('pendaftaran.edit', ['id' => $p->id]) }}" class="btn btn-sm btn-warning">Edit</a>

                        {{-- Tombol Mulai Pemeriksaan --}}
                        @if($p->status !== 'Dalam Pemeriksaan' && $p->status !== 'Pulang')
                        <form action="{{ route('pendaftaran.start-pemeriksaan', ['id' => $p->id]) }}" method="POST" style="display:inline-block; margin-left:6px;">
                            @csrf
                            <button class="btn btn-sm btn-primary">Mulai Pemeriksaan</button>
                        </form>
                        @endif

                        {{-- Tombol Pulangkan --}}
                        @if($p->status !== 'Pulang')
                        <form action="{{ route('pendaftaran.discharge', ['id' => $p->id]) }}" method="POST" style="display:inline-block; margin-left:6px;">
                            @csrf
                            <button class="btn btn-sm btn-success" onclick="return confirm('Tandai pasien ini telah pulang?')">Pulang</button>
                        </form>
                        @endif

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('pendaftaran.destroy', ['id' => $p->id]) }}" method="POST" style="display:inline-block; margin-left:6px;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
