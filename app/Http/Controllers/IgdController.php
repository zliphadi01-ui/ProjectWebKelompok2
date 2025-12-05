<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Models\Triage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IgdController extends Controller
{
    // Dashboard IGD: List pasien IGD sorted by Triage Priority
    public function index()
    {
        // Prioritas: Merah > Kuning > Hijau > Hitam > Belum Triase
        $igdPatients = Pendaftaran::with(['pasien', 'triage'])
                        ->where('poli', 'IGD')
                        ->whereDate('created_at', Carbon::today())
                        ->get()
                        ->sortBy(function($p) {
                            if (!$p->triage) return 5; // Belum Triase (Paling Bawah)
                            return match($p->triage->kategori) {
                                'Merah' => 1,
                                'Kuning' => 2,
                                'Hijau' => 3,
                                'Hitam' => 4,
                                default => 5
                            };
                        });

        return view('igd.index', compact('igdPatients'));
    }

    // Form Pendaftaran IGD (Fast Track)
    public function create()
    {
        $pasienData = Pasien::latest()->limit(20)->get();
        return view('igd.create', compact('pasienData'));
    }

    // Simpan Pendaftaran IGD
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'keluhan_utama' => 'required',
        ]);

        DB::transaction(function() use ($request) {
            $pasien = Pasien::find($request->pasien_id);

            $pendaftaran = Pendaftaran::create([
                'no_daftar' => 'IGD-' . time(),
                'pasien_id' => $pasien->id,
                'nama' => $pasien->nama,
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'nik' => $pasien->nik,
                'poli' => 'IGD',
                'status' => 'Menunggu Triase',
            ]);
            
            // Opsional: Langsung buat record triage kosong atau isi keluhan
        });

        return redirect()->route('igd.index')->with('success', 'Pasien masuk IGD.');
    }

    // Form Triase
    public function triase($id)
    {
        $pendaftaran = Pendaftaran::with('pasien')->findOrFail($id);
        return view('igd.triase', compact('pendaftaran'));
    }

    // Simpan Triase
    public function storeTriase(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|in:Merah,Kuning,Hijau,Hitam',
            'tensi' => 'nullable',
            'nadi' => 'nullable',
            'suhu' => 'nullable',
            'rr' => 'nullable',
            'spo2' => 'nullable',
        ]);

        Triage::updateOrCreate(
            ['pendaftaran_id' => $id],
            [
                'kategori' => $request->kategori,
                'keluhan_utama' => $request->keluhan_utama,
                'tensi' => $request->tensi,
                'nadi' => $request->nadi,
                'suhu' => $request->suhu,
                'rr' => $request->rr,
                'spo2' => $request->spo2,
            ]
        );

        $pendaftaran = Pendaftaran::find($id);
        $pendaftaran->status = 'Menunggu Dokter'; // Update status flow
        $pendaftaran->save();

        return redirect()->route('igd.index')->with('success', 'Triase berhasil disimpan.');
    }

    // Hapus pasien dari antrian IGD
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        // Hapus data triase jika ada
        if ($pendaftaran->triage) {
            $pendaftaran->triage->delete();
        }
        
        // Hapus pendaftaran
        $pendaftaran->delete();
        
        return redirect()->route('igd.index')->with('success', 'Pasien berhasil dihapus dari antrian IGD.');
    }
}
