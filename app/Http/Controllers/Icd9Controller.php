<?php

namespace App\Http\Controllers;

use App\Models\Icd9Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Icd9Controller extends Controller
{
    // =================================================================
    // MASTER DATA MANAGEMENT (CRUD)
    // =================================================================
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        $procedures = Icd9Procedure::when($query, function ($q) use ($query) {
            $q->where('code', 'like', "%$query%")
              ->orWhere('name', 'like', "%$query%");
        })->orderBy('code')->paginate(20);

        return view('master-data.icd9.index', compact('procedures', 'query'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:icd9_procedures,code',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal menambah data.');
        }

        Icd9Procedure::create($request->only('code', 'name'));

        return back()->with('success', 'Data ICD-9 berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $procedure = Icd9Procedure::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:icd9_procedures,code,' . $id,
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal update data.');
        }

        $procedure->update($request->only('code', 'name'));

        return back()->with('success', 'Data ICD-9 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Icd9Procedure::destroy($id);
        return back()->with('success', 'Data ICD-9 berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $data = array_map('str_getcsv', file($path));
        
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
                        Icd9Procedure::updateOrCreate(
                            ['code' => $code],
                            ['name' => $name]
                        );
                        $count++;
                    }
                }
            }
            DB::commit();
            return back()->with('success', "Berhasil mengimpor $count data ICD-9.");
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

        $results = Icd9Procedure::where('code', 'like', "%{$query}%")
                            ->orWhere('name', 'like', "%{$query}%")
                            ->limit(10)
                            ->get();

        return response()->json($results);
    }
}
