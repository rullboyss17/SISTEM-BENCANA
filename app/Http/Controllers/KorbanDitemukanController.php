<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KorbanDitemukan;
use Illuminate\Support\Facades\Storage;

class KorbanDitemukanController extends Controller
{
    public function create()
    {
        return view('korban_ditemukan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status_korban' => 'required',
            'nama' => 'nullable|string',
            'ciri_fisik' => 'required|string',
            'barang_bawaan' => 'nullable|string',
            'foto' => 'nullable|image|max:4096',
            'gps_lokasi' => 'required|string',
            'posko_rujukan' => 'required|string',
        ]);

        // Auto-generate name if not provided
        if (empty($validated['nama'])) {
            $last = KorbanDitemukan::where('nama', 'like', 'Korban-X-%')->count() + 1;
            $validated['nama'] = 'Korban-X-' . str_pad($last, 3, '0', STR_PAD_LEFT);
        }

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/foto_korban');
            $validated['foto'] = basename($path);
        }

        KorbanDitemukan::create($validated);

        return redirect()->route('korban_ditemukan.create')->with('success', 'Data korban ditemukan berhasil disimpan.');
    }
}
