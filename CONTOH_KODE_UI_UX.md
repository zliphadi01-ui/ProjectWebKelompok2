# 💻 CONTOH KODE UI/UX - PANDUAN IMPLEMENTASI
**Project:** Sistem Informasi Klinik  
**Untuk:** 4 Anggota Kelompok  
**Tanggal:** 3 Desember 2025

---

## 🎯 CARA MENGGUNAKAN DOKUMEN INI

> [!IMPORTANT]
> - Setiap contoh kode di bawah adalah **template yang bisa langsung dipakai**
> - **Copy-paste** kode ini ke file `.blade.php` yang sesuai
> - **Sesuaikan** dengan data yang ada (jangan hapus `@foreach`, `@if`, variabel dari controller)
> - **Jangan ubah** form `action`, `method`, input `name`, atau logic backend

---

## 📦 SETUP AWAL - CSS & JAVASCRIPT

### 1. Custom CSS (Tambahkan di `public/css/custom.css`)

```css
/* ========================================
   CUSTOM CSS UNTUK UI/UX IMPROVEMENT
   ======================================== */

/* Color Variables */
:root {
  --primary: #3B82F6;
  --primary-dark: #2563EB;
  --secondary: #8B5CF6;
  --success: #10B981;
  --warning: #F59E0B;
  --danger: #EF4444;
  --info: #06B6D4;
  
  --bg-light: #F9FAFB;
  --surface: #FFFFFF;
  --text-dark: #111827;
  --text-muted: #6B7280;
  
  --border-radius-sm: 4px;
  --border-radius-md: 8px;
  --border-radius-lg: 12px;
  
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

/* Card Improvements */
.card {
  border: none;
  border-radius: var(--border-radius-md);
  box-shadow: var(--shadow-sm);
  transition: all 0.3s ease;
}

.card:hover {
  box-shadow: var(--shadow-md);
  transform: translateY(-2px);
}

.card-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: white;
  border-radius: var(--border-radius-md) var(--border-radius-md) 0 0;
  padding: 1rem 1.5rem;
  border-bottom: none;
}

.card-header h3, .card-header h4, .card-header h5 {
  margin: 0;
  color: white;
}

/* Statistics Card */
.stat-card {
  background: white;
  border-radius: var(--border-radius-md);
  padding: 1.5rem;
  box-shadow: var(--shadow-sm);
  transition: all 0.3s ease;
  border-left: 4px solid var(--primary);
}

.stat-card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-4px);
}

.stat-card.success {
  border-left-color: var(--success);
}

.stat-card.warning {
  border-left-color: var(--warning);
}

.stat-card.danger {
  border-left-color: var(--danger);
}

.stat-card .stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  margin-bottom: 1rem;
}

.stat-card.primary .stat-icon {
  background: rgba(59, 130, 246, 0.1);
  color: var(--primary);
}

.stat-card.success .stat-icon {
  background: rgba(16, 185, 129, 0.1);
  color: var(--success);
}

.stat-card.warning .stat-icon {
  background: rgba(245, 158, 11, 0.1);
  color: var(--warning);
}

.stat-card.danger .stat-icon {
  background: rgba(239, 68, 68, 0.1);
  color: var(--danger);
}

.stat-card .stat-value {
  font-size: 2rem;
  font-weight: bold;
  color: var(--text-dark);
  margin: 0;
}

.stat-card .stat-label {
  color: var(--text-muted);
  font-size: 0.875rem;
  margin-top: 0.5rem;
}

/* Button Improvements */
.btn {
  border-radius: var(--border-radius-sm);
  padding: 0.5rem 1rem;
  font-weight: 500;
  transition: all 0.2s ease;
  border: none;
}

.btn-primary {
  background: var(--primary);
}

.btn-primary:hover {
  background: var(--primary-dark);
  transform: translateY(-1px);
  box-shadow: var(--shadow-md);
}

.btn-success {
  background: var(--success);
}

.btn-success:hover {
  background: #059669;
}

.btn-danger {
  background: var(--danger);
}

.btn-danger:hover {
  background: #DC2626;
}

.btn-warning {
  background: var(--warning);
}

.btn-warning:hover {
  background: #D97706;
}

.btn-sm {
  padding: 0.25rem 0.75rem;
  font-size: 0.875rem;
}

.btn-lg {
  padding: 0.75rem 1.5rem;
  font-size: 1.125rem;
}

/* Table Improvements */
.table-modern {
  background: white;
  border-radius: var(--border-radius-md);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}

.table-modern thead {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: white;
}

.table-modern thead th {
  border: none;
  padding: 1rem;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0.5px;
}

.table-modern tbody tr {
  transition: all 0.2s ease;
}

.table-modern tbody tr:hover {
  background: var(--bg-light);
  transform: scale(1.01);
}

.table-modern tbody td {
  padding: 1rem;
  vertical-align: middle;
  border-bottom: 1px solid #E5E7EB;
}

/* Form Improvements */
.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 0.5rem;
  display: block;
}

.form-group label .required {
  color: var(--danger);
  margin-left: 2px;
}

.form-control {
  border: 2px solid #E5E7EB;
  border-radius: var(--border-radius-sm);
  padding: 0.75rem;
  transition: all 0.2s ease;
  width: 100%;
}

.form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  outline: none;
}

.form-control.is-invalid {
  border-color: var(--danger);
}

.form-control.is-valid {
  border-color: var(--success);
}

.invalid-feedback {
  color: var(--danger);
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

.valid-feedback {
  color: var(--success);
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

/* Badge Improvements */
.badge {
  padding: 0.375rem 0.75rem;
  border-radius: 9999px;
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.badge-success {
  background: var(--success);
  color: white;
}

.badge-danger {
  background: var(--danger);
  color: white;
}

.badge-warning {
  background: var(--warning);
  color: white;
}

.badge-info {
  background: var(--info);
  color: white;
}

.badge-primary {
  background: var(--primary);
  color: white;
}

/* Alert Improvements */
.alert {
  border-radius: var(--border-radius-md);
  padding: 1rem 1.5rem;
  border: none;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.alert-success {
  background: rgba(16, 185, 129, 0.1);
  color: #065F46;
  border-left: 4px solid var(--success);
}

.alert-danger {
  background: rgba(239, 68, 68, 0.1);
  color: #991B1B;
  border-left: 4px solid var(--danger);
}

.alert-warning {
  background: rgba(245, 158, 11, 0.1);
  color: #92400E;
  border-left: 4px solid var(--warning);
}

.alert-info {
  background: rgba(6, 182, 212, 0.1);
  color: #164E63;
  border-left: 4px solid var(--info);
}

/* Loading Spinner */
.spinner {
  border: 3px solid rgba(0, 0, 0, 0.1);
  border-top-color: var(--primary);
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 3rem 1rem;
}

.empty-state-icon {
  font-size: 4rem;
  color: var(--text-muted);
  margin-bottom: 1rem;
}

.empty-state-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 0.5rem;
}

.empty-state-description {
  color: var(--text-muted);
  margin-bottom: 1.5rem;
}

/* Modal Improvements */
.modal-content {
  border-radius: var(--border-radius-lg);
  border: none;
  box-shadow: var(--shadow-lg);
}

.modal-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: white;
  border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
  border-bottom: none;
}

.modal-header .close {
  color: white;
  opacity: 1;
}

/* Responsive Utilities */
@media (max-width: 768px) {
  .stat-card {
    margin-bottom: 1rem;
  }
  
  .table-modern {
    font-size: 0.875rem;
  }
  
  .btn {
    width: 100%;
    margin-bottom: 0.5rem;
  }
}
```

