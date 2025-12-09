<nav class="sidebar-wrapper">
    <div class="sidebar-brand">
        <i class="bi-hospital-fill me-2 text-primary"></i>
        <span>RME POLIJE</span>
    </div>

    @php
        $user = Auth::user();
        $role = $user ? $user->role : 'guest';
    @endphp

    <ul class="sidebar-menu">
        {{-- Dashboard --}}
        <li>
            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi-grid-fill"></i> 
                <span>Beranda</span>
            </a>
        </li>

        {{-- Pendaftaran Dropdown (Admin & Pendaftaran) --}}
        @if(in_array($role, ['admin', 'pendaftaran']))
        <li class="nav-heading">LAYANAN UTAMA</li>
        <li>
            <a href="#pendaftaranMenu" class="nav-link {{ request()->is('pendaftaran*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('pendaftaran*') ? 'true' : 'false' }}">
                <i class="bi-clipboard-plus"></i>
                <span>Pendaftaran</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>

            <div class="collapse {{ request()->is('pendaftaran*') ? 'show' : '' }}" id="pendaftaranMenu">
                <a href="{{ route('pendaftaran.index') }}" class="nav-link {{ request()->routeIs('pendaftaran.index') || request()->routeIs('pendaftaran.create-baru') ? 'active' : '' }}">
                    <span>Buat Pendaftaran</span>
                </a>
                <a href="{{ route('pendaftaran.list') }}" class="nav-link {{ request()->routeIs('pendaftaran.list') ? 'active' : '' }}">
                    <span>Data Kunjungan</span>
                </a>
            </div>
        </li>

        <li>
            <a href="#pasienMenu" class="nav-link {{ request()->is('pasien*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('pasien*') ? 'true' : 'false' }}">
                <i class="bi-people-fill"></i>
                <span>Pasien</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ request()->is('pasien*') ? 'show' : '' }}" id="pasienMenu">
                <a href="{{ url('/pasien/pencarian') }}" class="nav-link {{ request()->is('pasien/pencarian*') ? 'active' : '' }}">Pencarian Kartu</a>
                <a href="{{ url('/pasien/cetak') }}" class="nav-link {{ request()->is('pasien/cetak*') ? 'active' : '' }}">Cetak Kartu</a>
                <a href="{{ url('/pasien/data') }}" class="nav-link {{ request()->is('pasien/data*') ? 'active' : '' }}">Telusuri Pasien</a>
                <a href="{{ url('/pasien/kontrol') }}" class="nav-link {{ request()->is('pasien/kontrol*') ? 'active' : '' }}">Data Pasien Kontrol</a>
                <a href="{{ url('/pasien/master') }}" class="nav-link {{ request()->is('pasien/master*') ? 'active' : '' }}">Master Pasien</a>
                <a href="{{ url('/pasien/verifikasi') }}" class="nav-link {{ request()->is('pasien/verifikasi*') ? 'active' : '' }}">Verifikasi Pasien</a>
            </div>
        </li>

        <li>
            @php
                $isBpjs = request()->is('bpjs*') || request()->is('poli-bpjs*') || request()->is('riwayat-peserta-bpjs*') || request()->is('cetak-rujukan-bpjs*');
            @endphp
            <a href="#bpjsMenu" class="nav-link {{ $isBpjs ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isBpjs ? 'true' : 'false' }}">
                <i class="bi-card-checklist"></i>
                <span>BPJS</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ $isBpjs ? 'show' : '' }}" id="bpjsMenu">
                <a href="{{ url('/poli-bpjs') }}" class="nav-link {{ request()->is('poli-bpjs*') ? 'active' : '' }}">BPJS</a>
                <a href="{{ url('/riwayat-peserta-bpjs') }}" class="nav-link {{ request()->is('riwayat-peserta-bpjs*') ? 'active' : '' }}">Riwayat Peserta BPJS</a>
                <a href="{{ url('/cetak-rujukan-bpjs') }}" class="nav-link {{ request()->is('cetak-rujukan-bpjs*') ? 'active' : '' }}">Cetak Rujukan BPJS</a>
            </div>
        </li>
        @endif

        {{-- Poliklinik & Pemeriksaan (Admin & Dokter) --}}
        @if(in_array($role, ['admin', 'dokter']))
        <li class="nav-heading">MEDIS & KLINIS</li>
        @php
            $isPemeriksaan = request()->routeIs('pemeriksaan.*') || request()->is('pemeriksaan*');
            $isPoli = request()->is('poli/*');
        @endphp
        <li>
            <a href="#poliMenu" class="nav-link {{ $isPoli ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isPoli ? 'true' : 'false' }}">
                <i class="bi-hospital"></i>
                <span>Poliklinik</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ $isPoli ? 'show' : '' }}" id="poliMenu">
                @foreach(config('poli.options') as $poliOption)
                <a href="{{ route('poli.show', ['nama_poli' => $poliOption]) }}" class="nav-link {{ request()->is('poli/' . $poliOption) ? 'active' : '' }}">
                    {{ $poliOption }}
                </a>
                @endforeach
            </div>
        </li>

        <li>
            <a href="{{ route('kunjungan.hari-ini') }}" class="nav-link {{ request()->routeIs('kunjungan.hari-ini') ? 'active' : '' }}">
                <i class="bi-speedometer2"></i>
                <span>Kunjungan Poliklinik</span>
            </a>
        </li>

        <li>
            <a href="{{ route('pemeriksaan.index') }}" class="nav-link {{ $isPemeriksaan ? 'active' : '' }}">
                <i class="bi-file-medical"></i>
                <span>Pemeriksaan</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/laboratorium') }}" class="nav-link {{ request()->is('laboratorium*') ? 'active' : '' }}">
                <i class="bi-microscope"></i>
                <span>Laboratorium</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/poned') }}" class="nav-link {{ request()->is('poned*') ? 'active' : '' }}">
                <i class="bi-activity"></i>
                <span>PONED</span>
            </a>
        </li>
        @endif

        {{-- Unit Layanan (Rawat Inap - Administrative) --}}
        @if(in_array($role, ['admin', 'pendaftaran']))
        <li>
            <a href="{{ url('/rawat-inap') }}" class="nav-link {{ request()->is('rawat-inap*') ? 'active' : '' }}">
                <i class="bi-house-fill"></i>
                <span>Rawat Inap</span>
            </a>
        </li>
        @endif

        {{-- Triase IGD (Clinical - Doctor) --}}
        @if(in_array($role, ['admin', 'dokter']))
        <li>
            <a href="{{ route('igd.index') }}" class="nav-link {{ request()->routeIs('igd.*') ? 'active' : '' }}">
                <i class="bi-heart-pulse-fill"></i>
                <span>Triase IGD</span>
            </a>
        </li>

        {{-- Rekam Medis Access (Dokter Only) --}}
        @if($role === 'dokter')
        @php
            $isRekamMedisDokter = request()->routeIs('dokter.rekam-medis.*');
        @endphp
        <li>
            <a href="#rekamMedisDokterMenu" class="nav-link {{ $isRekamMedisDokter ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isRekamMedisDokter ? 'true' : 'false' }}">
                <i class="bi-file-medical"></i>
                <span>Rekam Medis</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ $isRekamMedisDokter ? 'show' : '' }}" id="rekamMedisDokterMenu">
                <a href="{{ route('dokter.rekam-medis.patients') }}" class="nav-link {{ request()->routeIs('dokter.rekam-medis.patients') || request()->routeIs('dokter.rekam-medis.request') || request()->routeIs('dokter.rekam-medis.view') ? 'active' : '' }}">Daftar Pasien</a>
                <a href="{{ route('dokter.rekam-medis.my-requests') }}" class="nav-link {{ request()->routeIs('dokter.rekam-medis.my-requests') ? 'active' : '' }}">Permintaan Saya</a>
            </div>
        </li>
        @endif
        @endif

        {{-- Gudang Obat (Admin & Apotek) --}}
        @if(in_array($role, ['admin', 'apotek']))
        <li class="nav-heading">FARMASI</li>
        @php
            $isGudang = request()->is('gudang*') || request()->is('apotek*') || request()->is('apotek-retail*') || request()->is('master-obat*') || request()->is('farmasi*');
        @endphp
        <li>
            <a href="#gudangMenu" class="nav-link {{ $isGudang ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isGudang ? 'true' : 'false' }}">
                <i class="bi-box-seam"></i>
                <span>Gudang Obat</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ $isGudang ? 'show' : '' }}" id="gudangMenu">
                <a href="{{ url('/apotek') }}" class="nav-link {{ request()->is('apotek') && !request()->is('apotek/*') ? 'active' : '' }}">Resep Pasien</a>
                <a href="{{ url('/apotek/stok-obat') }}" class="nav-link {{ request()->is('apotek/stok-obat*') ? 'active' : '' }}">Stok Obat</a>
                <a href="{{ url('/apotek/riwayat') }}" class="nav-link {{ request()->is('apotek/riwayat*') ? 'active' : '' }}">Riwayat Resep</a>
            </div>

        </li>
        @endif

        {{-- Kasir (Admin & Kasir) --}}
        @if(in_array($role, ['admin', 'kasir']))
        <li class="nav-heading">KEUANGAN</li>
        <li>
            <a href="{{ url('/kasir') }}" class="nav-link {{ request()->is('kasir') && !request()->is('kasir/*') ? 'active' : '' }}">
                <i class="bi-cash-coin"></i>
                <span>Kasir</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/billing') }}" class="nav-link {{ request()->is('billing*') ? 'active' : '' }}">
                <i class="bi-receipt"></i>
                <span>Billing</span>
            </a>
        </li>
        @endif

        {{-- Master Data & Lainnya (Admin Only) --}}
        @if($role === 'admin')
        <li class="nav-heading">ADMINISTRASI</li>
        @php $isMaster = request()->is('master-data*'); @endphp
        <li>
            <a href="#masterDataMenu" class="nav-link {{ $isMaster ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ $isMaster ? 'true' : 'false' }}">
                <i class="bi-database-fill"></i>
                <span>Master Data</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ $isMaster ? 'show' : '' }}" id="masterDataMenu">
                <a href="{{ route('master-data.pegawai') }}" class="nav-link {{ request()->is('master-data/pegawai*') ? 'active' : '' }}">Pegawai</a>
                <a href="{{ route('master-data.icd10.index') }}" class="nav-link {{ request()->is('master-data/icd10*') ? 'active' : '' }}">Diagnosa ICD-10</a>
                <a href="{{ route('master-data.icd9.index') }}" class="nav-link {{ request()->is('master-data/icd9*') ? 'active' : '' }}">Tindakan ICD-9</a>
            </div>
        </li>

        <li>
            <a href="#laporanMenu" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}">
                <i class="bi-file-earmark-text"></i>
                <span>Laporan</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ request()->is('laporan*') ? 'show' : '' }}" id="laporanMenu">
                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}">Pusat Laporan</a>
                <a href="{{ route('laporan.kunjungan') }}" class="nav-link {{ request()->routeIs('laporan.kunjungan') ? 'active' : '' }}">Laporan Kunjungan</a>
                <a href="{{ route('laporan.diagnosa') }}" class="nav-link {{ request()->routeIs('laporan.diagnosa') ? 'active' : '' }}">Laporan Morbiditas</a>
            </div>
        </li>

        <li><a href="{{ route('pengaturan') }}" class="nav-link {{ request()->is('pengaturan*') ? 'active' : '' }}"><i class="bi-gear-fill"></i> <span>Pengaturan</span></a></li>
        @endif

        {{-- Rekam Medis (Role: rekam_medis) --}}
        @if($role === 'rekam_medis')
        <li class="nav-heading">REKAM MEDIS</li>
        <li>
            <a href="{{ route('rekam-medis.index') }}" class="nav-link {{ request()->routeIs('rekam-medis.index') ? 'active' : '' }}">
                <i class="bi-grid-fill"></i>
                <span>Dashboard RM</span>
            </a>
        </li>
        <li>
            <a href="{{ route('rekam-medis.pasien') }}" class="nav-link {{ request()->routeIs('rekam-medis.pasien') || request()->routeIs('rekam-medis.riwayat') ? 'active' : '' }}">
                <i class="bi-folder2-open"></i>
                <span>Data Pasien (EMR)</span>
            </a>
        </li>
        <li>
            <a href="{{ route('rekam-medis.requests') }}" class="nav-link {{ request()->routeIs('rekam-medis.requests') ? 'active' : '' }}">
                <i class="bi-clipboard-check"></i>
                <span>Permintaan Akses</span>
                <span class="badge bg-danger rounded-pill ms-auto" id="pendingBadge" style="display: none;">0</span>
            </a>
        </li>
        <li>
            <a href="#laporanMenu" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}">
                <i class="bi-file-earmark-text"></i>
                <span>Laporan</span>
                <i class="bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse {{ request()->is('laporan*') ? 'show' : '' }}" id="laporanMenu">
                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}">Pusat Laporan</a>
                <a href="{{ route('laporan.kunjungan') }}" class="nav-link {{ request()->routeIs('laporan.kunjungan') ? 'active' : '' }}">Laporan Kunjungan</a>
                <a href="{{ route('laporan.diagnosa') }}" class="nav-link {{ request()->routeIs('laporan.diagnosa') ? 'active' : '' }}">Laporan Morbiditas</a>
            </div>
        </li>
        @endif
        
        <li class="mt-5 mb-5">&nbsp;</li>
    </ul>
</nav>
