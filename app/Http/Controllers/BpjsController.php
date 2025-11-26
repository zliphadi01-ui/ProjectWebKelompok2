<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        return view('bpjs.poli');
    }

    public function riwayatPesertaBpjs()
    {
        return view('bpjs.riwayat');
    }

    public function cetakRujukanBpjs()
    {
        return view('bpjs.cetak-rujukan');
    }
}
