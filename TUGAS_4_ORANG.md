📋 ATURAN UTAMA
- ✅ HANYA ubah file `.blade.php` (tampilan)
- ❌ JANGAN ubah Controller, Model, Database
- ✅ Copy-paste kode yang ada di bawah
- ✅ Sesuaikan variabel jika perlu (lihat kode lama)

---

🎨 STEP 1: SEMUA ORANG - Setup CSS Dulu

File: `public/css/style.css` (BUAT FILE BARU INI)

```css
/* CUSTOM STYLING - COPY SEMUA */
:root {
  --primary: #3B82F6;
  --success: #10B981;
  --warning: #F59E0B;
  --danger: #EF4444;
}

.stat-card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  border-left: 4px solid var(--primary);
  transition: all 0.3s;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.stat-card.success { border-left-color: var(--success); }
.stat-card.warning { border-left-color: var(--warning); }
.stat-card.danger { border-left-color: var(--danger); }

.stat-value {
  font-size: 2.5rem;
  font-weight: bold;
  margin: 10px 0;
}

.stat-label {
  color: #6B7280;
  font-size: 0.9rem;
}

.btn {
  border-radius: 6px;
  padding: 10px 20px;
  transition: all 0.2s;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.table-modern thead {
  background: linear-gradient(135deg, #3B82F6, #2563EB);
  color: white;
}

.table-modern tbody tr:hover {
  background: #F3F4F6;
}

.badge {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

.card {
  border: none;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-radius: 10px;
}

.card-header {
  background: linear-gradient(135deg, #3B82F6, #2563EB);
  color: white;
  border-radius: 10px 10px 0 0 !important;
  padding: 15px 20px;
}

.form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
```

### Tambahkan di `resources/views/layouts/app.blade.php`

Cari bagian `<head>`, tambahkan:
```html
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
```

---

## 👤 ANGGOTA 1: DASHBOARD

### File yang dikerjakan:
- `resources/views/dashboard.blade.php`

### KODE LENGKAP - COPY PASTE:

```blade
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
                        <div class="stat-label">Total Pasien</div>
                        <div class="stat-value text-primary">{{ $totalPasien ?? 0 }}</div>
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
                        <div class="stat-value text-success">{{ $kunjunganHariIni ?? 0 }}</div>
                    </div>
                    <i class="fas fa-calendar-check fa-3x text-success opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card warning">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-label">Rawat Inap</div>
                        <div class="stat-value text-warning">{{ $rawatInap ?? 0 }}</div>
                    </div>
                    <i class="fas fa-bed fa-3x text-warning opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card danger">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stat-label">Antrian Aktif</div>
                        <div class="stat-value text-danger">{{ $antrianAktif ?? 0 }}</div>
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
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary btn-lg w-100 py-4">
                                <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                                Pendaftaran Pasien
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pemeriksaan.index') }}" class="btn btn-success btn-lg w-100 py-4">
                                <i class="fas fa-stethoscope fa-2x d-block mb-2"></i>
                                Pemeriksaan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pasien.index') }}" class="btn btn-info btn-lg w-100 py-4">
                                <i class="fas fa-search fa-2x d-block mb-2"></i>
                                Cari Pasien
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('laporan.index') }}" class="btn btn-warning btn-lg w-100 py-4">
                                <i class="fas fa-chart-bar fa-2x d-block mb-2"></i>
                                Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            @forelse($kunjunganTerbaru ?? [] as $k)
                            <tr>
                                <td><strong>{{ $k->no_rm ?? '-' }}</strong></td>
                                <td>{{ $k->nama_pasien ?? '-' }}</td>
                                <td>{{ $k->poli ?? '-' }}</td>
                                <td>{{ $k->waktu ?? '-' }}</td>
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
@endsection
```

**SELESAI! - Anggota 1**

---

👤 ANGGOTA 2: DAFTAR PASIEN & PENCARIAN

File yang dikerjakan:
- `resources/views/pasien/data.blade.php`
- `resources/views/pasien/pencarian.blade.php`

FILE 1: `pasien/data.blade.php` - COPY PASTE:

