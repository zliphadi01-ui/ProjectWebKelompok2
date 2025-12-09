<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class BpjsController extends Controller
{
    protected function commonCounts()
    {
        $counts = [];
        if (Schema::hasTable('pasien')) {
            $counts['pasien'] = DB::table('pasien')->count();
        }
        if (Schema::hasTable('pendaftarans')) {
            $counts['pendaftaran'] = DB::table('pendaftarans')->count();
        }
        if (Schema::hasTable('pemeriksaans')) {
            $counts['pemeriksaan'] = DB::table('pemeriksaans')->count();
        }
        return $counts;
    }

    public function bpjs()
    {
        $counts = [];
        if (Schema::hasTable('pasien')) {
            $counts['pasien'] = DB::table('pasien')->count();
        }
        return view('pages.bpjs', compact('counts'));
    }

    public function poliBpjs()
    {
        // Ambil data pendaftaran BPJS hari ini
        $sepHariIni = Pendaftaran::with('pasien')
            ->whereHas('pasien', function($query) {
                $query->where('jenis_pembayaran', 'BPJS');
            })
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        // Hitung statistik
        $stats = [
            'total_sep' => $sepHariIni->count(),
            'menunggu' => $sepHariIni->where('status', 'Menunggu')->count(),
            'selesai' => $sepHariIni->where('status', 'Selesai')->count(),
        ];

        return view('bpjs.poli', compact('sepHariIni', 'stats'));
    }

    public function riwayatPesertaBpjs(Request $request)
    {
        $search = $request->input('search');
        $riwayat = null;

        if ($search) {
            // Cari pasien BPJS berdasarkan No. BPJS atau NIK
            $riwayat = Pendaftaran::with('pasien')
                ->whereHas('pasien', function($query) use ($search) {
                    $query->where('jenis_pembayaran', 'BPJS')
                          ->where(function($q) use ($search) {
                              $q->where('no_bpjs', 'like', "%$search%")
                                ->orWhere('nik', 'like', "%$search%");
                          });
                })
                ->latest()
                ->get();
        }

        return view('bpjs.riwayat', compact('riwayat', 'search'));
    }

    public function cetakRujukanBpjs()
    {
        return view('bpjs.cetak-rujukan');
    }
}
