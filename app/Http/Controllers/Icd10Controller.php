<?php

namespace App\Http\Controllers;

use App\Models\Icd10Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Icd10Controller extends Controller
{
    // =================================================================
    // MASTER DATA MANAGEMENT (CRUD)
    // =================================================================
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        $codes = Icd10Code::when($query, function ($q) use ($query) {
            $q->where('code', 'like', "%$query%")
              ->orWhere('name', 'like', "%$query%");
        })->orderBy('code')->paginate(20);

        return view('master-data.icd10.index', compact('codes', 'query'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:icd10_codes,code',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal menambah data. Cek inputan Anda.');
        }

        Icd10Code::create($request->only('code', 'name'));

        return back()->with('success', 'Data ICD-10 berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $code = Icd10Code::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:icd10_codes,code,' . $id,
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal update data.');
        }

        $code->update($request->only('code', 'name'));

        return back()->with('success', 'Data ICD-10 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Icd10Code::destroy($id);
        return back()->with('success', 'Data ICD-10 berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        // Membaca file CSV
        $data = array_map('str_getcsv', file($path));
        
        // Hapus header jika ada
        if (count($data) > 0) {
            if (isset($data[0][0]) && (strtolower($data[0][0]) == 'code' || strtolower($data[0][0]) == 'kode')) {
                array_shift($data);
            }
        }

        if (count($data) == 0) {
            return back()->with('error', 'File CSV kosong atau format salah.');
        }

        DB::beginTransaction();
        try {
            $count = 0;
            foreach ($data as $row) {
                if (count($row) >= 2) {
                    $code = trim($row[0]);
                    $name = trim($row[1]);

                    if (!empty($code) && !empty($name)) {
                        Icd10Code::updateOrCreate(
                            ['code' => $code],
                            ['name' => $name]
                        );
                        $count++;
                    }
                }
            }
            DB::commit();
            return back()->with('success', "Berhasil mengimpor $count data ICD-10.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
        }
    }

    // =================================================================
    // API SEARCH (For Auto-complete)
    // =================================================================
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([]);
        }

        $results = Icd10Code::where('code', 'like', "%{$query}%")
                            ->orWhere('name', 'like', "%{$query}%")
                            ->orWhere('keywords', 'like', "%{$query}%") // Cari di keywords juga
                            ->limit(20) // Naikkan limit biar lebih banyak opsi
                            ->get();

        return response()->json($results);
    }
}