---

## 👤 ANGGOTA 1: CONTOH KODE DASHBOARD & MASTER DATA

### 1. Dashboard - Statistics Cards

```blade
{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="text-muted">Selamat datang di Sistem Informasi Klinik</p>
        </div>
        <div>
            <span class="text-muted">{{ now()->format('d F Y') }}</span>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        {{-- Total Pasien --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h2 class="stat-value">{{ $totalPasien ?? 0 }}</h2>
                <p class="stat-label">Total Pasien</p>
                <small class="text-success">
                    <i class="fas fa-arrow-up"></i> 12% dari bulan lalu
                </small>
            </div>
        </div>

        {{-- Kunjungan Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h2 class="stat-value">{{ $kunjunganHariIni ?? 0 }}</h2>
                <p class="stat-label">Kunjungan Hari Ini</p>
                <small class="text-muted">
                    <i class="fas fa-clock"></i> Update real-time
                </small>
            </div>
        </div>

        {{-- Pasien Rawat Inap --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-bed"></i>
                </div>
                <h2 class="stat-value">{{ $rawatInap ?? 0 }}</h2>
                <p class="stat-label">Pasien Rawat Inap</p>
                <small class="text-muted">
                    <i class="fas fa-hospital"></i> {{ $kamarTersedia ?? 0 }} kamar tersedia
                </small>
            </div>
        </div>

        {{-- Antrian Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card danger">
                <div class="stat-icon">
                    <i class="fas fa-list-ol"></i>
                </div>
                <h2 class="stat-value">{{ $antrianAktif ?? 0 }}</h2>
                <p class="stat-label">Antrian Aktif</p>
                <small class="text-muted">
                    <i class="fas fa-hourglass-half"></i> Sedang menunggu
                </small>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-user-plus fa-2x mb-2"></i>
                                <br>Pendaftaran Pasien
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('pemeriksaan.index') }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-stethoscope fa-2x mb-2"></i>
                                <br>Pemeriksaan
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('pasien.index') }}" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <br>Cari Pasien
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('laporan.index') }}" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <br>Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts & Recent Activities --}}
    <div class="row">
        {{-- Chart Kunjungan --}}
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i> Grafik Kunjungan 7 Hari Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="kunjunganChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentActivities ?? [] as $activity)
                    <div class="d-flex mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-0 fw-bold">{{ $activity->title ?? 'Aktivitas' }}</p>
                            <small class="text-muted">{{ $activity->description ?? '' }}</small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> {{ $activity->created_at->diffForHumans() ?? '' }}
                            </small>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <p class="text-muted">Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js example
const ctx = document.getElementById('kunjunganChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
            datasets: [{
                label: 'Kunjungan',
                data: {!! json_encode($chartData ?? [12, 19, 15, 25, 22, 18, 20]) !!},
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
                    beginAtZero: true
                }
            }
        }
    });
}
</script>
@endpush
@endsection
```

