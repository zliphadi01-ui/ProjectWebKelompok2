<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    // =================================================================
    // 1. HALAMAN UTAMA (DATA KUNJUNGAN & PENCARIAN)
    // =================================================================
    public function index(Request $request)
    {
        $query = $request->input('q');
        $pasiens = null;

        // Logika Pencarian Pasien Lama
        if ($query) {
            $pasiens = Pasien::where(function ($q) use ($query) {
                $q->where('no_rm', 'like', "%$query%")
                  ->orWhere('nik', 'like', "%$query%")
                  ->orWhere('nama', 'like', "%$query%");
            })->limit(20)->get();
        }

        // List Data Kunjungan Hari Ini
        $pendaftaran = Pendaftaran::with('pasien')
                        ->whereDate('created_at', Carbon::today())
                        ->latest()
                        ->get();

        return view('pendaftaran.index', compact('pasiens', 'query', 'pendaftaran'));
    }

    // =================================================================
    // 2. FORM PASIEN BARU
    // =================================================================
    public function createBaru()
    {
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']);
        
        // Data untuk autocomplete (opsional)
        $pasienData = Pasien::select('id', 'nama', 'no_rm', 'nik', 'tanggal_lahir')
                            ->latest()
                            ->limit(100)
                            ->get();

        return view('pendaftaran.pasien-baru', compact('poliList', 'pasienData'));
    }

    // =================================================================
    // 3. PROSES SIMPAN PASIEN BARU (FIXED)
    // =================================================================
    public function storePasienBaru(Request $request)
    {
        // 1. Validasi Wajib
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|numeric|digits:16',
            'jenis_kelamin' => 'required',
            'poli' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // 2. Simpan / Cari Pasien
            $pasien = Pasien::updateOrCreate(
                ['nik' => $request->nik],
                [
                    'nama' => $request->nama,
                    'no_rm' => date('ym') . '-' . rand(1000, 9999),
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'telepon' => $request->telepon,
                    'alamat' => $request->alamat ?? '-',
                ]
            );

            // 3. Simpan Pendaftaran (Kunjungan)
            Pendaftaran::create([
                'no_daftar' => 'REG-' . time(),
                'pasien_id' => $pasien->id,
                'nama' => $pasien->nama,            // Sesuai database Anda
                'jenis_kelamin' => $pasien->jenis_kelamin, // Sesuai database Anda
                'nik' => $pasien->nik,              // Opsional
                'poli' => $request->poli,           // KOLOM SUDAH BENAR: 'poli'
                'status' => 'Menunggu',
            ]);

            DB::commit();

            // 4. KEMBALI KE DATA KUNJUNGAN (SESUAI PERMINTAAN)
            return redirect()->route('pendaftaran.index')
                             ->with('success', 'Berhasil Mendaftarkan Pasien: ' . $pasien->nama);

        } catch (\Exception $e) {
            DB::rollback();
            // Tampilkan error di layar jika gagal
            dd("GAGAL MENYIMPAN: " . $e->getMessage());
        }
    }

    // =================================================================
    // 4. FORM DAFTAR PASIEN LAMA
    // =================================================================
    public function formDaftarPoli($id)
    {
        $pasien = Pasien::findOrFail($id);
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']);
        
        return view('pendaftaran.daftar-poli', compact('pasien', 'poliList'));
    }

    // =================================================================
    // 5. PROSES SIMPAN PASIEN LAMA
    // =================================================================
    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'poli' => 'required',
        ]);

        $pasien = Pasien::find($request->pasien_id);

        Pendaftaran::create([
            'no_daftar' => 'REG-' . time(),
            'pasien_id' => $pasien->id,
            'nama' => $pasien->nama,
            'jenis_kelamin' => $pasien->jenis_kelamin,
            'nik' => $pasien->nik,
            'poli' => $request->poli, // KOLOM SUDAH BENAR
            'status' => 'Menunggu',
        ]);

        // Kembali ke Data Kunjungan
        return redirect()->route('pendaftaran.index')
                         ->with('success', 'Pendaftaran Poli Berhasil!');
    }

    // =================================================================
    // 6. LAIN-LAIN
    // =================================================================
    public function list()
    {
        // Opsi lain jika ingin view list terpisah
        $pendaftaran = Pendaftaran::with('pasien')->latest()->paginate(10);
        return view('pendaftaran.list', compact('pendaftaran'));
    }

    public function destroy($id)
    {
        Pendaftaran::destroy($id);
        return back()->with('success', 'Data dihapus');
    }

    // Dummy Methods
    public function antrianOnline() { return view('pendaftaran.antrian-online'); }
    public function edit($id) { return back(); }
    public function update(Request $request, $id) { return back(); }
    public function startPemeriksaan($id) { return back(); }
    public function discharge($id) { return back(); }
}