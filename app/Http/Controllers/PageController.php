<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function bpjs()
    {
        $counts = [];
        if (Schema::hasTable('pasien')) {
            $counts['pasien'] = DB::table('pasien')->count();
        }
        return view('pages.bpjs', compact('counts'));
    }

    public function gudangObat()
    {
        $counts = [];
        if (Schema::hasTable('pasien')) {
            $counts['pasien'] = DB::table('pasien')->count();
        }
        return view('pages.gudang', compact('counts'));
    }

    public function kasir()
    {
        $counts = [];
        if (Schema::hasTable('pendaftarans')) {
            $counts['pendaftaran'] = DB::table('pendaftarans')->count();
        }
        return view('pages.kasir', compact('counts'));
    }

    public function laporan()
    {
        return view('pages.laporan');
    }

    public function laboratorium()
    {
        return view('pages.laboratorium');
    }

    // Generic pages for sidebar items that didn't have dedicated controllers yet
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

    public function poliBpjs()
    {
        $title = 'Poli BPJS';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function riwayatPesertaBpjs()
    {
        $title = 'Riwayat Peserta BPJS';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function cetakRujukanBpjs()
    {
        $title = 'Cetak Rujukan BPJS';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function poli(Request $request, $slug = null)
    {
        $title = 'Poli ' . ($slug ? str_replace('-', ' ', ucfirst($slug)) : '');
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function laporanPembagian()
    {
        $title = 'Laporan Pembagian';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function pengaturan()
    {
        $title = 'Pengaturan';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function pengaturanGrup()
    {
        $title = 'Pengaturan Grup';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function bypass()
    {
        $title = 'Bypass';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function whatsapp()
    {
        $title = 'Whatsapp';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }

    public function billing()
    {
        $title = 'Billing';
        $counts = $this->commonCounts();
        return view('pages.generic', compact('title', 'counts'));
    }
}