```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Data Pasien</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pasien</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('pasien.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pasien
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('pasien.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari nama, No. RM, atau NIK..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('pasien.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="10%">No. RM</th>
                            <th width="25%">Nama Pasien</th>
                            <th width="15%">NIK</th>
                            <th width="15%">Tanggal Lahir</th>
                            <th width="10%">Jenis Kelamin</th>
                            <th width="15%">Telepon</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien ?? [] as $p)
                        <tr>
                            <td><strong class="text-primary">{{ $p->no_rm }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($p->nama_lengkap ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $p->nama_lengkap }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $p->nik ?? '-' }}</td>
                            <td>{{ $p->tanggal_lahir ? date('d/m/Y', strtotime($p->tanggal_lahir)) : '-' }}</td>
                            <td>
                                @if($p->jenis_kelamin == 'L')
                                <span class="badge bg-info">Laki-laki</span>
                                @else
                                <span class="badge bg-danger">Perempuan</span>
                                @endif
                            </td>
                            <td>{{ $p->telepon ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pasien.show', $p->id) }}" class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pasien.edit', $p->id) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users-slash fa-4x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">Tidak Ada Data Pasien</h5>
                                <p class="text-muted">Silakan tambah pasien baru</p>
                                <a href="{{ route('pasien.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Pasien
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($pasien) && $pasien->hasPages())
            <div class="mt-4">
                {{ $pasien->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
```

