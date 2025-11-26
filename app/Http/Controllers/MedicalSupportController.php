<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MedicalSupportController extends Controller
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

    public function laboratorium()
    {
        return view('pages.laboratorium');
    }

    public function poli(Request $request, $nama_poli = null)
    {
        $title = $nama_poli ?? 'Poliklinik';
        
        // Ambil antrean untuk poli ini hari ini
        $antrean = \App\Models\Pendaftaran::where('poli', $nama_poli)
                    ->whereDate('created_at', \Carbon\Carbon::today())
                    ->orderBy('created_at', 'asc')
                    ->get();
                    
        return view('poli.show', compact('title', 'antrean', 'nama_poli'));
    }
}
