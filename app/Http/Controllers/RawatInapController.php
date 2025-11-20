<?php

namespace App\Http\Controllers;

use App\Models\RawatInap;
use App\Models\Pasien;
use Illuminate\Http\Request;

class RawatInapController extends Controller
{
    public function index()
    {
        $items = RawatInap::with('pasien')->orderBy('tanggal_masuk', 'desc')->paginate(15);
        return view('rawat-inap.index', compact('items'));
    }

    public function create()
    {
        $pasien = Pasien::orderBy('nama')->limit(200)->get();
        return view('rawat-inap.create', compact('pasien'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pasien_id' => 'nullable|exists:pasien,id',
            'kamar' => 'nullable|string|max:255',
            'no_kamar' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data['status'] = $request->input('status', 'Dirawat');

        RawatInap::create($data);
        return redirect()->route('rawat-inap.index')->with('success', 'Rawat inap berhasil dibuat');
    }

    public function show($id)
    {
        $item = RawatInap::with('pasien')->findOrFail($id);
        return view('rawat-inap.show', compact('item'));
    }

    public function edit($id)
    {
        $item = RawatInap::findOrFail($id);
        $pasien = Pasien::orderBy('nama')->limit(200)->get();
        return view('rawat-inap.edit', compact('item', 'pasien'));
    }

    public function update(Request $request, $id)
    {
        $item = RawatInap::findOrFail($id);
        $data = $request->validate([
            'pasien_id' => 'nullable|exists:pasien,id',
            'kamar' => 'nullable|string|max:255',
            'no_kamar' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $item->update($data);
        return redirect()->route('rawat-inap.index')->with('success', 'Rawat inap diperbarui');
    }

    public function destroy($id)
    {
        $item = RawatInap::findOrFail($id);
        $item->delete();
        return redirect()->route('rawat-inap.index')->with('success', 'Rawat inap dihapus');
    }
}
