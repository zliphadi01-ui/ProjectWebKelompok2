@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span>Data Kunjungan Pasien</span>
        {{-- Tombol menuju halaman pencarian/daftar baru --}}
        <a href="{{ route('pendaftaran.index') }}" class="btn btn-light btn-sm text-primary fw-bold">
            <i class="bi-plus-circle me-1"></i> Daftar Baru
        </a>
    </div>

    <div class="card-body">
        {{-- Notifikasi Sukses/Error --}}
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>No Daftar</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-primary">{{ $p->no_daftar }}</td>
                        
                        {{-- Nama Pasien (Logika Aman: Cek nama di pendaftaran, kalau ga ada, cek relasi pasien) --}}
                        <td class="fw-bold">
                            {{ $p->nama ?? ($p->pasien->nama ?? 'Tanpa Nama') }} <br>
                            <small class="text-muted">RM: {{ $p->pasien->no_rm ?? '-' }}</small>
                        </td>
                        
                        <td>{{ $p->poli }}</td>
                        
                        {{-- Status --}}
                        <td>
                            <span class="badge bg-{{ $p->status == 'Menunggu' ? 'warning' : 'info' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        
                        {{-- Tombol Aksi --}}
                        <td>
                            <form action="{{ route('pendaftaran.destroy', $p->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data kunjungan yang tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Tampilkan pagination --}}
        <div class="mt-3">
            {{ $pendaftaran->links() }}
        </div>
    </div>
</div>
@endsection