### 2. Master Data - Template Tabel (Contoh: Pegawai)

```blade
{{-- resources/views/Master/pegawai.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Data Pegawai</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Pegawai</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Tambah Pegawai
            </button>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filter & Search --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('master.pegawai.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari nama, NIP, atau jabatan..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ request('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="unit" class="form-control">
                            <option value="">Semua Unit</option>
                            @foreach($units ?? [] as $unit)
                            <option value="{{ $unit->id }}" {{ request('unit') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">NIP</th>
                            <th width="25%">Nama Lengkap</th>
                            <th width="15%">Jabatan</th>
                            <th width="15%">Unit</th>
                            <th width="10%">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawai ?? [] as $index => $item)
                        <tr>
                            <td>{{ $pegawai->firstItem() + $index }}</td>
                            <td><strong>{{ $item->nip }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                         style="width: 35px; height: 35px; font-size: 14px;">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $item->nama }}</div>
                                        <small class="text-muted">{{ $item->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->unit->nama ?? '-' }}</td>
                            <td>
                                @if($item->status == 'aktif')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> Non-Aktif
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-info" title="Detail" 
                                            onclick="showDetail({{ $item->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary" title="Edit" 
                                            onclick="editData({{ $item->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus" 
                                            onclick="deleteData({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-users-slash"></i>
                                    </div>
                                    <h5 class="empty-state-title">Tidak Ada Data</h5>
                                    <p class="empty-state-description">
                                        Belum ada data pegawai yang tersedia.
                                    </p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                        <i class="fas fa-plus"></i> Tambah Pegawai Pertama
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(isset($pegawai) && $pegawai->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $pegawai->firstItem() }} - {{ $pegawai->lastItem() }} 
                    dari {{ $pegawai->total() }} data
                </div>
                <div>
                    {{ $pegawai->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Add/Edit --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i> Tambah Pegawai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('master.pegawai.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIP <span class="required">*</span></label>
                                <input type="text" name="nip" id="nip" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telepon">Telepon</label>
                                <input type="text" name="telepon" id="telepon" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jabatan">Jabatan <span class="required">*</span></label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit_id">Unit <span class="required">*</span></label>
                                <select name="unit_id" id="unit_id" class="form-control" required>
                                    <option value="">Pilih Unit</option>
                                    @foreach($units ?? [] as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="required">*</span></label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="non-aktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showDetail(id) {
    // Implementasi show detail
    alert('Show detail ID: ' + id);
}

function editData(id) {
    // Implementasi edit
    alert('Edit ID: ' + id);
}

function deleteData(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        // Submit delete form
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection
```

