<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PharmacyController extends Controller
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

    public function gudangObat()
    {
        $counts = [];
        if (Schema::hasTable('pasien')) {
            $counts['pasien'] = DB::table('pasien')->count();
        }
        return view('pages.gudang', compact('counts'));
    }

    public function apotek()
    {
        $title = 'Apotek';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function apotekRetail()
    {
        $title = 'Apotek Retail';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function masterObat()
    {
        $title = 'Master Obat';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function farmasi()
    {
        $title = 'Farmasi';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }
}
