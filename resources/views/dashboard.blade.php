@extends('layouts.app')

@section('content')
    {{-- Judul Halaman --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Sistem RME</h1>
        <div class="d-none d-sm-inline-block">
            <span class="fw-bold">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</span>
        </div>
    </div>

    {{-- Baris Kartu Statistik (Stats Cards Row) --}}
    <div class="row" id="statsRow">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="stat-link text-decoration-none" data-type="kunjungan">
            <div class="card stat-card border-start-primary h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Kunjungan Hari Ini</div>
                            <div class="h5 mb-0 fw-bold text-gray-800" id="kunjunganCount">{{ $kunjungan_hari_ini ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="bi-calendar-day-fill fs-2 text-muted"></i></div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="stat-link text-decoration-none" data-type="pasien-baru">
            <div class="card stat-card border-start-success h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Pasien Baru (Hari Ini)</div>
                            <div class="h5 mb-0 fw-bold text-gray-800" id="pasienBaruCount">{{ $pasien_baru ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="bi-person-plus-fill fs-2 text-muted"></i></div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="stat-link text-decoration-none" data-type="antrean">
            <div class="card stat-card border-start-info h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Antrean Aktif</div>
                            <div class="h5 mb-0 fw-bold text-gray-800" id="antreanCount">{{ $antrean_aktif ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="bi-hourglass-split fs-2 text-muted"></i></div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="stat-link text-decoration-none" data-type="resep">
            <div class="card stat-card border-start-warning h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Resep Belum Diproses</div>
                            <div class="h5 mb-0 fw-bold text-gray-800" id="resepCount">{{ $resep_pending ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="bi-capsule fs-2 text-muted"></i></div>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>

    {{-- Tabel Antrean Pasien --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">Antrean Pasien Hari Ini</h6>
            <div>
                <button id="refreshStats" class="btn btn-sm btn-outline-primary">Refresh</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    <canvas id="kunjunganChart" height="120"></canvas>
                </div>
                <div class="col-lg-4">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr><th>No. RM</th><th>Nama</th><th>Poli</th></tr>
                            </thead>
                            <tbody>
                                @forelse($recent as $r)
                                    <tr>
                                        <td>{{ $r->no_daftar ?? '-' }}</td>
                                        <td>{{ $r->nama }}</td>
                                        <td>{{ $r->poli ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3">Tidak ada data terbaru.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Pusher + Echo (optional, will work if BROADCAST_DRIVER is configured; for local dev use laravel-websockets) -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.4/dist/echo.iife.js"></script>
    <script>
        const labels = @json($grafik_kunjungan['labels']);
        const dataPoints = @json($grafik_kunjungan['data']);

        const ctx = document.getElementById('kunjunganChart').getContext('2d');
        const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary')?.trim() || '#0d6efd';
        const kunjunganChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kunjungan',
                    data: dataPoints,
                    borderColor: primaryColor,
                    backgroundColor: (function(ctx){
                        const gradient = ctx.createLinearGradient(0,0,0,200);
                        gradient.addColorStop(0, 'rgba(11,179,168,0.18)');
                        gradient.addColorStop(1, 'rgba(11,179,168,0.03)');
                        return gradient;
                    })(ctx),
                    tension: 0.35,
                    pointRadius: 3,
                    pointBackgroundColor: 'white',
                    pointBorderWidth: 2,
                    pointBorderColor: 'var(--primary, #0d6efd)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 900, easing: 'easeOutQuart' },
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } },
                elements: { line: { borderWidth: 3 } }
            }
        });

        document.getElementById('refreshStats').addEventListener('click', () => {
            fetch('{{ route('dashboard.stats') }}')
                .then(r => r.json())
                .then(json => {
                    document.getElementById('kunjunganCount').textContent = json.kunjungan_hari_ini;
                    document.getElementById('pasienBaruCount').textContent = json.pasien_baru;
                    document.getElementById('antreanCount').textContent = json.antrean_aktif;
                })
                .catch(err => console.error(err));
        });

        // Polling: update counts every 10 seconds
        setInterval(() => {
            fetch('{{ route('dashboard.stats') }}')
                .then(r => r.json())
                .then(json => {
                    document.getElementById('kunjunganCount').textContent = json.kunjungan_hari_ini;
                    document.getElementById('pasienBaruCount').textContent = json.pasien_baru;
                    document.getElementById('antreanCount').textContent = json.antrean_aktif;
                }).catch(() => {});
        }, 10000);

        // Real-time via Laravel Echo (Pusher). This will connect if broadcasting is configured.
        try {
            // Read push config from meta or fallback values
            const PUSHER_KEY = '{{ env('PUSHER_APP_KEY', 'local') }}';
            const PUSHER_CLUSTER = '{{ env('PUSHER_APP_CLUSTER', 'mt1') }}';

            if (PUSHER_KEY && (typeof Pusher !== 'undefined')) {
                Pusher.logToConsole = false;
                const echo = new window.Echo({
                    broadcaster: 'pusher',
                    key: PUSHER_KEY,
                    cluster: PUSHER_CLUSTER,
                    wsHost: window.location.hostname,
                    wsPort: {{ env('LARAVEL_WEBSOCKETS_PORT', 6001) }},
                    forceTLS: false,
                    enabledTransports: ['ws','wss']
                });

                echo.channel('dashboard').listen('.App\\Events\\DashboardStatsUpdated', (e) => {
                    if (e.kunjungan_hari_ini !== undefined) document.getElementById('kunjunganCount').textContent = e.kunjungan_hari_ini;
                    if (e.pasien_baru !== undefined) document.getElementById('pasienBaruCount').textContent = e.pasien_baru;
                    if (e.antrean_aktif !== undefined) document.getElementById('antreanCount').textContent = e.antrean_aktif;
                });
            }
        } catch (err) {
            // fail silently if Echo not configured
            console.warn('Echo not initialized', err);
        }

        // Modal to show details when clicking card
        function createModal() {
            let modal = document.getElementById('cardDetailModal');
            if (modal) return modal;
            modal = document.createElement('div');
            modal.id = 'cardDetailModal';
            modal.className = 'modal fade';
            modal.tabIndex = -1;
            modal.innerHTML = `
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body py-3">Loading...</div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            return modal;
        }

        document.querySelectorAll('.stat-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const type = this.dataset.type;
                const modalEl = createModal();
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
                modalEl.querySelector('.modal-body').innerHTML = '<div class="text-center py-5">Memuat...</div>';
                fetch(`${location.origin}/dashboard/details/${type}`)
                    .then(r => r.json())
                    .then(json => {
                        modalEl.querySelector('.modal-body').innerHTML = json.html || '<div class="text-muted">Tidak ada data.</div>';
                    })
                    .catch(err => { modalEl.querySelector('.modal-body').innerHTML = '<div class="text-danger">Gagal memuat data.</div>'; console.error(err); });
            });
        });
    </script>
@endpush