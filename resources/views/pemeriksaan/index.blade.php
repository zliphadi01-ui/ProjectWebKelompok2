@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Daftar Pasien Pemeriksaan</h2>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
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
                            <!-- Nomor urut -->
                            <td>{{ $loop->iteration }}</td> 
                            
                            <!-- Data Pasien (dari relasi) -->
                            <td class="fw-bold text-dark">
                                {{ $item->pasien->nama ?? $item->nama ?? 'Data Tidak Lengkap' }}
                            </td>
                            
                            <!-- No. RM -->
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $item->pasien->no_rm ?? '-' }}
                                </span>
                            </td>
                            
                            <!-- Umur (HITUNG OTOMATIS DISINI) -->
                            <td>
                                @if($item->pasien && $item->pasien->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($item->pasien->tanggal_lahir)->age }} Tahun
                                @else
                                    <span class="text-muted small">Belum set tgl lahir</span>
                                @endif
                            </td> 
                            
                            <!-- Data Pendaftaran -->
                            <td>{{ $item->poli ?? '-' }}</td> 
                            
                            <!-- Status -->
                            <td>
                                @if($item->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($item->status == 'Dalam Pemeriksaan')
                                    <span class="badge bg-info text-white">Sedang Diperiksa</span>
                                @elseif($item->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endif
                            </td>

                            <!-- Tombol Aksi -->
                            <td>
                                <a href="{{ route('pemeriksaan.soap', $item->id) }}" class="btn btn-primary btn-sm">
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
@endsection