@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2>Pendaftaran Pasien</h2>
        <p class="text-muted">Pilih jenis pendaftaran</p>
    </div>

    <!-- Pilihan Pendaftaran -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-center" style="border: 3px solid #3B82F6; cursor: pointer;"
                 onclick="window.location='{{ route('pendaftaran.create-baru') }}'">
                <div class="card-body py-5">
                    <i class="fas fa-user-plus fa-5x text-primary mb-3"></i>
                    <h3>Pasien Baru</h3>
                    <p class="text-muted">Daftarkan pasien yang belum pernah berkunjung</p>
                    <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-right"></i> Mulai Pendaftaran
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center" style="border: 3px solid #10B981; cursor: pointer;"
                 onclick="window.location='{{ route('pasien.pencarian') }}'">
                <div class="card-body py-5">
                    <i class="fas fa-user-check fa-5x text-success mb-3"></i>
                    <h3>Pasien Lama</h3>
                    <p class="text-muted">Cari data pasien yang sudah terdaftar</p>
                    <a href="{{ route('pasien.pencarian') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-search"></i> Cari Pasien
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Pendaftaran Hari Ini -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-calendar-day"></i> Pendaftaran Hari Ini</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>No. Antrian</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Poli</th>
                            <th>Jenis Pembayaran</th>
                            <th>Waktu Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran ?? [] as $p)
                        <tr>
                            <td><strong class="text-primary fs-5">{{ $p->no_antrian ?? '-' }}</strong></td>
                            <td>{{ $p->no_rm ?? $p->pasien->no_rm ?? '-' }}</td>
                            <td>{{ $p->nama ?? $p->pasien->nama ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $p->poli ?? '-' }}</span>
                            </td>
                            <td>
                                @if($p->jenis_pembayaran == 'BPJS')
                                <span class="badge bg-success">BPJS</span>
                                @else
                                <span class="badge bg-warning text-dark">{{ $p->jenis_pembayaran ?? 'Umum' }}</span>
                                @endif
                            </td>
                            <td>{{ $p->created_at ? $p->created_at->format('H:i') : '-' }}</td>
                            <td>
                                @if($p->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($p->status == 'dipanggil')
                                <span class="badge bg-primary">Dipanggil</span>
                                @else
                                <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pendaftaran.edit', $p->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Belum ada pendaftaran hari ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