. FILE 2: `pasien/pencarian.blade.php` - COPY PASTE:

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-search"></i> Pencarian Pasien</h4>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="{{ route('pasien.pencarian') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>No. Rekam Medis</label>
                                <input type="text" name="no_rm" class="form-control" 
                                       placeholder="Masukkan No. RM" value="{{ request('no_rm') }}">
                            </div>
                            <div class="col-md-6">
                                <label>NIK</label>
                                <input type="text" name="nik" class="form-control" 
                                       placeholder="Masukkan NIK" value="{{ request('nik') }}">
                            </div>
                            <div class="col-md-6">
                                <label>Nama Pasien</label>
                                <input type="text" name="nama" class="form-control" 
                                       placeholder="Masukkan Nama" value="{{ request('nama') }}">
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" 
                                       value="{{ request('tanggal_lahir') }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-search"></i> Cari Pasien
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            @if(isset($hasil))
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Hasil Pencarian ({{ count($hasil) }} pasien)</h5>
                </div>
                <div class="card-body">
                    @forelse($hasil as $p)
                    <div class="card mb-3 border">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-1">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ strtoupper(substr($p->nama_lengkap ?? 'P', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h5 class="mb-1">{{ $p->nama_lengkap }}</h5>
                                    <p class="mb-0 text-muted">
                                        <strong>No. RM:</strong> {{ $p->no_rm }} | 
                                        <strong>NIK:</strong> {{ $p->nik }} | 
                                        <strong>TTL:</strong> {{ $p->tempat_lahir }}, {{ date('d/m/Y', strtotime($p->tanggal_lahir)) }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('pasien.show', $p->id) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('pendaftaran.create', ['pasien_id' => $p->id]) }}" class="btn btn-success">
                                        <i class="fas fa-calendar-plus"></i> Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">Pasien Tidak Ditemukan</h5>
                        <p class="text-muted">Silakan gunakan kriteria pencarian yang berbeda</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
```

**SELESAI! - Anggota 2**

---

 👤 ANGGOTA 3: PENDAFTARAN & ANTRIAN

. File yang dikerjakan:
- `resources/views/pendaftaran/index.blade.php`
- `resources/views/kunjungan/hari-ini.blade.php`

. FILE 1: `pendaftaran/index.blade.php` - COPY PASTE:

```blade
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
                 onclick="window.location='{{ route('pasien.create') }}'">
                <div class="card-body py-5">
                    <i class="fas fa-user-plus fa-5x text-primary mb-3"></i>
                    <h3>Pasien Baru</h3>
                    <p class="text-muted">Daftarkan pasien yang belum pernah berkunjung</p>
                    <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-lg">
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
                            <td>{{ $p->no_rm ?? '-' }}</td>
                            <td>{{ $p->nama_pasien ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $p->poli ?? '-' }}</span>
                            </td>
                            <td>
                                @if($p->jenis_pembayaran == 'BPJS')
                                <span class="badge bg-success">BPJS</span>
                                @else
                                <span class="badge bg-warning text-dark">{{ $p->jenis_pembayaran }}</span>
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
                                <a href="{{ route('pendaftaran.show', $p->id) }}" class="btn btn-sm btn-info">
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
```

FILE 2: `kunjungan/hari-ini.blade.php` - COPY PASTE:

```blade
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
                <div class="stat-value text-primary">{{ $totalKunjungan ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card warning">
                <div class="stat-label">Menunggu</div>
                <div class="stat-value text-warning">{{ $menunggu ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card primary">
                <div class="stat-label">Sedang Diperiksa</div>
                <div class="stat-value text-primary">{{ $sedangDiperiksa ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card success">
                <div class="stat-label">Selesai</div>
                <div class="stat-value text-success">{{ $selesai ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('kunjungan.hari-ini') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <select name="poli" class="form-control">
                            <option value="">Semua Poli</option>
                            @foreach($poliList ?? [] as $poli)
                            <option value="{{ $poli->id }}" {{ request('poli') == $poli->id ? 'selected' : '' }}>
                                {{ $poli->nama }}
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
                            <th>Dokter</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungan ?? [] as $k)
                        <tr>
                            <td><strong class="text-primary fs-4">{{ $k->no_antrian }}</strong></td>
                            <td>{{ $k->no_rm }}</td>
                            <td>{{ $k->nama_pasien }}</td>
                            <td><span class="badge bg-info">{{ $k->poli }}</span></td>
                            <td>{{ $k->dokter ?? '-' }}</td>
                            <td>{{ $k->waktu_daftar ? date('H:i', strtotime($k->waktu_daftar)) : '-' }}</td>
                            <td>
                                @if($k->status == 'menunggu')
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                                @elseif($k->status == 'dipanggil')
                                <span class="badge bg-primary">
                                    <i class="fas fa-bell"></i> Dipanggil
                                </span>
                                @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Selesai
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($k->status == 'menunggu')
                                    <button class="btn btn-primary" onclick="panggilPasien({{ $k->id }})">
                                        <i class="fas fa-bell"></i> Panggil
                                    </button>
                                    @endif
                                    <a href="{{ route('kunjungan.detail', $k->id) }}" class="btn btn-info">
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
function panggilPasien(id) {
    if(confirm('Panggil pasien ini?')) {
        // Implementasi sesuai kebutuhan
    }
}

// Auto refresh setiap 30 detik
setTimeout(function() {
    location.reload();
}, 30000);
</script>
@endpush
@endsection
```

**SELESAI! - Anggota 3**

---

👤 ANGGOTA 4: LOGIN & LAPORAN

File yang dikerjakan:
- `resources/views/auth/login.blade.php`
- `resources/views/laporan/index.blade.php`

FILE 1: `auth/login.blade.php` - COPY PASTE:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .login-header i {
            font-size: 60px;
            margin-bottom: 15px;
        }
        .login-body {
            padding: 40px 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
        }
        .form-control:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }
        .btn-login {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59,130,246,0.3);
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-right: none;
        }
        .form-control-with-icon {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-hospital"></i>
            <h3 class="mb-0">Sistem Klinik</h3>
            <p class="mb-0">Silakan login untuk melanjutkan</p>
        </div>
        <div class="login-body">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Username atau Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user text-muted"></i>
                        </span>
                        <input type="text" name="username" class="form-control form-control-with-icon" 
                               placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control form-control-with-icon" 
                               placeholder="Masukkan password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> LOGIN
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                        Lupa Password?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function togglePassword() {
        const password = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (password.type === 'password') {
            password.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>
```

### FILE 2: `laporan/index.blade.php` - COPY PASTE:

```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2>Laporan Klinik</h2>
        <p class="text-muted">Generate laporan berdasarkan periode</p>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.generate') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="fw-bold">Jenis Laporan</label>
                        <select name="jenis_laporan" class="form-control" required>
                            <option value="">Pilih Jenis</option>
                            <option value="kunjungan">Laporan Kunjungan</option>
                            <option value="pendaftaran">Laporan Pendaftaran</option>
                            <option value="diagnosa">Laporan Diagnosa</option>
                            <option value="pembayaran">Laporan Pembayaran</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-chart-bar"></i> Generate Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Reports -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center" style="border-left: 5px solid #3B82F6;">
                <div class="card-body py-4">
                    <i class="fas fa-calendar-day fa-3x text-primary mb-3"></i>
                    <h5>Laporan Hari Ini</h5>
                    <p class="text-muted">Laporan kunjungan dan pendaftaran hari ini</p>
                    <form action="{{ route('laporan.harian') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-download"></i> Download PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center" style="border-left: 5px solid #10B981;">
                <div class="card-body py-4">
                    <i class="fas fa-calendar-week fa-3x text-success mb-3"></i>
                    <h5>Laporan Mingguan</h5>
                    <p class="text-muted">Laporan 7 hari terakhir</p>
                    <form action="{{ route('laporan.mingguan') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-download"></i> Download PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center" style="border-left: 5px solid #F59E0B;">
                <div class="card-body py-4">
                    <i class="fas fa-calendar-alt fa-3x text-warning mb-3"></i>
                    <h5>Laporan Bulanan</h5>
                    <p class="text-muted">Laporan bulan ini</p>
                    <form action="{{ route('laporan.bulanan') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-download"></i> Download PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    @if(isset($statistik))
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Statistik Laporan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center p-3">
                        <h2 class="text-primary">{{ $statistik['total_kunjungan'] ?? 0 }}</h2>
                        <p class="text-muted mb-0">Total Kunjungan</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3">
                        <h2 class="text-success">{{ $statistik['total_pasien'] ?? 0 }}</h2>
                        <p class="text-muted mb-0">Total Pasien</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3">
                        <h2 class="text-warning">Rp {{ number_format($statistik['total_pendapatan'] ?? 0, 0, ',', '.') }}</h2>
                        <p class="text-muted mb-0">Total Pendapatan</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3">
                        <h2 class="text-info">{{ $statistik['rata_kunjungan'] ?? 0 }}</h2>
                        <p class="text-muted mb-0">Rata-rata/Hari</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
```

**SELESAI! - Anggota 4**

---

✅ CHECKLIST PENGERJAAN

Semua Anggota:
- [ ] Copy file `public/css/style.css`
- [ ] Tambahkan link CSS di `layouts/app.blade.php`

Anggota 1:
- [ ] Copy kode `dashboard.blade.php`
- [ ] Test di browser
- [ ] Screenshot hasil

Anggota 2:
- [ ] Copy kode `pasien/data.blade.php`
- [ ] Copy kode `pasien/pencarian.blade.php`
- [ ] Test di browser
- [ ] Screenshot hasil

Anggota 3:
- [ ] Copy kode `pendaftaran/index.blade.php`
- [ ] Copy kode `kunjungan/hari-ini.blade.php`
- [ ] Test di browser
- [ ] Screenshot hasil

Anggota 4:
- [ ] Copy kode `auth/login.blade.php`
- [ ] Copy kode `laporan/index.blade.php`
- [ ] Test di browser
- [ ] Screenshot hasil

---

🚨 PENTING!

1. **BACKUP dulu** file asli sebelum di-replace
2. **JANGAN ubah** nama variabel (seperti `$totalPasien`, `$kunjungan`, dll)
3. **SESUAIKAN route** jika berbeda (contoh: `route('dashboard')`)
4. **TEST** setelah copy-paste
5. **COMMIT** ke git setelah selesai

---

📞 JIKA ADA ERROR

1. **Error "Undefined variable"**: Variabel belum dikirim dari Controller
   - Solusi: Ganti dengan nilai default, contoh: `{{ $totalPasien ?? 0 }}`

2. **Error "Route not defined"**: Route belum ada
   - Solusi: Ganti dengan `#` atau route yang ada

3. **CSS tidak muncul**: File CSS belum di-link
   - Solusi: Pastikan sudah tambah di `layouts/app.blade.php`

4. **Layout berantakan**: Bootstrap belum ter-load
   - Solusi: Pastikan ada CDN Bootstrap di layout utama

---

**SELESAI! SEMUA KODE TINGGAL COPY PASTE!** 🎉
