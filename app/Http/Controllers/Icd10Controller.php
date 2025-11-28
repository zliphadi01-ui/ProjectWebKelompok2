<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Icd10Code;

class Icd10Controller extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([]);
        }

        $results = Icd10Code::where('code', 'like', "%{$query}%")
                            ->orWhere('name', 'like', "%{$query}%")
                            ->limit(10)
                            ->get();

        return response()->json($results);
    }
}
