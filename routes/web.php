<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RawatInapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Pasien;
// =======================
// LOGIN & LOGOUT MANUAL
// =======================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // login sederhana tanpa database
    // first, try database users if table exists
    try {
        if (Schema::hasTable('users')) {
            $user = User::where('email', $username)->orWhere('name', $username)->first();
            if ($user && Hash::check($password, $user->password)) {
                session(['user' => $user->name, 'user_id' => $user->id, 'user_photo' => $user->profile_photo ?? null]);
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['ok' => true, 'redirect' => url('/dashboard')]);
                }
                return redirect('/dashboard');
            }
        }
    } catch (\Exception $e) {
        // ignore DB errors and fallback to hardcoded login
    }

    // fallback hardcoded credential
    if ($username === 'admin' && $password === '12345') {
        session(['user' => $username]);
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['ok' => true, 'redirect' => url('/dashboard')]);
        }
        return redirect('/dashboard');
    }

    if ($request->wantsJson() || $request->ajax()) {
        return response()->json(['ok' => false, 'message' => 'Username atau password salah'], 422);
    }

    return back()->with('error', 'Username atau password salah!');
});

Route::get('/logout', function () {
    session()->forget('user');
    return redirect('/login');
})->name('logout');

// Profile edit & upload
use App\Http\Controllers\ProfileController;
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo');



// Landing Page & Auth
Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register/process', function () {
    return redirect('/dashboard');
});

// Dashboard dengan Controller
Route::get('/dashboard', function () {
    if (!session('user')) {
        return redirect('/login');
    }
    return app(App\Http\Controllers\DashboardController::class)->index();
})->name('dashboard');

Route::post('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');
Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
// Dashboard details for card modals (AJAX)
Route::get('/dashboard/details/{type}', [DashboardController::class, 'details'])->name('dashboard.details');

// General pages (placeholders)
Route::get('/bpjs', [PageController::class, 'bpjs'])->name('bpjs');
Route::get('/gudang', [PageController::class, 'gudangObat'])->name('gudang');
Route::get('/kasir', [PageController::class, 'kasir'])->name('kasir');
Route::get('/laporan', [PageController::class, 'laporan'])->name('laporan');
Route::get('/laboratorium', [PageController::class, 'laboratorium'])->name('laboratorium');
// Additional generic pages used by sidebar
Route::get('/apotek', [PageController::class, 'apotek'])->name('apotek');
Route::get('/apotek-retail', [PageController::class, 'apotekRetail'])->name('apotek.retail');
Route::get('/master-obat', [PageController::class, 'masterObat'])->name('master-obat');
Route::get('/farmasi', [PageController::class, 'farmasi'])->name('farmasi');
Route::get('/poli-bpjs', [PageController::class, 'poliBpjs'])->name('poli-bpjs');
Route::get('/riwayat-peserta-bpjs', [PageController::class, 'riwayatPesertaBpjs'])->name('riwayat-peserta-bpjs');
Route::get('/cetak-rujukan-bpjs', [PageController::class, 'cetakRujukanBpjs'])->name('cetak-rujukan-bpjs');
Route::get('/poli/{slug}', [PageController::class, 'poli'])->name('poli.show');
Route::get('/laporan/pembagian', [PageController::class, 'laporanPembagian'])->name('laporan.pembagian');
Route::get('/pengaturan', [PageController::class, 'pengaturan'])->name('pengaturan');
Route::get('/pengaturan-grup', [PageController::class, 'pengaturanGrup'])->name('pengaturan.grup');
Route::get('/bypass', [PageController::class, 'bypass'])->name('bypass');
Route::get('/whatsapp', [PageController::class, 'whatsapp'])->name('whatsapp');
Route::get('/billing', [PageController::class, 'billing'])->name('billing');

// Rawat Inap resource (CRUD) - connected to DB
Route::resource('rawat-inap', RawatInapController::class);

// Pendaftaran dengan Controller (Satu Pintu FIX)
Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    
    // 1. ROUTE UTAMA (Satu Pintu / Pencarian)
    Route::get('/', [PendaftaranController::class, 'index'])->name('index');

    // 2. FORM PASIEN BARU
    Route::get('/create-baru', [PendaftaranController::class, 'createBaru'])->name('create-baru'); 
    Route::post('/store-baru', [PendaftaranController::class, 'storePasienBaru'])->name('store-baru');

    // 3. DAFTAR POLI (PASIEN LAMA)
    Route::get('/daftar-poli/{id}', [PendaftaranController::class, 'formDaftarPoli'])->name('daftar-poli'); // FIX DARI ERROR FOTO ANDA
    Route::post('/store-poli', [PendaftaranController::class, 'storePendaftaran'])->name('store-poli');

    // 4. LIST & ACTION
    Route::get('/list', [PendaftaranController::class, 'list'])->name('list');
    Route::get('/antrian-online', [PendaftaranController::class, 'antrianOnline'])->name('antrian-online');
    Route::get('/edit/{id}', [PendaftaranController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PendaftaranController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PendaftaranController::class, 'destroy'])->name('destroy');
    Route::post('/start-pemeriksaan/{id}', [PendaftaranController::class, 'startPemeriksaan'])->name('start-pemeriksaan');
    Route::post('/discharge/{id}', [PendaftaranController::class, 'discharge'])->name('discharge');
});

