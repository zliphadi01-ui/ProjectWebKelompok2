@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Daftar Pasien Pemeriksaan</h2>
</div>

<div class="card shadow border-0 rounded-4">
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>No. RM</th>
                        <th>Umur</th>
                        <th>Poli</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar_pasien as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td> 
                            
                            <td class="fw-bold">
                                {{ $item->pasien->nama ?? $item->nama ?? 'Data Tidak Lengkap' }}
                            </td>
                            
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2">
                                    {{ $item->pasien->no_rm ?? '-' }}
                                </span>
                            </td>
                            
                            <td>
                                @if($item->pasien && $item->pasien->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($item->pasien->tanggal_lahir)->age }} Tahun
                                @else
                                    <span class="text-muted small">Belum set tgl lahir</span>
                                @endif
                            </td> 
                            
                            <td>{{ $item->poli ?? '-' }}</td> 
                            
                            <td>
                                @if($item->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
                                @elseif($item->status == 'Dalam Pemeriksaan')
                                    <span class="badge bg-info text-dark px-3 py-2">Sedang Diperiksa</span>
                                @elseif($item->status == 'Selesai')
                                    <span class="badge bg-success px-3 py-2">Selesai</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">{{ $item->status }}</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('pemeriksaan.soap', $item->id) }}" class="btn btn-primary btn-sm px-3">
                                    <i class="bi-stethoscope me-1"></i> Mulai Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi-clipboard-x display-6 d-block mb-3"></i>
                                Belum ada pasien dalam antrean pemeriksaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<style>
/* === TEMA WARNA UTAMA === */
.text-primary {
    color: #40407a !important;
}

.btn-primary {
    background-color: #40407a !important;
    border-color: #40407a !important;
}

.btn-primary:hover {
    background-color: #2f2f66 !important;
    border-color: #2f2f66 !important;
}

/* === HEADER TABEL AGAR TULISAN TIDAK PUTIH === */
.table thead {
    background-color: #f8f9fa !important;
}

.table thead th {
    color: #212529 !important;
    font-weight: 600;
}

/* === HOVER TABEL MODERN === */
.table-hover tbody tr:hover {
    background-color: rgba(64, 64, 122, 0.06) !important;
    transition: 0.2s;
}

/* === CARD LEBIH MODERN === */
.card {
    border-radius: 18px;
}
</style>

@endsection
