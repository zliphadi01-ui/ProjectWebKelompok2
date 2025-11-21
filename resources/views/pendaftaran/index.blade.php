@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        Daftar Kunjungan Pasien ({{ $pendaftaran->count() }})
    </div>

    <div class="card-body">
        {{-- Tampilkan Pesan Sukses/Gagal --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>No Daftar</th>
                    <th>Nama Pasien</th>
                    <th>Poli Tujuan</th>
                    <th>Status</th>
                    <th>Waktu Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold text-primary">{{ $p->no_daftar }}</td>
                    
                    {{-- AMBIL NAMA (Coba dari relasi pasien dulu, kalau kosong ambil dari kolom nama) --}}
                    <td class="fw-bold">
                        {{ $p->pasien->nama ?? $p->nama ?? 'Tanpa Nama' }} <br>
                        <small class="text-muted">RM: {{ $p->pasien->no_rm ?? '-' }}</small>
                    </td>
                    
                    <td>{{ $p->poli }}</td>
                    
                    <td>
                        <span class="badge bg-{{ $p->status == 'Selesai' ? 'success' : 'warning' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    
                    <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pendaftaran.destroy', $p->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Belum ada pasien yang mendaftar hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- Pagination --}}
        <div class="mt-3">
            {{ $pendaftaran->links() }}
        </div>
    </div>
</div>
@endsection