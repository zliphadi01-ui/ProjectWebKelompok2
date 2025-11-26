<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
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
}
