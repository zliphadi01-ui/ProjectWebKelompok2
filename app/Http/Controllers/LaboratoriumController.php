<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabRequest;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class LaboratoriumController extends Controller
{
    public function index()
    {
        // Get stats
        $total = LabRequest::count();
        $completed = LabRequest::where('status', 'completed')->count();
        $pending = LabRequest::where('status', 'requested')->orWhere('status', 'processing')->count();

        // Get list
        $requests = LabRequest::with(['pasien', 'dokter'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('pages.laboratorium', compact('total', 'completed', 'pending', 'requests'));
    }

    public function create()
    {
        // For simplicity, we might just show a modal in index, but let's have a page if needed
        // Or we can pass patient data if created from SOAP
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'pendaftaran_id' => 'nullable|exists:pendaftarans,id',
            'jenis_pemeriksaan' => 'required|array',
            'catatan' => 'nullable|string',
        ]);

        $labRequest = new LabRequest();
        $labRequest->pasien_id = $validated['pasien_id'];
        $labRequest->pendaftaran_id = $validated['pendaftaran_id'] ?? null;
        $labRequest->dokter_id = Auth::id(); // Assuming logged in user is doctor
        $labRequest->jenis_pemeriksaan = $validated['jenis_pemeriksaan'];
        $labRequest->catatan = $validated['catatan'] ?? '';
        $labRequest->status = 'requested';
        $labRequest->save();

        return redirect()->back()->with('success', 'Permintaan Laboratorium berhasil dibuat.');
    }

    public function updateStatus(Request $request, $id)
    {
        $labRequest = LabRequest::findOrFail($id);
        
        if ($request->has('status')) {
            $labRequest->status = $request->status;
        }
        
        if ($request->has('hasil')) {
            $labRequest->hasil = $request->hasil;
            $labRequest->status = 'completed';
        }

        $labRequest->save();

        return redirect()->back()->with('success', 'Status Laboratorium diperbarui.');
    }
}
