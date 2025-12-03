@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-gradient mb-1">Pusat Laporan</h2>
        <small class="text-muted">Akses cepat seluruh laporan utama klinik</small>
    </div>
</div>

<div class="row g-4">

    {{-- Laporan Kunjungan --}}
    <div class="col-md-4">
        <a href="{{ route('laporan.kunjungan') }}" class="card modern-card h-100 text-decoration-none">
            <div class="card-body text-center p-5">

                <div class="icon-wrapper bg-primary-soft mb-4">
                    <i class="bi-people-fill fs-1 text-primary"></i>
                </div>

                <h5 class="fw-semibold text-dark mb-2">Laporan Kunjungan</h5>
                <p class="text-muted small mb-3">
                    Rekap jumlah kunjungan pasien harian dan per unit layanan.
                </p>

                <span class="modern-badge primary">Aktif</span>

            </div>
        </a>
    </div>

    {{-- Laporan Morbiditas --}}
    <div class="col-md-4">
        <a href="{{ route('laporan.diagnosa') }}" class="card modern-card h-100 text-decoration-none">
            <div class="card-body text-center p-5">

                <div class="icon-wrapper bg-danger-soft mb-4">
                    <i class="bi-activity fs-1 text-danger"></i>
                </div>

                <h5 class="fw-semibold text-dark mb-2">Laporan Morbiditas</h5>
                <p class="text-muted small mb-3">
                    10 besar penyakit berdasarkan kode ICD-10.
                </p>

                <span class="modern-badge danger">Aktif</span>

            </div>
        </a>
    </div>

    {{-- Laporan Keuangan --}}
    <div class="col-md-4">
        <a href="#" class="card modern-card h-100 text-decoration-none disabled-card">
            <div class="card-body text-center p-5">

                <div class="icon-wrapper bg-warning-soft mb-4">
                    <i class="bi-cash-coin fs-1 text-warning"></i>
                </div>

                <h5 class="fw-semibold text-dark mb-2">Laporan Keuangan</h5>
                <p class="text-muted small mb-3">
                    Rekap pendapatan dan transaksi layanan klinik.
                </p>

                <span class="modern-badge warning">Coming Soon</span>

            </div>
        </a>
    </div>

</div>

<style>
/* ===== Global Look ===== */
.text-gradient {
    background: linear-gradient(135deg, #2563eb, #22c55e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ===== Card Style ===== */
.modern-card {
    border: none;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
}

.modern-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
}

/* ===== Icon Wrapper ===== */
.icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===== Soft Background Colors ===== */
.bg-primary-soft { background: rgba(37, 99, 235, 0.12); }
.bg-danger-soft { background: rgba(239, 68, 68, 0.12); }
.bg-warning-soft { background: rgba(245, 158, 11, 0.15); }

/* ===== Badge ===== */
.modern-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}

.modern-badge.primary {
    color: #2563eb;
    background: rgba(37, 99, 235, 0.12);
}

.modern-badge.danger {
    color: #dc2626;
    background: rgba(239, 68, 68, 0.12);
}

.modern-badge.warning {
    color: #92400e;
    background: rgba(245, 158, 11, 0.18);
}

/* ===== Disabled Card ===== */
.disabled-card {
    filter: grayscale(100%);
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
@endsection
