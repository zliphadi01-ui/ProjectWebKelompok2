@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pb-5">
    {{-- Hero Section --}}
    <div class="d-flex justify-content-between align-items-end my-4">
        <div>
            <h6 class="text-uppercase text-muted small fw-bold mb-1">Overview</h6>
            <h1 class="h2 fw-bold text-gray-800 mb-0">Dashboard Utama</h1>
        </div>
        <div class="d-none d-md-block text-end">
            <div class="small text-muted mb-1">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</div>
            <a href="{{ route('pendaftaran.create-baru') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi-plus-lg me-2"></i>Pasien Baru
            </a>
        </div>
    </div>

    {{-- Stats Cards Row --}}
    <div class="row g-4 mb-5">
        {{-- Card 1: Kunjungan --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden card-hover">
                <div class="card-body position-relative p-4">
                    <div class="d-flex flex-column position-relative z-1">
                        <div class="text-uppercase fw-bold text-primary small mb-2 tracking-wide">Total Kunjungan</div>
                        <div class="h2 fw-bold text-dark mb-0" id="kunjunganCount">{{ $kunjungan_hari_ini ?? 0 }}</div>
                        <div class="small text-muted mt-2">
                            <i class="bi-arrow-up-short text-success"></i> Hari ini
                        </div>
                    </div>
                    <div class="icon-bg text-primary opacity-10">
                        <i class="bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Pasien Baru --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden card-hover">
                <div class="card-body position-relative p-4">
                    <div class="d-flex flex-column position-relative z-1">
                        <div class="text-uppercase fw-bold text-success small mb-2 tracking-wide">Pasien Baru</div>
                        <div class="h2 fw-bold text-dark mb-0" id="pasienBaruCount">{{ $pasien_baru ?? 0 }}</div>
                        <div class="small text-muted mt-2">
                            <i class="bi-person-plus text-success"></i> Terdaftar hari ini
                        </div>
                    </div>
                    <div class="icon-bg text-success opacity-10">
                        <i class="bi-person-vcard-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Antrean --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden card-hover">
                <div class="card-body position-relative p-4">
                    <div class="d-flex flex-column position-relative z-1">
                        <div class="text-uppercase fw-bold text-info small mb-2 tracking-wide">Antrean Aktif</div>
                        <div class="h2 fw-bold text-dark mb-0" id="antreanCount">{{ $antrean_aktif ?? 0 }}</div>
                        <div class="small text-muted mt-2">
                            <i class="bi-clock-history text-info"></i> Sedang menunggu
                        </div>
                    </div>
                    <div class="icon-bg text-info opacity-10">
                        <i class="bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4: Resep --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden card-hover">
                <div class="card-body position-relative p-4">
                    <div class="d-flex flex-column position-relative z-1">
                        <div class="text-uppercase fw-bold text-warning small mb-2 tracking-wide">Resep Pending</div>
                        <div class="h2 fw-bold text-dark mb-0" id="resepCount">{{ $resep_pending ?? 0 }}</div>
                        <div class="small text-muted mt-2">
                            <i class="bi-exclamation-circle text-warning"></i> Belum diproses
                        </div>
                    </div>
                    <div class="icon-bg text-warning opacity-10">
                        <i class="bi-capsule"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column --}}
        <div class="col-lg-8">
            {{-- Quick Actions Grid --}}
            <div class="mb-4">
                <h5 class="fw-bold text-gray-800 mb-3">Akses Cepat</h5>
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <a href="{{ route('pendaftaran.index') }}" class="card border-0 shadow-sm h-100 card-hover text-decoration-none">
                            <div class="card-body text-center p-4">
                                <div class="avatar-md bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-search fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Cari Pasien</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('pemeriksaan.index') }}" class="card border-0 shadow-sm h-100 card-hover text-decoration-none">
                            <div class="card-body text-center p-4">
                                <div class="avatar-md bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-heart-pulse fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Pemeriksaan</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('gudang') }}" class="card border-0 shadow-sm h-100 card-hover text-decoration-none">
                            <div class="card-body text-center p-4">
                                <div class="avatar-md bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-box-seam fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Stok Obat</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('poli-bpjs') }}" class="card border-0 shadow-sm h-100 card-hover text-decoration-none">
                            <div class="card-body text-center p-4">
                                <div class="avatar-md bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi-hospital fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">Poli BPJS</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Chart Section --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-gray-800 mb-0">Statistik Kunjungan</h5>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-gray-800 mb-0">Antrean Live</h5>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                        <span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>
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
    /* Custom Utilities */
    .tracking-wide { letter-spacing: 0.05em; }
    .text-gray-800 { color: #2d3748; }
    .opacity-10 { opacity: 0.1; }
    .opacity-25 { opacity: 0.25; }
    
    /* Card Hover Effects */
    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }

    /* Icon Background */
    .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 6rem;
        transform: rotate(-15deg);
        z-index: 0;
        pointer-events: none;
    }

    /* List Item Hover */
    .hover-bg-light:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    .transition-all {
        transition: all 0.2s ease;
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
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.2)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kunjungan',
                    data: dataPoints,
                    borderColor: '#4e73df',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4e73df',
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
                        backgroundColor: '#2d3748',
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
                        grid: { borderDash: [4, 4], drawBorder: false, color: "#e3e6f0" },
                        ticks: { padding: 10, color: "#858796", font: { family: "'Nunito', sans-serif" } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { padding: 10, color: "#858796", font: { family: "'Nunito', sans-serif" } }
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
            const timer = setInterval(function() {
                current += increment;
                obj.innerHTML = current;
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        setInterval(updateStats, 10000);
    </script>
@endpush