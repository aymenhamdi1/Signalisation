<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PkController extends Controller
{
    public function getPksByRoute(Request $request)
    {
        $request->validate([
            'route' => 'required|string'
        ]);

        $pks = DB::table('pks')
            ->where('rte_nom', $request->route)
            ->orderBy('PK_Num')
            ->get(['PK_Num']);

        return response()->json($pks);
    }
}