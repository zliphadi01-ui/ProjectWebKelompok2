<?php

namespace App\Http\Controllers;

use App\Models\RawatInap;
use App\Models\Pasien;
use App\Models\Bed;
use App\Models\Cppt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RawatInapController extends Controller
{
    public function index()
    {
        // Dashboard Rawat Inap: Show Bed Availability
        $beds = Bed::with(['rawatInap.pasien'])->orderBy('kelas')->orderBy('nama_kamar')->get();
        
        // Stats
        $totalBeds = $beds->count();
        $occupied = $beds->where('status', 'occupied')->count();
        $available = $beds->where('status', 'available')->count();

        return view('rawat-inap.index', compact('beds', 'totalBeds', 'occupied', 'available'));
    }

    public function create()
    {
        $pasien = Pasien::orderBy('nama')->limit(200)->get();
        // Only available beds
        $beds = Bed::where('status', 'available')->orderBy('kelas')->get();
        return view('rawat-inap.create', compact('pasien', 'beds'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'bed_id' => 'required|exists:beds,id',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Create Rawat Inap Record
        $ri = new RawatInap();
        $ri->pasien_id = $data['pasien_id'];
        $ri->bed_id = $data['bed_id'];
        $ri->tanggal_masuk = Carbon::now();
        $ri->status = 'Dirawat';
        $ri->diagnosis = $data['diagnosis'];
        $ri->notes = $data['notes'];
        
        // Fill legacy columns just in case
        $bed = Bed::find($data['bed_id']);
        $ri->kamar = $bed->nama_kamar;
        $ri->no_kamar = $bed->no_bed;
        
        $ri->save();

        // Update Bed Status
        $bed->status = 'occupied';
        $bed->save();

        return redirect()->route('rawat-inap.index')->with('success', 'Pasien berhasil dirawat inap');
    }

    public function show($id)
    {
        $item = RawatInap::with(['pasien', 'bed', 'cppt.dokter'])->findOrFail($id);
        return view('rawat-inap.show', compact('item'));
    }

    public function storeCppt(Request $request, $id)
    {
        $ri = RawatInap::findOrFail($id);
        
        $validated = $request->validate([
            'subjective' => 'required|string',
            'objective' => 'required|string',
            'assessment' => 'required|string',
            'plan' => 'required|string',
            'instruksi_ppa' => 'nullable|string',
        ]);

        $cppt = new Cppt($validated);
        $cppt->rawat_inap_id = $ri->id;
        $cppt->dokter_id = Auth::id();
        $cppt->tanggal = Carbon::now();
        $cppt->save();

        return redirect()->back()->with('success', 'CPPT berhasil ditambahkan');
    }

    public function discharge(Request $request, $id)
    {
        $ri = RawatInap::findOrFail($id);
        $ri->status = 'Pulang';
        $ri->tanggal_keluar = Carbon::now();
        $ri->save();

        // Free up bed
        if ($ri->bed) {
            $ri->bed->status = 'available';
            $ri->bed->save();
        }

        return redirect()->route('rawat-inap.index')->with('success', 'Pasien berhasil dipulangkan');
    }
}
