<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Events\DashboardStatsUpdated;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    // =================================================================
    // 1. HALAMAN UTAMA (SATU PINTU / PENCARIAN)
    // =================================================================
    public function index(Request $request)
    {
        $query = $request->input('q');
        $pasiens = null;

        // Hanya cari jika ada input query
        if ($query) {
            $pasiens = Pasien::where('no_rm', $query)
                        ->orWhere('nik', $query)
                        ->orWhere('nama', 'like', '%' . $query . '%')
                        ->get();
        }

        // Pastikan Anda sudah membuat view: resources/views/pendaftaran/index.blade.php
        return view('pendaftaran.index', compact('pasiens', 'query'));
    }

    // =================================================================
    // 2. SKENARIO B: FORM PASIEN BARU (Jika tidak ditemukan)
    // =================================================================
    public function createBaru()
    {
        // Kita ubah nama method dari 'pasienBaru' ke 'createBaru' sesuai route
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']); 
        
        // Kita bisa kosongkan pasienData karena ini form baru
        $pasienData = []; 

        // Menggunakan view yang sama (pasien-baru.blade.php)
        return view('pendaftaran.pasien-baru', compact('poliList', 'pasienData'));
    }

    public function storePasienBaru(Request $request)
    {
        // --- LOGIKA INI SAMA PERSIS DENGAN KODE ANDA SEBELUMNYA ---
        // (Hanya saya rapikan sedikit komentarnya)

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|digits:16|unique:pasien,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required|string|max:15',
            'poli' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat No. RM unik baru
            $latestPasien = Pasien::orderBy('id', 'desc')->first();
            $nextRM = $latestPasien ? (int)substr($latestPasien->no_rm, 3) + 1 : 1;
            $noRM = 'RM-' . str_pad($nextRM, 3, '0', STR_PAD_LEFT);

            // 2. Buat data Pasien baru
            $pasien = Pasien::create([
                'nama' => $validated['nama'],
                'nik' => $validated['nik'],
                'no_rm' => $noRM,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'telepon' => $validated['telepon'],
                // Tambahkan alamat jika ada di form: 'alamat' => $request->alamat,
            ]);

            // 3. Buat Pendaftaran
            $noDaftar = 'REG-' . str_pad(Pendaftaran::count() + 1, 3, '0', STR_PAD_LEFT);
            
            Pendaftaran::create([
                'no_daftar' => $noDaftar,
                'pasien_id' => $pasien->id,
                'nama' => $pasien->nama,
                'nik' => $pasien->nik,
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'tanggal_lahir' => $pasien->tanggal_lahir,
                'telepon' => $pasien->telepon,
                'poli' => $validated['poli'] ?? null,
                'status' => 'Terdaftar'
            ]);

            DB::commit();
            $this->updateDashboardStats(); // Helper function di bawah

            return redirect()->route('pendaftaran.list')->with('success', 'Pasien BARU berhasil didaftarkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    // =================================================================
    // 3. SKENARIO A: DAFTAR POLI (Untuk Pasien yang SUDAH ADA)
    // =================================================================
    
    // Menampilkan form pilih poli untuk pasien yang sudah ada
    public function formDaftarPoli($id_pasien)
    {
        $pasien = Pasien::findOrFail($id_pasien);
        $poliList = config('poli.options', ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan']);
        
        // Anda bisa buat view baru 'pendaftaran.daftar-poli' atau reuse modal
        // Disini saya asumsikan kita pakai view sederhana khusus pilih poli
        return view('pendaftaran.daftar-poli', compact('pasien', 'poliList'));
    }

    // Memproses pendaftaran pasien lama
    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'poli' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $pasien = Pasien::findOrFail($request->pasien_id);

            // Cek apakah hari ini sudah mendaftar? (Opsional)
            $cekDouble = Pendaftaran::where('pasien_id', $pasien->id)
                        ->whereDate('created_at', Carbon::today())
                        ->first();
            
            if($cekDouble) {
                return back()->with('error', 'Pasien ini sudah terdaftar hari ini di poli ' . $cekDouble->poli);
            }

            $noDaftar = 'REG-' . str_pad(Pendaftaran::count() + 1, 3, '0', STR_PAD_LEFT);

            Pendaftaran::create([
                'no_daftar' => $noDaftar,
                'pasien_id' => $pasien->id,
                'nama' => $pasien->nama,       // Ambil dari data master pasien
                'nik' => $pasien->nik,         // Ambil dari data master pasien
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'tanggal_lahir' => $pasien->tanggal_lahir,
                'telepon' => $pasien->telepon,
                'poli' => $request->poli,
                'status' => 'Terdaftar'
            ]);

            DB::commit();
            $this->updateDashboardStats();

            return redirect()->route('pendaftaran.list')->with('success', 'Pendaftaran Poli BERHASIL!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
    }

    // =================================================================
    // HELPER & LAINNYA
    // =================================================================

    // Helper untuk update stats real-time
    private function updateDashboardStats() {
        $today = Carbon::today();
        $kunjungan = Pendaftaran::whereDate('created_at', $today)->count();
        $pasienBaru = Pasien::whereDate('created_at', $today)->count();
        $antrean = Pendaftaran::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        event(new DashboardStatsUpdated($kunjungan, $pasienBaru, $antrean));
    }

    public function list()
    {
        $pendaftaran = Pendaftaran::latest()->paginate(20); // Pakai paginate biar ringan
        return view('pendaftaran.list', compact('pendaftaran'));
    }

    public function edit($id)
    {
        $data = Pendaftaran::findOrFail($id);
        return view('pendaftaran.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'poli' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
        ]);

        $p = Pendaftaran::findOrFail($id);
        $p->update($validated);
        $this->updateDashboardStats();

        return redirect()->route('pendaftaran.list')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $p = Pendaftaran::findOrFail($id);
        $p->delete();
        $this->updateDashboardStats();

        return redirect()->route('pendaftaran.list')->with('success', 'Data berhasil dihapus!');
    }

    public function antrianOnline()
    {
        $antrian = Pendaftaran::where('status', 'Terdaftar')
                    ->orWhere('status', 'Dalam Proses') // Sesuaikan status Anda
                    ->latest()
                    ->get();
        return view('pendaftaran.antrian-online', compact('antrian'));
    }

    public function startPemeriksaan($id)
    {
        $p = Pendaftaran::findOrFail($id);
        $p->status = 'Dalam Pemeriksaan';
        $p->save();
        $this->updateDashboardStats();

        return redirect()->route('pemeriksaan.soap', ['id' => $id])->with('success', 'Masuk pemeriksaan');
    }

    public function discharge($id)
    {
        $p = Pendaftaran::findOrFail($id);
        $p->status = 'Pulang';
        $p->save();
        $this->updateDashboardStats();

        return redirect()->route('pendaftaran.list')->with('success', 'Pasien dipulangkan');
    }
}