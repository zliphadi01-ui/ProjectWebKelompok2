<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\LabRequest;
use App\Models\RawatInap;

class RekamMedisController extends Controller
{
    public function index()
    {
        // Dashboard Stats for Rekam Medis
        $totalPasien = Pasien::count();
        $kunjunganHariIni = Pendaftaran::whereDate('created_at', now())->count();
        $rawatInapAktif = RawatInap::where('status', 'Dirawat')->count();

        return view('rekam_medis.index', compact('totalPasien', 'kunjunganHariIni', 'rawatInapAktif'));
    }

    public function pasien(Request $request)
    {
        $query = Pasien::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_rm', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
        }

        $pasien = $query->orderBy('nama')->paginate(20);

        return view('rekam_medis.pasien', compact('pasien'));
    }

    public function riwayat($id)
    {
        $pasien = Pasien::findOrFail($id);
        
        // Gather all history
        $pendaftaran = Pendaftaran::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $pemeriksaan = Pemeriksaan::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $labRequests = LabRequest::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $rawatInap = RawatInap::with('cppt')->where('pasien_id', $id)->orderBy('created_at', 'desc')->get();

        // Merge and sort by date (simplified approach: just passing collections)
        // In a more complex app, we might merge these into a single timeline collection.

        return view('rekam_medis.riwayat', compact('pasien', 'pendaftaran', 'pemeriksaan', 'labRequests', 'rawatInap'));
    }
}