// Pasien Management dengan Controller
Route::prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/pencarian', [PasienController::class, 'pencarian'])->name('pencarian');
    Route::get('/cetak', [PasienController::class, 'cetak'])->name('cetak');
    Route::get('/data', [PasienController::class, 'index'])->name('data');
    Route::get('/create', [PasienController::class, 'create'])->name('create');
    Route::get('/kontrol', [PasienController::class, 'kontrol'])->name('kontrol');
    Route::get('/master', [PasienController::class, 'master'])->name('master');
    Route::get('/verifikasi', [PasienController::class, 'verifikasi'])->name('verifikasi');
    Route::post('/store', [PasienController::class, 'store'])->name('store');
    Route::get('/show/{id}', [PasienController::class, 'show'])->name('show');
    // route edit pasien delegates to PasienController; PasienController provides a safe stub
    Route::get('/edit/{id}', [PasienController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PasienController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PasienController::class, 'destroy'])->name('destroy');
    Route::get('/search', [PasienController::class, 'search'])->name('search');
});

// Kunjungan dengan Controller
Route::prefix('kunjungan')->name('kunjungan.')->group(function () {
    Route::get('/hari-ini', [KunjunganController::class, 'hariIni'])->name('hari-ini');
    Route::post('/filter', [KunjunganController::class, 'filter'])->name('filter');
    Route::get('/panggil/{id}', [KunjunganController::class, 'panggil'])->name('panggil');
    Route::get('/refresh', [KunjunganController::class, 'refresh'])->name('refresh');
});

// Pemeriksaan (SOAP) dengan Controller
Route::prefix('pemeriksaan')->name('pemeriksaan.')->group(function () {
    // Index: daftar pasien yang akan diperiksa (added)
    Route::get('/', [PemeriksaanController::class, 'index'])->name('index');
    Route::get('/soap/{id?}', [PemeriksaanController::class, 'soap'])->name('soap');
    Route::post('/store', [PemeriksaanController::class, 'store'])->name('store');
    Route::post('/store-print', [PemeriksaanController::class, 'storeAndPrint'])->name('store-print');
    Route::get('/print/{id}', [PemeriksaanController::class, 'print'])->name('print');
    Route::get('/riwayat/{no_rm}', [PemeriksaanController::class, 'riwayat'])->name('riwayat');
});

// Master Data dengan Controller
Route::prefix('master-data')->name('master-data.')->group(function () {
    Route::get('/keadaan-akhir', [MasterDataController::class, 'keadaanAkhir'])->name('keadaan-akhir');
    Route::get('/menu', [MasterDataController::class, 'menu'])->name('menu');
    Route::get('/mitra', [MasterDataController::class, 'mitra'])->name('mitra');
    Route::get('/hak-akses', [MasterDataController::class, 'hakAkses'])->name('hak-akses');
    Route::get('/aktivasi-poli', [MasterDataController::class, 'aktivasiPoli'])->name('aktivasi-poli');
    Route::get('/pegawai', [MasterDataController::class, 'pegawai'])->name('pegawai');
    Route::get('/jadwal-poli', [MasterDataController::class, 'jadwalPoli'])->name('jadwal-poli');
    Route::get('/tindakan-laborat', [MasterDataController::class, 'tindakanLaborat'])->name('tindakan-laborat');
    Route::get('/diagnosa', [MasterDataController::class, 'diagnosa'])->name('diagnosa');
    Route::get('/kamar-rawat-inap', [MasterDataController::class, 'kamarRawatInap'])->name('kamar-rawat-inap');
    Route::get('/unit', [MasterDataController::class, 'unit'])->name('unit');
    Route::get('/vendor', [MasterDataController::class, 'vendor'])->name('vendor');
    Route::get('/kategori-diagnosa', [MasterDataController::class, 'kategoriDiagnosa'])->name('kategori-diagnosa');
    Route::get('/jenis-pembayaran', [MasterDataController::class, 'jenisPembayaran'])->name('jenis-pembayaran');
    Route::get('/profesi', [MasterDataController::class, 'profesi'])->name('profesi');
    Route::get('/resep-info', [MasterDataController::class, 'resepInfo'])->name('resep-info');
    Route::get('/rs-rujukan', [MasterDataController::class, 'rsRujukan'])->name('rs-rujukan');
    
    
});