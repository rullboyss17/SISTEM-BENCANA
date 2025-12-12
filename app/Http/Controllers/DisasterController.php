<?php

namespace App\Http\Controllers;

use App\Models\Disaster;
use Illuminate\Http\Request;

class DisasterController extends Controller
{
    public function index()
    {
        $bencanas = Disaster::withCount('korbans')->orderBy('tanggal', 'desc')->get();
        return view('bencana.index', compact('bencanas'));
    }

    public function create()
    {
        return view('bencana.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|in:aktif,pemulihan,selesai',
            'jumlah_korban' => 'required|integer|min:0',
        ]);

        Disaster::create($validated);

        return redirect()->route('bencana.index')->with('success', 'Data bencana berhasil ditambahkan');
    }

    public function show(Disaster $bencana)
    {
        return view('bencana.show', compact('bencana'));
    }

    public function edit(Disaster $bencana)
    {
        return view('bencana.edit', compact('bencana'));
    }

    public function update(Request $request, Disaster $bencana)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|in:aktif,pemulihan,selesai',
            'jumlah_korban' => 'required|integer|min:0',
        ]);

        $bencana->update($validated);

        return redirect()->route('bencana.index')->with('success', 'Data bencana berhasil diperbarui');
    }

    public function destroy(Disaster $bencana)
    {
        $bencana->delete();
        return redirect()->route('bencana.index')->with('success', 'Data bencana berhasil dihapus');
    }

    public function latest()
    {
        $bencanas = Disaster::where('status', 'aktif')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get(['id', 'nama', 'lokasi', 'jenis', 'tanggal', 'status']);
        
        return response()->json($bencanas);
    }
}
