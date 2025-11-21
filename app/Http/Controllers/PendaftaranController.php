<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\DashboardStatsUpdated;

class PendaftaranController extends Controller
{
    // =================================================================
    // 1. HALAMAN UTAMA (PENCARIAN PASIEN LAMA FIX)
    // =================================================================
    public function index(Request $request)
    {
        $query = $request->input('q');
        $pasiens = null;

        if ($query) {
            // FIX PENCARIAN (VERSI AMAN & KOMPATIBEL TINGGI)
            $pasiens = Pasien::where(function ($q) use ($query) {
                // 1. Cari berdasarkan No. RM atau NIK (case sensitive)
                $q->where('no_rm', $query)
                  ->orWhere('nik', $query)
                  
                  // 2. Cari berdasarkan Nama (menggunakan where-lower untuk case insensitive)
                  // Perintah ini lebih aman daripada menggunakan DB::raw
                  ->orWhere(DB::raw('lower(nama)'), 'like', '%' . strtolower($query) . '%');
            })
            // Tambahkan WHERE NOT NULL agar pasien tidak terdaftar ganda
            ->whereNotNull('no_rm') 
            ->get();
        }

        // TAMBAHAN: Ambil data pendaftaran hari ini (untuk view list di sidebar)
        $pendaftaran = Pendaftaran::with('pasien')
                        ->whereDate('created_at', Carbon::today())
                        ->latest()
                        ->get();

        return view('pendaftaran.index', compact('pasiens', 'query', 'pendaftaran'));
    }
    
    // ... (sisa kode controller lainnya tetap sama) ...
    // ...
    // ...
    
    // =================================================================
    // 4. HELPER & LAINNYA
    // =================================================================
    private function updateDashboardStats() {
        // Logika update dashboard
    }

    public function list()
    {
        $pendaftaran = Pendaftaran::with('pasien')->latest()->paginate(10);
        return view('pendaftaran.list', compact('pendaftaran'));
    }

    public function destroy($id)
    {
        try {
            $p = Pendaftaran::findOrFail($id);
            $p->delete();
            $this->updateDashboardStats();
            return back()->with('success', 'Data kunjungan dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
    
    // DUMMY METHODS (Pastikan ini ada agar tidak error saat dipanggil route)
    public function createBaru()
    {
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']);
        $pasienData = [];
        return view('pendaftaran.pasien-baru', compact('poliList', 'pasienData'));
    }

    public function storePasienBaru(Request $request) { return back(); }
    public function formDaftarPoli($id) { return back(); }
    public function storePendaftaran(Request $request) { return back(); }
    public function antrianOnline() { return back(); }
    public function edit($id) { $data = Pendaftaran::find($id); return view('pendaftaran.edit', compact('data')); }
    public function update(Request $request, $id) { return back(); }
    public function startPemeriksaan($id) { return back(); }
    public function discharge($id) { return back(); }
}