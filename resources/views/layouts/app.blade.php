<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RME - RS Polije</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --ui-bg: #0b1a2b; /* dark sidebar */
            --primary: #0bb3a8; /* teal/tosca */
            --primary-600: #089b8f;
            --muted: #6c757d;
            --card-bg: #ffffff;
            --card-shadow: 0 8px 24px rgba(11,179,168,0.08);
            --glass: rgba(255,255,255,0.6);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffffff;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,.8);
            font-weight: 500;
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        .sidebar-nav .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .sidebar-nav .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }
        .sidebar .nav-heading {
            font-size: .75rem;
            text-transform: uppercase;
            color: rgba(255,255,255,.4);
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .nav-link-sm {
            font-size: 0.875rem;
            padding: 0.5rem 1rem !important;
        }
        .nav-link .bi-chevron-down {
            transition: transform 0.2s;
        }
        .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }
        .collapse .nav {
            background-color: rgba(0,0,0,0.1);
            border-radius: 0.375rem;
            padding: 0.5rem 0;
            margin-top: 0.25rem;
        }
        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
        }
        .topbar {
            height: 56px;
        }
        body.sidebar-toggled .sidebar {
            margin-left: -280px;
        }
        body.sidebar-toggled .main-content {
            margin-left: 0;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -280px;
            }
            .main-content {
                margin-left: 0;
            }
            body.sidebar-toggled .sidebar {
                margin-left: 0;
            }
        }

        /* Dashboard stat-card styling and animations */
        .stat-card{
            background: var(--card-bg);
            border: 0;
            border-radius: .75rem;
            padding: 1rem .85rem;
            box-shadow: var(--card-shadow);
            transform: translateY(6px);
            opacity: 0;
            transition: transform .22s ease, box-shadow .22s ease, opacity .22s ease;
            will-change: transform, opacity;
        }
        /* staggered fade-in for cards inside #statsRow */
        #statsRow .col-xl-3:nth-child(1) .stat-card{ animation: fadeUp .45s ease .05s forwards; }
        #statsRow .col-xl-3:nth-child(2) .stat-card{ animation: fadeUp .45s ease .12s forwards; }
        #statsRow .col-xl-3:nth-child(3) .stat-card{ animation: fadeUp .45s ease .18s forwards; }
        #statsRow .col-xl-3:nth-child(4) .stat-card{ animation: fadeUp .45s ease .25s forwards; }

        @keyframes fadeUp{
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card:hover{ transform: translateY(-8px); box-shadow: 0 18px 50px rgba(11,179,168,0.12); }

        /* --- CSS TAMBAHAN UNTUK PROFIL (FIX) --- */
        .avatar-profile {
            width: 40px;        /* Ukuran fix */
            height: 40px;       /* Ukuran fix */
            object-fit: cover;  /* Agar gambar tidak gepeng */
            border-radius: 50%; /* Bulat sempurna */
            flex-shrink: 0;     /* Agar tidak tergencet */
            border: 2px solid rgba(255,255,255,0.2);
            background-color: #fff;
        }
        
        /* Mempercantik Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 8px;
            margin-top: 10px !important; /* Jarak dari tombol */
            background-color: #fff !important; /* Pastikan putih bersih */
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 500;
            color: #4b5563; /* Abu tua */
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #eff6ff !important; /* Biru muda soft */
            color: #0d6efd !important; /* Biru */
            transform: translateX(5px); /* Efek geser */
        }
        
        /* Icon di dalam dropdown */
        .dropdown-item i {
            margin-right: 10px;
            color: #9ca3af;
            transition: color 0.2s;
        }
        .dropdown-item:hover i {
            color: #0d6efd;
        }
        
        /* Hapus panah dropdown default yg kadang mengganggu */
        .dropdown-toggle::after {
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="sidebar bg-dark d-flex flex-column p-3">
        <a href="{{ url('/dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="bi-hospital-fill fs-4 me-2"></i>
            <span class="fs-4">RME POLIJE</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto sidebar-nav">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi-grid-fill me-2"></i> Beranda
                </a>
            </li>

            {{-- Pendaftaran Dropdown --}}
            <li class="nav-item">
                <a href="#pendaftaranMenu" class="nav-link d-flex justify-content-between align-items-center {{ request()->is('pendaftaran*') ? 'active' : '' }}"
                data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('pendaftaran*') ? 'true' : 'false' }}">
                    <span><i class="bi-clipboard-plus me-2"></i> Pendaftaran</span>
                    <i class="bi-chevron-down"></i>
                </a>

                <div class="collapse {{ request()->is('pendaftaran*') ? 'show' : '' }}" id="pendaftaranMenu">
                    <ul class="nav flex-column ms-3">
                        
                        {{-- 1. MENU UTAMA (MENGGANTIKAN PASIEN BARU & LAMA) --}}
                        <li>
                            <a href="{{ route('pendaftaran.index') }}" class="nav-link nav-link-sm {{ request()->routeIs('pendaftaran.index') || request()->routeIs('pendaftaran.create-baru') ? 'active' : '' }}">
                                <i class="bi-pencil-square me-1"></i> Buat Pendaftaran
                            </a>
                        </li>

                        {{-- 2. MENU MONITORING --}}
                        <li>
                            <a href="{{ route('pendaftaran.list') }}" class="nav-link nav-link-sm {{ request()->routeIs('pendaftaran.list') ? 'active' : '' }}">
                                <i class="bi-list-ul me-1"></i> Data Kunjungan
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </li>

            {{-- Pasien Dropdown --}}
            <li class="nav-item">
                <a href="#pasienMenu" class="nav-link d-flex justify-content-between align-items-center {{ request()->is('pasien*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('pasien*') ? 'true' : 'false' }}">
                    <span><i class="bi-people-fill me-2"></i> Pasien</span>
                    <i class="bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('pasien*') ? 'show' : '' }}" id="pasienMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ url('/pasien/pencarian') }}" class="nav-link nav-link-sm {{ request()->is('pasien/pencarian*') ? 'active' : '' }}">Pencarian Kartu</a></li>
                        <li><a href="{{ url('/pasien/cetak') }}" class="nav-link nav-link-sm {{ request()->is('pasien/cetak*') ? 'active' : '' }}">Cetak Kartu</a></li>
                        <li><a href="{{ url('/pasien/data') }}" class="nav-link nav-link-sm {{ request()->is('pasien/data*') ? 'active' : '' }}">Telusuri Pasien</a></li>
                        <li><a href="{{ url('/pasien/kontrol') }}" class="nav-link nav-link-sm {{ request()->is('pasien/kontrol*') ? 'active' : '' }}">Data Pasien Kontrol</a></li>
                        <li><a href="{{ url('/pasien/master') }}" class="nav-link nav-link-sm {{ request()->is('pasien/master*') ? 'active' : '' }}">Master Pasien</a></li>
                        <li><a href="{{ url('/pasien/verifikasi') }}" class="nav-link nav-link-sm {{ request()->is('pasien/verifikasi*') ? 'active' : '' }}">Verifikasi Pasien</a></li>
                    </ul>
                </div>
            </li>

            {{-- BPJS Dropdown --}}
            <li class="nav-item">
                <a href="#bpjsMenu" class="nav-link d-flex justify-content-between align-items-center {{ request()->is('bpjs*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('bpjs*') ? 'true' : 'false' }}">
                    <span><i class="bi-card-checklist me-2"></i> BPJS</span>
                    <i class="bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('bpjs*') ? 'show' : '' }}" id="bpjsMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ url('/poli-bpjs') }}" class="nav-link nav-link-sm {{ request()->is('poli-bpjs*') ? 'active' : '' }}">Poli BPJS</a></li>
                        <li><a href="{{ url('/riwayat-peserta-bpjs') }}" class="nav-link nav-link-sm {{ request()->is('riwayat-peserta-bpjs*') ? 'active' : '' }}">Riwayat Peserta BPJS</a></li>
                        <li><a href="{{ url('/cetak-rujukan-bpjs') }}" class="nav-link nav-link-sm {{ request()->is('cetak-rujukan-bpjs*') ? 'active' : '' }}">Cetak Rujukan BPJS</a></li>
                    </ul>
                </div>
            </li>

            {{-- Poliklinik Dropdown --}}
            @php
                $isPemeriksaan = request()->routeIs('pemeriksaan.*') || request()->is('pemeriksaan*');
                $isPoli = (request()->is('poli*') || request()->is('kunjungan*')) && !$isPemeriksaan;
            @endphp
            <li class="nav-item">
                <a href="#poliMenu" class="nav-link d-flex justify-content-between align-items-center {{ $isPoli ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isPoli ? 'true' : 'false' }}">
                    <span><i class="bi-hospital me-2"></i> Poliklinik</span>
                    <i class="bi-chevron-down"></i>
                </a>
                <div class="collapse {{ $isPoli ? 'show' : '' }}" id="poliMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ url('/poli/klinik-umum') }}" class="nav-link nav-link-sm {{ request()->is('poli/klinik-umum*') ? 'active' : '' }}">Klinik Umum</a></li>
                        <li><a href="{{ url('/poli/ugd') }}" class="nav-link nav-link-sm {{ request()->is('poli/ugd*') ? 'active' : '' }}">UGD</a></li>
                        <li><a href="{{ url('/poli/klinik-gigi') }}" class="nav-link nav-link-sm {{ request()->is('poli/klinik-gigi*') ? 'active' : '' }}">Klinik Gigi</a></li>
                        <li><a href="{{ url('/poli/rawat-inap') }}" class="nav-link nav-link-sm {{ request()->is('poli/rawat-inap*') ? 'active' : '' }}">Rawat Inap</a></li>
                    </ul>
                </div>
            </li>

            {{-- Pemeriksaan (direct link) --}}
            <li class="nav-item">
                <a href="{{ route('pemeriksaan.index') }}" class="nav-link {{ $isPemeriksaan ? 'active' : '' }}">
                    <i class="bi-file-medical me-2"></i> Pemeriksaan
                </a>
            </li>

            {{-- Gudang Obat Dropdown --}}
            <li class="nav-item">
                <a href="#gudangMenu" class="nav-link d-flex justify-content-between align-items-center {{ request()->is('gudang*') || request()->is('apotek*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('gudang*') || request()->is('apotek*') ? 'true' : 'false' }}">
                    <span><i class="bi-box-seam me-2"></i> Gudang Obat</span>
                    <i class="bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('gudang*') || request()->is('apotek*') ? 'show' : '' }}" id="gudangMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ url('/apotek') }}" class="nav-link nav-link-sm {{ request()->is('apotek*') ? 'active' : '' }}">Apotek</a></li>
                        <li><a href="{{ url('/apotek-retail') }}" class="nav-link nav-link-sm {{ request()->is('apotek-retail*') ? 'active' : '' }}">Apotek Retail</a></li>
                        <li><a href="{{ url('/master-obat') }}" class="nav-link nav-link-sm {{ request()->is('master-obat*') ? 'active' : '' }}">Master Obat</a></li>
                        <li><a href="{{ url('/farmasi') }}" class="nav-link nav-link-sm {{ request()->is('farmasi*') ? 'active' : '' }}">Farmasi</a></li>
                    </ul>
                </div>
            </li>

            {{-- Kasir --}}
            <li class="nav-item">
                <a href="{{ url('/kasir') }}" class="nav-link {{ request()->is('kasir*') ? 'active' : '' }}">
                    <i class="bi-cash-coin me-2"></i> Kasir
                </a>
            </li>

            {{-- Master Data --}}
            @php $isMaster = request()->is('master-data*'); @endphp
            <li class="nav-item">
                <a href="#masterDataMenu" class="nav-link d-flex justify-content-between align-items-center {{ $isMaster ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isMaster ? 'true' : 'false' }}">
                    <span><i class="bi-database-fill me-2"></i> Master Data</span>
                    <i class="bi-chevron-down"></i>
                </a>
                <div class="collapse {{ $isMaster ? 'show' : '' }}" id="masterDataMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('master-data.keadaan-akhir') }}" class="nav-link nav-link-sm {{ request()->is('master-data/keadaan-akhir*') ? 'active' : '' }}">Keadaan Akhir</a></li>
                        <li><a href="{{ route('master-data.menu') }}" class="nav-link nav-link-sm {{ request()->is('master-data/menu*') ? 'active' : '' }}">Menu</a></li>
                        <li><a href="{{ route('master-data.mitra') }}" class="nav-link nav-link-sm {{ request()->is('master-data/mitra*') ? 'active' : '' }}">Mitra</a></li>
                        <li><a href="{{ route('master-data.hak-akses') }}" class="nav-link nav-link-sm {{ request()->is('master-data/hak-akses*') ? 'active' : '' }}">Hak Akses</a></li>
                        <li><a href="{{ route('master-data.aktivasi-poli') }}" class="nav-link nav-link-sm {{ request()->is('master-data/aktivasi-poli*') ? 'active' : '' }}">Aktivasi Poli</a></li>
                        <li><a href="{{ route('master-data.pegawai') }}" class="nav-link nav-link-sm {{ request()->is('master-data/pegawai*') ? 'active' : '' }}">Pegawai</a></li>
                        <li><a href="{{ route('master-data.jadwal-poli') }}" class="nav-link nav-link-sm {{ request()->is('master-data/jadwal-poli*') ? 'active' : '' }}">Jadwal Poli</a></li>
                        <li><a href="{{ route('master-data.tindakan-laborat') }}" class="nav-link nav-link-sm {{ request()->is('master-data/tindakan-laborat*') ? 'active' : '' }}">Tindakan &amp; Laborat</a></li>
                        <li><a href="{{ route('master-data.diagnosa') }}" class="nav-link nav-link-sm {{ request()->is('master-data/diagnosa*') ? 'active' : '' }}">Diagnosa</a></li>
                        <li><a href="{{ route('master-data.kamar-rawat-inap') }}" class="nav-link nav-link-sm {{ request()->is('master-data/kamar-rawat-inap*') ? 'active' : '' }}">Kamar Rawat Inap</a></li>
                        <li><a href="{{ route('master-data.unit') }}" class="nav-link nav-link-sm {{ request()->is('master-data/unit*') ? 'active' : '' }}">Unit</a></li>
                        <li><a href="{{ route('master-data.vendor') }}" class="nav-link nav-link-sm {{ request()->is('master-data/vendor*') ? 'active' : '' }}">Vendor</a></li>
                        <li><a href="{{ route('master-data.kategori-diagnosa') }}" class="nav-link nav-link-sm {{ request()->is('master-data/kategori-diagnosa*') ? 'active' : '' }}">Kategori Diagnosa</a></li>
                        <li><a href="{{ route('master-data.jenis-pembayaran') }}" class="nav-link nav-link-sm {{ request()->is('master-data/jenis-pembayaran*') ? 'active' : '' }}">Jenis Pembayaran</a></li>
                        <li><a href="{{ route('master-data.profesi') }}" class="nav-link nav-link-sm {{ request()->is('master-data/profesi*') ? 'active' : '' }}">Profesi</a></li>
                        <li><a href="{{ route('master-data.resep-info') }}" class="nav-link nav-link-sm {{ request()->is('master-data/resep-info*') ? 'active' : '' }}">Resep Info</a></li>
                        <li><a href="{{ route('master-data.rs-rujukan') }}" class="nav-link nav-link-sm {{ request()->is('master-data/rs-rujukan*') ? 'active' : '' }}">RS Rujukan</a></li>
                    </ul>
                </div>
            </li>

            {{-- Laporan Dropdown --}}
            <li class="nav-item">
                <a href="#laporanMenu" class="nav-link d-flex justify-content-between align-items-center {{ request()->is('laporan*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}">
                    <span><i class="bi-file-earmark-text me-2"></i> Laporan</span>
                    <i class="bi-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('laporan*') ? 'show' : '' }}" id="laporanMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ url('/laporan/obat') }}" class="nav-link nav-link-sm {{ request()->is('laporan/obat*') ? 'active' : '' }}">Laporan Obat</a></li>
                        <li><a href="{{ url('/laporan/mitra') }}" class="nav-link nav-link-sm {{ request()->is('laporan/mitra*') ? 'active' : '' }}">Laporan Mitra</a></li>
                        <li><a href="{{ url('/laporan/loket') }}" class="nav-link nav-link-sm {{ request()->is('laporan/loket*') ? 'active' : '' }}">Laporan Loket</a></li>
                        <li><a href="{{ url('/laporan/pembagian') }}" class="nav-link nav-link-sm {{ request()->is('laporan/pembagian*') ? 'active' : '' }}">Laporan Pembagian</a></li>
                    </ul>
                </div>
            </li>

            {{-- Lainnya --}}
            <li class="nav-item"><a href="{{ url('/laboratorium') }}" class="nav-link {{ request()->is('laboratorium*') ? 'active' : '' }}"><i class="bi-microscope me-2"></i> Laboratorium</a></li>
            <li class="nav-item"><a href="{{ url('/rawat-inap') }}" class="nav-link {{ request()->is('rawat-inap*') ? 'active' : '' }}"><i class="bi-house-fill me-2"></i> Rawat Inap</a></li>
            <li class="nav-item"><a href="{{ url('/poned') }}" class="nav-link {{ request()->is('poned*') ? 'active' : '' }}"><i class="bi-activity me-2"></i> PONED</a></li>
            <li class="nav-item"><a href="{{ url('/ubah-password') }}" class="nav-link {{ request()->is('ubah-password*') ? 'active' : '' }}"><i class="bi-key-fill me-2"></i> Ubah Password</a></li>
            <li class="nav-item"><a href="{{ url('/pengaturan') }}" class="nav-link {{ request()->is('pengaturan*') ? 'active' : '' }}"><i class="bi-gear-fill me-2"></i> Pengaturan</a></li>
            <li class="nav-item"><a href="{{ url('/pengaturan-grup') }}" class="nav-link {{ request()->is('pengaturan-grup*') ? 'active' : '' }}"><i class="bi-people-fill me-2"></i> Pengaturan Grup</a></li>
            <li class="nav-item"><a href="{{ url('/bypass') }}" class="nav-link {{ request()->is('bypass*') ? 'active' : '' }}"><i class="bi-toggle-on me-2"></i> Bypass</a></li>
            <li class="nav-item"><a href="{{ url('/whatsapp') }}" class="nav-link {{ request()->is('whatsapp*') ? 'active' : '' }}"><i class="bi-whatsapp me-2"></i> Whatsapp</a></li>
            <li class="nav-item"><a href="{{ url('/billing') }}" class="nav-link {{ request()->is('billing*') ? 'active' : '' }}"><i class="bi-receipt me-2"></i> Billing</a></li>
        </ul>
        <hr>

        {{-- PROFILE SIDEBAR (FIXED) --}}
        <div class="dropdown mt-auto">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ 
                    (Auth::check() && Auth::user()->profile_photo_url) ? Auth::user()->profile_photo_url : 
                    (Auth::check() && isset(Auth::user()->avatar) ? asset('storage/' . Auth::user()->avatar) : (session('user_photo') ?? 'https://images.pexels.com/photos/771742/pexels-photo-771742.jpeg'))
                }}" alt="" class="avatar-profile me-2">
                <strong class="text-truncate" style="max-width: 130px;">{{ Auth::check() ? Auth::user()->name : (session('user') ?? 'Petugas') }}</strong>
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="bi-person-fill"></i> Profil Saya</a></li>
                <li><a class="dropdown-item" href="{{ url('/pengaturan') }}"><i class="bi-gear-fill"></i> Pengaturan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}"><i class="bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">
            <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="bi-list fs-4"></i>
            </button>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">{{ Auth::check() ? Auth::user()->name : (session('user') ?? 'Petugas') }}</span>
                        {{-- PROFILE TOPBAR (FIXED) --}}
                        <img class="avatar-profile" src="{{ 
                            (Auth::check() && Auth::user()->profile_photo_url) ? Auth::user()->profile_photo_url : 
                            (Auth::check() && isset(Auth::user()->avatar) ? asset('storage/' . Auth::user()->avatar) : 'https://images.pexels.com/photos/771742/pexels-photo-771742.jpeg')
                        }}">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow">
                        <a class="dropdown-item" href="{{ url('/profile') }}">
                            <i class="bi-person-fill me-2"></i> Profil Saya
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ url('/logout') }}">
                            <i class="bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <main class="container-fluid px-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sidebar-toggled');
            });
        }
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    document.body.classList.remove('sidebar-toggled');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>