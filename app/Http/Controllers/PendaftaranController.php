<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    // 1. HALAMAN UTAMA (PENCARIAN)
    public function index(Request $request)
    {
        $query = $request->input('q');
        $pasiens = null;

        // Cari Pasien
        if ($query) {
            $pasiens = Pasien::where('no_rm', $query)
                        ->orWhere('nik', $query)
                        ->orWhere('nama', 'like', '%' . $query . '%')
                        ->get();
        }

        // [FIX UTAMA] Mengirim variabel pendaftaran hari ini agar tidak error "Undefined variable"
        $pendaftaran = Pendaftaran::whereDate('created_at', Carbon::today())->latest()->get();

        return view('pendaftaran.index', compact('pasiens', 'query', 'pendaftaran'));
    }

    // 2. HALAMAN FORM BARU
    public function createBaru()
    {
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']);
        $pasienData = [];
        return view('pendaftaran.pasien-baru', compact('poliList', 'pasienData'));
    }

    // 3. SIMPAN PASIEN BARU (PASTI MASUK)
    public function storePasienBaru(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'poli' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // A. Buat No RM Otomatis
            $latest = Pasien::latest('id')->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $noRM = 'RM-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // B. Simpan ke Tabel Pasien (Master Data)
            $pasien = new Pasien();
            $pasien->nama = $request->nama;
            $pasien->nik = $request->nik;
            $pasien->no_rm = $noRM;
            $pasien->jenis_kelamin = $request->jenis_kelamin;
            $pasien->tanggal_lahir = $request->tanggal_lahir;
            $pasien->telepon = $request->telepon;
            $pasien->alamat = $request->alamat ?? '-';
            $pasien->save();

            // C. Simpan ke Tabel Pendaftaran (Data Kunjungan)
            $pendaftaran = new Pendaftaran();
            $pendaftaran->no_daftar = 'REG-' . time();
            $pendaftaran->pasien_id = $pasien->id;
            
            // Simpan detail juga (redundansi agar aman di tabel list)
            $pendaftaran->nama = $pasien->nama; 
            $pendaftaran->nik = $pasien->nik;
            $pendaftaran->jenis_kelamin = $pasien->jenis_kelamin;
            $pendaftaran->tanggal_lahir = $pasien->tanggal_lahir;
            $pendaftaran->telepon = $pasien->telepon;
            
            $pendaftaran->poli = $request->poli;
            $pendaftaran->status = 'Menunggu';
            $pendaftaran->save();

            DB::commit();

            return redirect()->route('pendaftaran.list')->with('success', 'Pasien Berhasil Didaftar!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    // 4. DAFTAR POLI (PASIEN LAMA)
    public function formDaftarPoli($id)
    {
        $pasien = Pasien::findOrFail($id);
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak']);
        return view('pendaftaran.daftar-poli', compact('pasien', 'poliList'));
    }

    public function storePendaftaran(Request $request)
    {
        try {
            $pasien = Pasien::findOrFail($request->pasien_id);
            
            $pendaftaran = new Pendaftaran();
            $pendaftaran->no_daftar = 'REG-' . time();
            $pendaftaran->pasien_id = $pasien->id;
            $pendaftaran->nama = $pasien->nama;
            $pendaftaran->nik = $pasien->nik;
            $pendaftaran->jenis_kelamin = $pasien->jenis_kelamin;
            $pendaftaran->tanggal_lahir = $pasien->tanggal_lahir;
            $pendaftaran->telepon = $pasien->telepon;
            $pendaftaran->poli = $request->poli;
            $pendaftaran->status = 'Menunggu';
            $pendaftaran->save();

            return redirect()->route('pendaftaran.list')->with('success', 'Berhasil Daftar Poli!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // 5. HALAMAN LIST
    public function list()
    {
        $pendaftaran = Pendaftaran::with('pasien')->latest()->paginate(10);
        return view('pendaftaran.list', compact('pendaftaran'));
    }

    // Lain-lain (Dipertahankan agar route tidak error)
    public function destroy($id) {
        Pendaftaran::destroy($id);
        return back()->with('success', 'Dihapus');
    }
    public function antrianOnline() { return view('pendaftaran.antrian-online', ['antrian' => []]); }
    public function startPemeriksaan($id) { 
        $p = Pendaftaran::findOrFail($id); $p->status = 'Dalam Pemeriksaan'; $p->save();
        return redirect()->route('pemeriksaan.soap', ['id' => $id]);
    }
    public function discharge($id) { 
        $p = Pendaftaran::findOrFail($id); $p->status = 'Selesai'; $p->save(); return back();
    }
    public function edit($id) { return back(); } 
    public function update(Request $request, $id) { return back(); } 
}