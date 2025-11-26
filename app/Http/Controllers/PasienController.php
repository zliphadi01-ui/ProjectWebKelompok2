<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
// use App\Http\Requests\StorePasienRequest; // Idealnya menggunakan Form Request
// use App\Http\Requests\UpdatePasienRequest; // Idealnya menggunakan Form Request
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    /**
     * Tampilkan halaman pencarian kartu/cepat.
     */
    public function pencarian(Request $request)
    {
        $q = $request->query('q');
        // Menggunakan Local Scope Filter
        $results = Pasien::filter($q)
                ->limit(20)
                ->get();

        return view('pasien.pencarian', compact('results', 'q'));
    }

    /**
     * Tampilkan halaman cetak (tampilan sederhana).
     */
    public function cetak(Request $request)
    {
        $no_rm = $request->query('no_rm');
        $pasien = $no_rm ? Pasien::where('no_rm', $no_rm)->first() : null;
        return view('pasien.cetak', compact('pasien'));
    }

    /**
     * Daftar data pasien (index).
     */
    public function index(Request $request)
    {
        $perPage = 15;
        $q = $request->q;
        
        // Menggunakan Local Scope Filter
        $pasien = Pasien::filter($q)
            ->orderBy('nama')
            ->paginate($perPage)
            ->withQueryString();
            
        return view('pasien.data', compact('pasien'));
    }

    /**
     * Tampilkan halaman kontrol pasien (contoh: melihat ringkasan kontrol).
     */
    public function kontrol(Request $request)
    {
        $pasien = Pasien::orderBy('nama')->limit(25)->get();
        return view('pasien.kontrol', compact('pasien'));
    }

    /**
     * Master pasien (halaman manajemen).
     */
    public function master(Request $request)
    {
        $pasien = Pasien::orderBy('created_at', 'desc')->paginate(20);
        return view('pasien.master', compact('pasien'));
    }

    /**
     * Verifikasi pasien (contoh halaman).
     */
    public function verifikasi(Request $request)
    {
        $pasien = Pasien::orderBy('id', 'desc')->limit(50)->get();
        return view('pasien.verifikasi', compact('pasien'));
    }

    /**
     * Tampilkan detail pasien.
     */
    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.show', compact('pasien'));
    }

    /**
     * Tampilkan form edit pasien.
     */
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Simpan pasien baru (MEMPERBAIKI GENERASI NO_RM).
     */
    public function store(Request $request)
    {
        // Pindahkan validasi ke Form Request untuk kode yang lebih rapi
        $validated = $request->validate([
            'no_rm' => 'nullable|string|max:50|unique:pasien,no_rm', // Tambahkan unique check
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
        ]);
        
        // Cek apakah no_rm sudah ada, jika tidak, kita buat secara atomik
        if (empty($validated['no_rm'])) {
            // Hapus 'no_rm' sementara dari validated data agar kolom tsb bisa diisi null/default
            // kita akan generate dan update SETELAH data disimpan (agar ID terjamin)
            unset($validated['no_rm']);
        }
        
        try {
            // 1. Simpan data pasien awal
            $pasien = Pasien::create($validated);
            
            // 2. Generate NO_RM berdasarkan ID yang baru terbuat (Lebih aman dari race condition)
            if (empty($request->input('no_rm'))) {
                $pasien->no_rm = 'RM-' . str_pad($pasien->id, 6, '0', STR_PAD_LEFT);
                $pasien->save();
            }

        } catch (\Exception $e) {
            // Handle error, misalnya error unique constraint
            return back()->with('error', 'Gagal menyimpan pasien. Pastikan data unik seperti NIK atau No. RM (jika diisi) belum terdaftar.')->withInput();
        }

        return redirect()->route('pasien.data')->with('success', 'Pasien berhasil ditambahkan dengan No. RM: ' . $pasien->no_rm);
    }

    /**
     * Tampilkan form create pasien.
     */
    public function create()
    {
        return view('pasien.create');
    }

    /**
     * Update data pasien.
     */
    public function update(Request $request, $id)
    {
        // Pindahkan validasi ke Form Request untuk kode yang lebih rapi
        $validated = $request->validate([
            'no_rm' => 'required|string|max:50|unique:pasien,no_rm,' . $id, // Tambahkan ignore $id
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
        ]);

        $p = Pasien::findOrFail($id);
        $p->update($validated);
        return redirect()->route('pasien.data')->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Hapus pasien.
     */
    public function destroy($id)
    {
        $p = Pasien::findOrFail($id);
        
        // Hapus pasien hanya jika tidak ada pendaftaran terkait (preventive)
        if ($p->pendaftarans()->exists()) {
            return back()->with('error', 'Pasien tidak dapat dihapus karena sudah memiliki riwayat pendaftaran/kunjungan.');
        }

        $p->delete();
        return redirect()->route('pasien.data')->with('success', 'Pasien berhasil dihapus.');
    }

    /**
     * Pencarian yang sederhana (untuk route pasien.search)
     */
    public function search(Request $request)
    {
        $q = $request->query('q');
        // Menggunakan Local Scope Filter
        $results = Pasien::filter($q)
                ->limit(50)
                ->get();
                
        return response()->json($results);
        // return view('pasien.pencarian', compact('results', 'q')); // Atau kembalikan JSON jika ini adalah AJAX search
    }
}