---

## 👤 ANGGOTA 2: CONTOH KODE PASIEN & PENDAFTARAN

### 1. Form Pendaftaran Pasien Baru (Multi-Step)

```blade
{{-- resources/views/pendaftaran/pasien-baru.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Progress Steps --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="step-item active" id="step-indicator-1">
                            <div class="step-number">1</div>
                            <div class="step-label">Data Pribadi</div>
                        </div>
                        <div class="step-item" id="step-indicator-2">
                            <div class="step-number">2</div>
                            <div class="step-label">Alamat & Kontak</div>
                        </div>
                        <div class="step-item" id="step-indicator-3">
                            <div class="step-number">3</div>
                            <div class="step-label">Data Kesehatan</div>
                        </div>
                        <div class="step-item" id="step-indicator-4">
                            <div class="step-number">4</div>
                            <div class="step-label">Konfirmasi</div>
                        </div>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" id="progress-bar" style="width: 25%"></div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('pendaftaran.store') }}" method="POST" id="registrationForm">
                @csrf
                
                {{-- Step 1: Data Pribadi --}}
                <div class="card step-content" id="step-1">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user"></i> Step 1: Data Pribadi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_rm">No. Rekam Medis <span class="required">*</span></label>
                                    <input type="text" name="no_rm" id="no_rm" class="form-control" 
                                           value="{{ $noRMOtomatis ?? '' }}" readonly>
                                    <small class="text-muted">Nomor akan digenerate otomatis</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK <span class="required">*</span></label>
                                    <input type="text" name="nik" id="nik" class="form-control" 
                                           placeholder="16 digit NIK" maxlength="16" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" 
                                           placeholder="Nama sesuai KTP" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-control">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_perkawinan">Status Perkawinan</label>
                                    <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                        <option value="">Pilih Status</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 2: Alamat & Kontak --}}
                <div class="card step-content" id="step-2" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt"></i> Step 2: Alamat & Kontak
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat Lengkap <span class="required">*</span></label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" 
                                              placeholder="Jalan, RT/RW, Kelurahan" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kabupaten">Kabupaten/Kota</label>
                                    <input type="text" name="kabupaten" id="kabupaten" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" name="provinsi" id="provinsi" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_pos">Kode Pos</label>
                                    <input type="text" name="kode_pos" id="kode_pos" class="form-control" maxlength="5">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon">No. Telepon <span class="required">*</span></label>
                                    <input type="tel" name="telepon" id="telepon" class="form-control" 
                                           placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" 
                                           placeholder="email@example.com">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 3: Data Kesehatan --}}
                <div class="card step-content" id="step-3" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-heartbeat"></i> Step 3: Data Kesehatan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="golongan_darah">Golongan Darah</label>
                                    <select name="golongan_darah" id="golongan_darah" class="form-control">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_pembayaran">Jenis Pembayaran <span class="required">*</span></label>
                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" required>
                                        <option value="">Pilih Jenis Pembayaran</option>
                                        <option value="BPJS">BPJS</option>
                                        <option value="Umum">Umum</option>
                                        <option value="Asuransi">Asuransi Lain</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="bpjs-field" style="display: none;">
                                <div class="form-group">
                                    <label for="no_bpjs">No. BPJS</label>
                                    <input type="text" name="no_bpjs" id="no_bpjs" class="form-control" 
                                           placeholder="Nomor kartu BPJS">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alergi">Alergi Obat/Makanan</label>
                                    <textarea name="alergi" id="alergi" class="form-control" rows="2" 
                                              placeholder="Sebutkan jika ada alergi"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="riwayat_penyakit">Riwayat Penyakit</label>
                                    <textarea name="riwayat_penyakit" id="riwayat_penyakit" class="form-control" rows="2" 
                                              placeholder="Riwayat penyakit yang pernah diderita"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(4)">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 4: Konfirmasi --}}
                <div class="card step-content" id="step-4" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-check-circle"></i> Step 4: Konfirmasi Data
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Pastikan semua data yang Anda masukkan sudah benar sebelum menyimpan.
                        </div>
                        
                        <h6 class="fw-bold mb-3">Data Pribadi</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="200">No. Rekam Medis</td>
                                <td>: <span id="confirm-no_rm"></span></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>: <span id="confirm-nik"></span></td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td>: <span id="confirm-nama"></span></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>: <span id="confirm-jk"></span></td>
                            </tr>
                            <tr>
                                <td>TTL</td>
                                <td>: <span id="confirm-ttl"></span></td>
                            </tr>
                        </table>

                        <h6 class="fw-bold mb-3 mt-4">Alamat & Kontak</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="200">Alamat</td>
                                <td>: <span id="confirm-alamat"></span></td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: <span id="confirm-telepon"></span></td>
                            </tr>
                        </table>

                        <h6 class="fw-bold mb-3 mt-4">Data Kesehatan</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="200">Golongan Darah</td>
                                <td>: <span id="confirm-goldar"></span></td>
                            </tr>
                            <tr>
                                <td>Jenis Pembayaran</td>
                                <td>: <span id="confirm-pembayaran"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(3)">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Simpan Data Pasien
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.step-item {
    text-align: center;
    flex: 1;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #E5E7EB;
    color: #6B7280;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    font-weight: bold;
    transition: all 0.3s ease;
}

.step-item.active .step-number {
    background: var(--primary);
    color: white;
}

.step-item.completed .step-number {
    background: var(--success);
    color: white;
}

.step-label {
    font-size: 0.875rem;
    color: #6B7280;
}

.step-item.active .step-label {
    color: var(--primary);
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
// Multi-step form navigation
function nextStep(step) {
    // Hide all steps
    document.querySelectorAll('.step-content').forEach(el => el.style.display = 'none');
    
    // Show target step
    document.getElementById('step-' + step).style.display = 'block';
    
    // Update progress
    updateProgress(step);
    
    // Update confirmation if going to step 4
    if (step === 4) {
        updateConfirmation();
    }
}

function prevStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.style.display = 'none');
    document.getElementById('step-' + step).style.display = 'block';
    updateProgress(step);
}

function updateProgress(step) {
    const progress = (step / 4) * 100;
    document.getElementById('progress-bar').style.width = progress + '%';
    
    // Update step indicators
    for (let i = 1; i <= 4; i++) {
        const indicator = document.getElementById('step-indicator-' + i);
        indicator.classList.remove('active', 'completed');
        
        if (i < step) {
            indicator.classList.add('completed');
        } else if (i === step) {
            indicator.classList.add('active');
        }
    }
}

function updateConfirmation() {
    document.getElementById('confirm-no_rm').textContent = document.getElementById('no_rm').value;
    document.getElementById('confirm-nik').textContent = document.getElementById('nik').value;
    document.getElementById('confirm-nama').textContent = document.getElementById('nama_lengkap').value;
    document.getElementById('confirm-jk').textContent = document.getElementById('jenis_kelamin').options[document.getElementById('jenis_kelamin').selectedIndex].text;
    document.getElementById('confirm-ttl').textContent = document.getElementById('tempat_lahir').value + ', ' + document.getElementById('tanggal_lahir').value;
    document.getElementById('confirm-alamat').textContent = document.getElementById('alamat').value;
    document.getElementById('confirm-telepon').textContent = document.getElementById('telepon').value;
    document.getElementById('confirm-goldar').textContent = document.getElementById('golongan_darah').value || '-';
    document.getElementById('confirm-pembayaran').textContent = document.getElementById('jenis_pembayaran').options[document.getElementById('jenis_pembayaran').selectedIndex].text;
}

// Show BPJS field if selected
document.getElementById('jenis_pembayaran').addEventListener('change', function() {
    const bpjsField = document.getElementById('bpjs-field');
    if (this.value === 'BPJS') {
        bpjsField.style.display = 'block';
    } else {
        bpjsField.style.display = 'none';
    }
});
</script>
@endpush
@endsection
```

---

Dokumen ini sudah **terlalu panjang**. Saya akan lanjutkan dengan membuat file terpisah untuk **Anggota 3 dan 4**. 

Apakah Anda ingin saya:
1. **Lanjutkan** membuat contoh kode untuk Anggota 3 & 4 di file terpisah?
2. Atau **cukup** dengan contoh ini dulu, dan nanti request lagi untuk anggota lainnya?

Beri tahu saya! 😊
