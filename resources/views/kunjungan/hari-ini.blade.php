@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Kunjungan Hari Ini</h2>
            <p class="text-muted">{{ now()->format('d F Y') }}</p>
        </div>
        <button class="btn btn-primary" onclick="location.reload()">
            <i class="fas fa-sync"></i> Refresh
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-label">Total Kunjungan</div>
                <div class="stat-value text-primary">{{ $statistik['total'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card warning">
                <div class="stat-label">Menunggu</div>
                <div class="stat-value text-warning">{{ $statistik['menunggu'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card primary">
                <div class="stat-label">Sedang Diperiksa</div>
                <div class="stat-value text-primary">{{ $statistik['sedang_diperiksa'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card success">
                <div class="stat-label">Selesai</div>
                <div class="stat-value text-success">{{ $statistik['selesai'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('kunjungan.filter') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <select name="poliklinik" class="form-control">
                            <option value="">Semua Poli</option>
                            @foreach(config('poli.options', []) as $poli)
                            <option value="{{ $poli }}" {{ request('poliklinik') == $poli ? 'selected' : '' }}>
                                {{ $poli }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dipanggil" {{ request('status') == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('kunjungan.hari-ini') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Kunjungan</h5>
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
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungan ?? [] as $k)
                        <tr>
                            <td><strong class="text-primary fs-4">{{ $k->no_antrian ?? '-' }}</strong></td>
                            <td>{{ $k->pasien->no_rm ?? $k->no_rm ?? '-' }}</td>
                            <td>{{ $k->pasien->nama ?? $k->nama ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $k->poli }}</span></td>
                            <td>{{ $k->created_at ? $k->created_at->format('H:i') : '-' }}</td>
                            <td>
                                @if($k->status == 'Menunggu')
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                                @elseif($k->status == 'Diperiksa')
                                <span class="badge bg-primary">
                                    <i class="fas fa-bell"></i> Diperiksa
                                </span>
                                @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> {{ $k->status }}
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($k->status == 'Menunggu')
                                    <a href="{{ route('kunjungan.panggil', $k->id) }}" class="btn btn-primary" onclick="return confirm('Panggil pasien ini?')">
                                        <i class="fas fa-bell"></i> Panggil
                                    </a>
                                    @endif
                                    <a href="{{ route('pemeriksaan.soap', $k->id) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-4x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">Belum Ada Kunjungan</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto refresh setiap 30 detik
setTimeout(function() {
    location.reload();
}, 30000);
</script>
@endpush
@endsection
