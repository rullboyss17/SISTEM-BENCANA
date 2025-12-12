<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Korban;
use App\Models\Disaster;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $korbans = collect();
        $bencanas = collect();

        if ($q !== '') {
            $korbans = Korban::query()
                ->where(function($query) use ($q) {
                    $query->where('nama', 'like', "%$q%")
                          ->orWhere('lokasi', 'like', "%$q%")
                          ->orWhere('status', 'like', "%$q%")
                          ->orWhere('alamat', 'like', "%$q%")
                          ->orWhere('kebutuhan_medis', 'like', "%$q%")
                          ->orWhere('kontak_keluarga', 'like', "%$q%")
                          ->orWhere('keterangan', 'like', "%$q%");
                })
                ->limit(20)
                ->get();

            $bencanas = Disaster::query()
                ->where(function($query) use ($q) {
                    $query->where('nama', 'like', "%$q%")
                          ->orWhere('lokasi', 'like', "%$q%")
                          ->orWhere('jenis', 'like', "%$q%")
                          ->orWhere('status', 'like', "%$q%");
                })
                ->limit(20)
                ->get();
        }

        return view('search.index', compact('q', 'korbans', 'bencanas'));
    }
}
