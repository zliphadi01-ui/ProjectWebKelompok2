<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $pasiens = null;

        if ($query) {
            $pasiens = Pasien::where(function ($q) use ($query) {
                $q->where('no_rm', 'like', "%$query%")
                  ->orWhere('nik', 'like', "%$query%")
                  ->orWhere('nama', 'like', "%$query%");
            })->limit(20)->get();
        }

        $pendaftaran = Pendaftaran::with('pasien')
                        ->whereDate('created_at', Carbon::today())
                        ->latest()
                        ->get();

        return view('pendaftaran.index', compact('pasiens', 'query', 'pendaftaran'));
    }

    public function createBaru()
    {
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']);
        $pasienData = Pasien::select('id', 'nama', 'no_rm', 'nik', 'tanggal_lahir')
                            ->latest()
                            ->limit(100)
                            ->get();

        return view('pendaftaran.pasien-baru', compact('poliList', 'pasienData'));
    }

    public function storePasienBaru(Request $request)
    {
    $request->validate([
    'nama' => 'required|string|max:255',
    'nik' => 'required|digits:16|unique:pasien,nik',
    'jenis_kelamin' => 'required|in:L,P',
    'tanggal_lahir' => 'required|date|before:today',
    'telepon' => 'nullable|regex:/^[0-9]{10,13}$/',
    'email' => 'nullable|email',
    'poli' => 'required',
    ]);

        DB::beginTransaction();
        try {
            // Pasien model will handle auto-generation of no_rm in boot()
            $pasien = Pasien::updateOrCreate(
                ['nik' => $request->nik],
                [
                    'nama' => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'telepon' => $request->telepon,
                    'email' => $request->email,
                    'alamat' => $request->alamat ?? '-',
                ]
            );

            Pendaftaran::create([
                'no_daftar' => 'REG-' . time(),
                'pasien_id' => $pasien->id,
                'nama' => $pasien->nama,
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'nik' => $pasien->nik,
                'poli' => $request->poli,
                'status' => 'Menunggu',
            ]);

            DB::commit();

            return redirect()->route('pendaftaran.index')
                             ->with('success', 'Berhasil Mendaftarkan Pasien: ' . $pasien->nama . '. Silakan lanjut ke menu Pemeriksaan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', "GAGAL MENYIMPAN: " . $e->getMessage())->withInput();
        }
    }

    public function formDaftarPoli($id)
    {
        $pasien = Pasien::findOrFail($id);
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']);
        
        return view('pendaftaran.daftar-poli', compact('pasien', 'poliList'));
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:pasien,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date|before:today',
            'telepon' => 'nullable|regex:/^[0-9]{10,13}$/',
            'email' => 'nullable|email',
            'poli' => 'required',
        ]);

        $pasien = Pasien::find($request->pasien_id);

        Pendaftaran::create([
            'no_daftar' => 'REG-' . time(),
            'pasien_id' => $pasien->id,
            'nama' => $pasien->nama,
            'jenis_kelamin' => $pasien->jenis_kelamin,
            'nik' => $pasien->nik,
            'poli' => $request->poli,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('pendaftaran.index')
                         ->with('success', 'Pendaftaran Poli Berhasil!');
    }

    public function list()
    {
        $pendaftaran = Pendaftaran::with('pasien')->latest()->paginate(10);
        return view('pendaftaran.list', compact('pendaftaran'));
    }

    public function destroy($id)
    {
        Pendaftaran::destroy($id);
        return back()->with('success', 'Data dihapus');
    }

    public function antrianOnline() { return view('pendaftaran.antrian-online'); }
    public function edit($id) { return back(); }
    public function update(Request $request, $id) { return back(); }
    public function startPemeriksaan($id) { return back(); }
    public function discharge($id) { return back(); }
}