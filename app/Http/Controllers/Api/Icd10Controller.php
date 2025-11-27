<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Icd10Code;

class Icd10Controller extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $codes = Icd10Code::where('code', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        return response()->json($codes);
    }
}
