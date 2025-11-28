<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bed;

class BedController extends Controller
{
    public function index()
    {
        // Admin view for managing beds
        $beds = Bed::orderBy('kelas')->orderBy('nama_kamar')->get();
        return view('beds.index', compact('beds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string',
            'no_bed' => 'required|string',
            'kelas' => 'required',
            'gender' => 'required',
        ]);

        Bed::create($validated);
        return redirect()->back()->with('success', 'Bed berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bed = Bed::findOrFail($id);
        $bed->update($request->all());
        return redirect()->back()->with('success', 'Bed berhasil diupdate');
    }

    public function destroy($id)
    {
        Bed::destroy($id);
        return redirect()->back()->with('success', 'Bed berhasil dihapus');
    }
}
