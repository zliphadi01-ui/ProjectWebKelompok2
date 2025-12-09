@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0">Daftar Pasien</h2>
            <p class="text-muted mb-0">Pilih pasien untuk mengajukan permintaan akses rekam medis</p>
        </div>
        <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <!-- Search Form -->
            <form method="GET" action="{{ route('dokter.rekam-medis.patients') }}" class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari berdasarkan nama, No. RM, atau NIK..." 
                           value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    @if($search)
                        <a href="{{ route('dokter.rekam-medis.patients') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>

            <!-- Patients Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur</th>
                            <th>Telepon</th>
                            <th>Status Akses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasienList as $pasien)
                            <tr>
                                <td><span class="badge bg-light text-dark">{{ $pasien->no_rm }}</span></td>
                                <td>{{ $pasien->nama }}</td>
                                <td>{{ $pasien->jenis_kelamin }}</td>
                                <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun</td>
                                <td>{{ $pasien->telepon ?? '-' }}</td>
                                <td>
                                    @php
                                        $status = $pasien->requestStatus;
                                    @endphp
                                    <span class="badge bg-{{ $status['class'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                    @if($status['status'] == 'active' && $pasien->latestRequest)
                                        <small class="text-muted d-block">
                                            {{ $pasien->latestRequest->getExpirationStatus() }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($status['status'] == 'no_access' || $status['status'] == 'rejected' || $status['status'] == 'expired')
                                        <a href="{{ route('dokter.rekam-medis.request', $pasien->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-file-earmark-plus me-1"></i>Ajukan Akses
                                        </a>
                                    @elseif($status['status'] == 'pending')
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    @elseif($status['status'] == 'active')
                                        <a href="{{ route('dokter.rekam-medis.view', $pasien->id) }}" 
                                           class="btn btn-sm btn-success">
                                            <i class="bi bi-eye me-1"></i>Lihat Rekam Medis
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    @if($search)
                                        <p class="text-muted">Tidak ada pasien yang cocok dengan pencarian "{{ $search }}"</p>
                                    @else
                                        <p class="text-muted">Belum ada data pasien</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pasienList->hasPages())
                <div class="mt-3">
                    {{ $pasienList->appends(['search' => $search])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
