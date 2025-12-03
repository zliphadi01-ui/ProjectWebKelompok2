@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h2>Dashboard Klinik</h2>
        <p class="text-muted">Selamat datang, {{ Auth::user()->name ?? 'Admin' }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-label">Pasien Baru</div>
                        <div class="stat-value text-primary" id="val-pasien-baru">{{ $pasien_baru ?? 0 }}</div>
                    </div>
                    <i class="fas fa-users fa-3x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card success">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-label">Kunjungan Hari Ini</div>
                        <div class="stat-value text-success" id="val-kunjungan">{{ $kunjungan_hari_ini ?? 0 }}</div>
                    </div>
                    <i class="fas fa-calendar-check fa-3x text-success opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card warning">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-label">Resep Pending</div>
                        <div class="stat-value text-warning" id="val-resep">{{ $resep_pending ?? 0 }}</div>
                    </div>
                    <i class="fas fa-prescription-bottle-alt fa-3x text-warning opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card danger">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-label">Antrian Aktif</div>
                        <div class="stat-value text-danger" id="val-antrean">{{ $antrean_aktif ?? 0 }}</div>
                    </div>
                    <i class="fas fa-clock fa-3x text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @php $role = Auth::user()->role ?? 'guest'; @endphp

                        @if(in_array($role, ['admin', 'pendaftaran']))
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary btn-lg w-100 py-4">
                                <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                                Pendaftaran Pasien
                            </a>
                        </div>
                        @endif

                        @if(in_array($role, ['admin', 'dokter']))
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pemeriksaan.index') }}" class="btn btn-success btn-lg w-100 py-4">
                                <i class="fas fa-stethoscope fa-2x d-block mb-2"></i>
                                Pemeriksaan
                            </a>
                        </div>
                        @endif

                        @if(in_array($role, ['admin', 'pendaftaran', 'rekam_medis']))
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pasien.data') }}" class="btn btn-info btn-lg w-100 py-4">
                                <i class="fas fa-search fa-2x d-block mb-2"></i>
                                Cari Pasien
                            </a>
                        </div>
                        @endif

                        @if(in_array($role, ['admin', 'pendaftaran', 'rekam_medis']))
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('laporan.index') }}" class="btn btn-warning btn-lg w-100 py-4">
                                <i class="fas fa-chart-bar fa-2x d-block mb-2"></i>
                                Laporan
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Kunjungan -->
    @if(isset($grafik_kunjungan))
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Statistik Kunjungan (7 Hari Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="kunjunganChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Kunjungan Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Kunjungan Terbaru</h5>
                </div>
                <div class="card-body">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Poli</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent ?? [] as $k)
                            <tr>
                                <td><strong>{{ $k->pasien->no_rm ?? $k->nama ?? '-' }}</strong></td>
                                <td>{{ $k->nama ?? '-' }}</td>
                                <td>{{ $k->poli ?? '-' }}</td>
                                <td>{{ $k->created_at ? $k->created_at->format('H:i') : '-' }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $k->status ?? 'Aktif' }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Belum ada kunjungan hari ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if(isset($grafik_kunjungan))
<script>
    const ctx = document.getElementById('kunjunganChart').getContext('2d');
    const kunjunganChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($grafik_kunjungan['labels']) !!},
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: {!! json_encode($grafik_kunjungan['data']) !!},
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endif

<script>
    // Polling script
    setInterval(function() {
        fetch("{{ route('dashboard.stats') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('val-pasien-baru').innerText = data.pasien_baru;
                document.getElementById('val-kunjungan').innerText = data.kunjungan_hari_ini;
                document.getElementById('val-antrean').innerText = data.antrean_aktif;
            });
    }, 10000);
</script>
@endpush
@endsection
