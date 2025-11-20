<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    // halaman pencarian kartu
    public function pencarian(Request $request)
    {
        $q = $request->query('q');
        $results = collect();
        if ($q) {
            $results = Pasien::where('nama', 'like', "%{$q}%")
                ->orWhere('no_rm', 'like', "%{$q}%")
                ->orWhere('nik', 'like', "%{$q}%")
                ->limit(20)
                ->get();
        }
        return view('pasien.pencarian', compact('results', 'q'));
    }

    // halaman cetak (tampilan sederhana)
    public function cetak(Request $request)
    {
        $no_rm = $request->query('no_rm');
        $pasien = $no_rm ? Pasien::where('no_rm', $no_rm)->first() : null;
        return view('pasien.cetak', compact('pasien'));
    }

    // daftar data pasien (index)
    public function index(Request $request)
    {
        $perPage = 15;
        $query = Pasien::query();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama', 'like', "%{$q}%")->orWhere('no_rm', 'like', "%{$q}%");
        }
        $pasien = $query->orderBy('nama')->paginate($perPage)->withQueryString();
        return view('pasien.data', compact('pasien'));
    }

    // halaman kontrol pasien (contoh: melihat ringkasan kontrol)
    public function kontrol(Request $request)
    {
        // untuk prototipe ini kita tampilkan daftar singkat pasien untuk dipilih kontrol
        $pasien = Pasien::orderBy('nama')->limit(25)->get();
        return view('pasien.kontrol', compact('pasien'));
    }

    // master pasien (halaman manajemen)
    public function master(Request $request)
    {
        $pasien = Pasien::orderBy('created_at', 'desc')->paginate(20);
        return view('pasien.master', compact('pasien'));
    }

    // verifikasi pasien (contoh halaman)
    public function verifikasi(Request $request)
    {
        // contoh: ambil pasien terakhir untuk verifikasi
        $pasien = Pasien::orderBy('id', 'desc')->limit(50)->get();
        return view('pasien.verifikasi', compact('pasien'));
    }

    // Tampilkan form edit pasien (stub aman)
    // Untuk sekarang kita arahkan kembali ke daftar pasien dengan pesan info agar tidak memunculkan error view
    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.show', compact('pasien'));
    }

    // Tampilkan form edit pasien
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    // Simpan pasien baru (dipanggil dari form jika ada)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rm' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
        ]);

        // Pastikan no_rm tidak null karena kolom di DB mungkin tidak mengizinkan NULL.
        if (empty($validated['no_rm'])) {
            // Buat nomor rekam medis otomatis: RM-000001, RM-000002, dst.
            $next = (int) Pasien::max('id') + 1;
            $validated['no_rm'] = 'RM-' . str_pad($next, 6, '0', STR_PAD_LEFT);
        }

        Pasien::create($validated);
        return redirect()->route('pasien.data')->with('success', 'Pasien berhasil ditambahkan.');
    }

    // Tampilkan form create pasien
    public function create()
    {
        return view('pasien.create');
    }

    // Update data pasien
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_rm' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
        ]);

        $p = Pasien::findOrFail($id);
        $p->update($validated);
        return redirect()->route('pasien.data')->with('success', 'Data pasien berhasil diperbarui.');
    }

    // Hapus pasien
    public function destroy($id)
    {
        $p = Pasien::findOrFail($id);
        $p->delete();
        return redirect()->route('pasien.data')->with('success', 'Pasien berhasil dihapus.');
    }

    // Pencarian yang sederhana (untuk route pasien.search)
    public function search(Request $request)
    {
        $q = $request->query('q');
        $results = collect();
        if ($q) {
            $results = Pasien::where('nama', 'like', "%{$q}%")
                ->orWhere('no_rm', 'like', "%{$q}%")
                ->limit(50)
                ->get();
        }
        return view('pasien.pencarian', compact('results', 'q'));
    }

    // store, show, update, destroy sudah ada di routes; jika diperlukan tambahkan implementasinya
}
