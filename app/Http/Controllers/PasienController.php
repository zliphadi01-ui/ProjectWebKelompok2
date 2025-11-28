<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function pencarian(Request $request)
    {
        $q = $request->query('q');
        $results = Pasien::filter($q)->limit(20)->get();
        return view('pasien.pencarian', compact('results', 'q'));
    }

    public function cetak(Request $request)
    {
        $no_rm = $request->query('no_rm');
        $pasien = $no_rm ? Pasien::where('no_rm', $no_rm)->first() : null;
        return view('pasien.cetak', compact('pasien'));
    }

    public function index(Request $request)
    {
        $perPage = 15;
        $q = $request->q;
        $pasien = Pasien::filter($q)->orderBy('nama')->paginate($perPage)->withQueryString();
        return view('pasien.data', compact('pasien'));
    }

    public function kontrol(Request $request)
    {
        $pasien = Pasien::orderBy('nama')->limit(25)->get();
        return view('pasien.kontrol', compact('pasien'));
    }

    public function master(Request $request)
    {
        $pasien = Pasien::orderBy('created_at', 'desc')->paginate(20);
        return view('pasien.master', compact('pasien'));
    }

    public function verifikasi(Request $request)
    {
        $pasien = Pasien::orderBy('id', 'desc')->limit(50)->get();
        return view('pasien.verifikasi', compact('pasien'));
    }

    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.show', compact('pasien'));
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rm' => 'nullable|string|max:50|unique:pasien,no_rm',
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
        ]);
        
        if (empty($validated['no_rm'])) {
            unset($validated['no_rm']);
        }
        
        try {
            // Pasien model will handle auto-generation of no_rm in boot()
            $pasien = Pasien::create($validated);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pasien. Pastikan data unik seperti NIK atau No. RM belum terdaftar.')->withInput();
        }

        return redirect()->route('pasien.data')->with('success', 'Pasien berhasil ditambahkan dengan No. RM: ' . $pasien->no_rm);
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_rm' => 'required|string|max:50|unique:pasien,no_rm,' . $id,
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

    public function destroy($id)
    {
        $p = Pasien::findOrFail($id);
        if ($p->pendaftarans()->exists()) {
            return back()->with('error', 'Pasien tidak dapat dihapus karena sudah memiliki riwayat pendaftaran/kunjungan.');
        }
        $p->delete();
        return redirect()->route('pasien.data')->with('success', 'Pasien berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $q = $request->query('q');
        $results = Pasien::filter($q)->limit(50)->get();
        return response()->json($results);
    }
}