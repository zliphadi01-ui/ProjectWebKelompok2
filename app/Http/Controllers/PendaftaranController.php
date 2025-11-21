<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendaftaranController extends Controller
{
    // --- HALAMAN UTAMA ---
    public function index(Request $request)
    {
        $query = $request->input('q');
        $pasiens = $query ? Pasien::where('no_rm', $query)
                    ->orWhere('nik', $query)
                    ->orWhere('nama', 'like', '%' . $query . '%')
                    ->get() : null;

        return view('pendaftaran.index', compact('pasiens', 'query'));
    }

    // --- FORM PASIEN BARU ---
    public function createBaru()
    {
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak']);
        $pasienData = [];
        return view('pendaftaran.pasien-baru', compact('poliList', 'pasienData'));
    }

    // --- FUNGSI SIMPAN PASIEN BARU (VERSI DEBUGGING/AMAN) ---
    public function storePasienBaru(Request $request)
    {
        // 1. Validasi Sederhana Dulu (Biar gak gampang error)
        $request->validate([
            'nama' => 'required',
            'nik' => 'required', 
            // 'nik' => 'required|unique:pasiens,nik', <-- Matikan dulu unique-nya kalau bikin error
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'telepon' => 'required',
            'poli' => 'required',
        ]);

        try {
            DB::beginTransaction(); // Mulai Transaksi

            // 2. Buat No RM Otomatis
            $latest = Pasien::latest('id')->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $noRM = 'RM-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // 3. Simpan ke Tabel PASIEN
            $pasien = Pasien::create([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'no_rm' => $noRM,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat ?? '-',
            ]);

            // 4. Simpan ke Tabel PENDAFTARAN (Kunjungan)
            $noReg = 'REG-' . str_pad(Pendaftaran::count() + 1, 3, '0', STR_PAD_LEFT);
            
            Pendaftaran::create([
                'no_daftar' => $noReg,
                'pasien_id' => $pasien->id,
                // Kita simpan data detail juga ke tabel pendaftaran (redundansi agar aman ditampilkan)
                'nama' => $pasien->nama, 
                'nik' => $pasien->nik,
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'tanggal_lahir' => $pasien->tanggal_lahir,
                'telepon' => $pasien->telepon,
                'poli' => $request->poli,
                'status' => 'Menunggu'
            ]);

            DB::commit(); // Simpan Permanen

            // Redirect ke Data Kunjungan dengan pesan Sukses
            return redirect()->route('pendaftaran.list')->with('success', 'Berhasil Mendaftar! Pasien masuk antrean.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika error
            // Tampilkan Error Jelas di Layar
            return back()->with('error', 'GAGAL SIMPAN: ' . $e->getMessage())->withInput();
        }
    }

    // --- FUNGSI SIMPAN PASIEN LAMA (DAFTAR POLI) ---
    public function formDaftarPoli($id)
    {
        $pasien = Pasien::findOrFail($id);
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak']);
        return view('pendaftaran.daftar-poli', compact('pasien', 'poliList'));
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate(['pasien_id' => 'required', 'poli' => 'required']);

        try {
            $pasien = Pasien::findOrFail($request->pasien_id);
            $noReg = 'REG-' . str_pad(Pendaftaran::count() + 1, 3, '0', STR_PAD_LEFT);

            Pendaftaran::create([
                'no_daftar' => $noReg,
                'pasien_id' => $pasien->id,
                'nama' => $pasien->nama, 
                'nik' => $pasien->nik,
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'tanggal_lahir' => $pasien->tanggal_lahir,
                'telepon' => $pasien->telepon,
                'poli' => $request->poli,
                'status' => 'Menunggu'
            ]);

            return redirect()->route('pendaftaran.list')->with('success', 'Pendaftaran Poli Berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // --- HALAMAN LIST DATA KUNJUNGAN ---
    public function list()
    {
        // Ambil data pendaftaran terbaru + data pasiennya
        $pendaftaran = Pendaftaran::with('pasien')->latest()->paginate(10);
        return view('pendaftaran.list', compact('pendaftaran'));
    }

    // --- LAIN-LAIN ---
    public function antrianOnline()
    {
        $antrian = Pendaftaran::where('status', 'Menunggu')->latest()->get();
        return view('pendaftaran.antrian-online', compact('antrian'));
    }

    public function destroy($id)
    {
        try {
            $p = Pendaftaran::findOrFail($id);
            $p->delete();
            return back()->with('success', 'Data kunjungan dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }

    public function startPemeriksaan($id)
    {
        $p = Pendaftaran::findOrFail($id);
        $p->status = 'Dalam Pemeriksaan';
        $p->save();
        return redirect()->route('pemeriksaan.soap', ['id' => $id]);
    }

    public function discharge($id)
    {
        $p = Pendaftaran::findOrFail($id);
        $p->status = 'Selesai';
        $p->save();
        return back();
    }
    
    // Method edit/update jika diperlukan
    public function edit($id) { return view('pendaftaran.edit'); }
    public function update(Request $request, $id) { return back(); }
}