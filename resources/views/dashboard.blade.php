@extends('layouts.app')

@section('content')
<div class="pb-5">
    {{-- Hero Section --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-4">
        <div>
            <h6 class="text-uppercase text-muted small fw-bold mb-1">Overview</h6>
            <h1 class="h2 fw-bold text-dark mb-0">Dashboard Utama</h1>
        </div>
        <div class="d-none d-md-block text-end mt-3 mt-md-0">
            <div class="small text-muted mb-2">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</div>
            @if(in_array(Auth::user()->role, ['admin', 'pendaftaran']))
            <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi-plus-lg me-2"></i>Pasien Baru
            </a>
            @endif
        </div>
    </div>

    {{-- Stats Cards Row --}}
    <div class="row g-4 mb-5">
        {{-- Card 1: Kunjungan --}}
        <div class="col-xl-3 col-md-6">
            @include('components.stat-card', [
                'title' => 'Total Kunjungan',
                'value' => $kunjungan_hari_ini ?? 0,
                'id' => 'kunjunganCount',
                'icon' => 'people-fill',
                'color' => 'primary',
                'trend' => 'up',
                'trendText' => 'Hari ini'
            ])
        </div>

        {{-- Card 2: Pasien Baru --}}
        @if(in_array(Auth::user()->role, ['admin', 'pendaftaran']))
        <div class="col-xl-3 col-md-6">
            @include('components.stat-card', [
                'title' => 'Pasien Baru',
                'value' => $pasien_baru ?? 0,
                'id' => 'pasienBaruCount',
                'icon' => 'person-vcard-fill',
                'color' => 'success',
                'trend' => 'up',
                'trendText' => 'Terdaftar hari ini'
            ])
        </div>
        @endif

        {{-- Card 3: Antrean Aktif --}}
        <div class="col-xl-3 col-md-6">
            @include('components.stat-card', [
                'title' => 'Antrean Aktif',
                'value' => $antrean_aktif ?? 0,
                'id' => 'antreanCount',
                'icon' => 'hourglass-split',
                'color' => 'info',
                'subtitle' => 'Sedang berlangsung'
            ])
        </div>

        {{-- Card 4: Resep --}}
        @if(in_array(Auth::user()->role, ['admin', 'apotek', 'dokter']))
        <div class="col-xl-3 col-md-6">
            @include('components.stat-card', [
                'title' => 'Resep Pending',
                'value' => $resep_pending ?? 0,
                'id' => 'resepCount',
                'icon' => 'capsule',
                'color' => 'warning',
                'subtitle' => 'Belum diproses'
            ])
        </div>
        @endif
    </div>

    <div class="row g-4">
        {{-- Left Column --}}
        <div class="col-lg-8">
            {{-- Quick Actions Grid --}}
            <div class="mb-4">
                <h5 class="fw-bold text-dark mb-3">Akses Cepat</h5>
                <div class="row g-3">
                    @if(in_array(Auth::user()->role, ['admin', 'pendaftaran', 'dokter']))
                    <div class="col-md-3 col-6">
                        <a href="{{ route('pendaftaran.index') }}" class="card h-100 text-decoration-none hover-scale">
                            <div class="card-body text-center p-4">
                                <div class="avatar bg-primary text-white bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-search fs-4 text-primary"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Cari Pasien</h6>
                            </div>
                        </a>
                    </div>
                    @endif

                    @if(in_array(Auth::user()->role, ['admin', 'dokter']))
                    <div class="col-md-3 col-6">
                        <a href="{{ route('pemeriksaan.index') }}" class="card h-100 text-decoration-none hover-scale">
                            <div class="card-body text-center p-4">
                                <div class="avatar bg-success text-white bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-heart-pulse fs-4 text-success"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Pemeriksaan</h6>
                            </div>
                        </a>
                    </div>
                    @endif

                    @if(in_array(Auth::user()->role, ['admin', 'apotek']))
                    <div class="col-md-3 col-6">
                        <a href="{{ route('gudang') }}" class="card h-100 text-decoration-none hover-scale">
                            <div class="card-body text-center p-4">
                                <div class="avatar bg-warning text-white bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-box-seam fs-4 text-warning"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Stok Obat</h6>
                            </div>
                        </a>
                    </div>
                    @endif

                    @if(in_array(Auth::user()->role, ['admin', 'pendaftaran']))
                    <div class="col-md-3 col-6">
                        <a href="{{ route('poli-bpjs') }}" class="card h-100 text-decoration-none hover-scale">
                            <div class="card-body text-center p-4">
                                <div class="avatar bg-info text-white bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-hospital fs-4 text-info"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Poli BPJS</h6>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Chart Section --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Statistik Kunjungan</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-pill px-3" type="button">
                            7 Hari Terakhir
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-area" style="height: 350px;">
                        <canvas id="kunjunganChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Live Queue --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Antrean Live</h5>
                    <span class="badge bg-danger rounded-pill px-3 py-2 animate-pulse">
                        LIVE
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush px-2">
                        @forelse($recent as $r)
                            <div class="list-group-item border-0 rounded-3 mb-2 p-3 d-flex align-items-center hover-bg-light transition-all">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        {{ substr($r->nama, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <h6 class="mb-1 fw-bold text-dark text-truncate">{{ $r->nama }}</h6>
                                    <div class="d-flex align-items-center text-muted small">
                                        <span class="badge bg-light text-dark border me-2">{{ $r->no_daftar }}</span>
                                        <span class="text-truncate">{{ $r->poli ?? 'Umum' }}</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    @php
                                        $statusClass = match($r->status) {
                                            'Menunggu' => 'bg-warning text-dark',
                                            'Diperiksa' => 'bg-info text-white',
                                            'Selesai' => 'bg-success text-white',
                                            default => 'bg-secondary text-white'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill">{{ $r->status }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi-clipboard-check display-4 text-muted opacity-25"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Tidak ada antrean aktif</h6>
                                <p class="text-muted small mb-0">Semua pasien telah dilayani.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 text-center py-3">
                    <a href="{{ route('pendaftaran.list') }}" class="btn btn-light text-primary fw-bold rounded-pill w-100">
                        Lihat Semua Antrean
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .hover-scale {
        transition: transform 0.2s;
    }
    .hover-scale:hover {
        transform: scale(1.02);
    }
</style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Configuration
        const labels = @json($grafik_kunjungan['labels']);
        const dataPoints = @json($grafik_kunjungan['data']);
        const ctx = document.getElementById('kunjunganChart').getContext('2d');
        
        // Gradient for Chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(11, 107, 203, 0.2)'); // Primary color var
        gradient.addColorStop(1, 'rgba(11, 107, 203, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kunjungan',
                    data: dataPoints,
                    borderColor: '#0b6bcb', // Primary color
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#0b6bcb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#2d3436',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Pasien';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], drawBorder: false, color: "#e2e8f0" },
                        ticks: { padding: 10, color: "#64748b", font: { family: "'Inter', sans-serif" } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { padding: 10, color: "#64748b", font: { family: "'Inter', sans-serif" } }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });

        // Realtime Polling
        function updateStats() {
            fetch('{{ route('dashboard.stats') }}')
                .then(r => r.json())
                .then(data => {
                    // Animate numbers
                    animateValue("kunjunganCount", parseInt(document.getElementById("kunjunganCount").innerText), data.kunjungan_hari_ini, 1000);
                    animateValue("pasienBaruCount", parseInt(document.getElementById("pasienBaruCount").innerText), data.pasien_baru, 1000);
                    animateValue("antreanCount", parseInt(document.getElementById("antreanCount").innerText), data.antrean_aktif, 1000);
                    animateValue("resepCount", parseInt(document.getElementById("resepCount").innerText), data.resep_pending || 0, 1000);
                })
                .catch(console.error);
        }

        function animateValue(id, start, end, duration) {
            if (start === end) return;
            const range = end - start;
            let current = start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            const obj = document.getElementById(id);
            if(obj) {
                const timer = setInterval(function() {
                    current += increment;
                    obj.innerHTML = current;
                    if (current == end) {
                        clearInterval(timer);
                    }
                }, stepTime);
            }
        }

        setInterval(updateStats, 10000);
    </script>
@endpush
