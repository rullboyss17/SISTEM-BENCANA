<?php

namespace App\Http\Controllers;

use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PoskoController extends Controller
{
    public function index()
    {
        $poskos = Posko::orderByDesc('created_at')->paginate(10);

        $totalKapasitas = Posko::sum('kapasitas');
        $totalTerisi = Posko::sum('terisi');

        $summary = [
            'total_posko' => Posko::count(),
            'total_kapasitas' => $totalKapasitas,
            'total_terisi' => $totalTerisi,
            'sisa_kapasitas' => $totalKapasitas - $totalTerisi,
            'aktif' => Posko::where('status', 'Aktif')->count(),
        ];

        return view('posko.index', compact('poskos', 'summary'));
    }

    public function create()
    {
        return view('posko.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Posko::create($data);

        return redirect()->route('posko.index')->with('success', 'Posko berhasil ditambahkan.');
    }

    public function edit(Posko $posko)
    {
        return view('posko.edit', compact('posko'));
    }

    public function update(Request $request, Posko $posko)
    {
        $data = $this->validatedData($request, $posko->kapasitas);
        $posko->update($data);

        return redirect()->route('posko.index')->with('success', 'Posko berhasil diperbarui.');
    }

    public function destroy(Posko $posko)
    {
        $posko->delete();

        return redirect()->route('posko.index')->with('success', 'Posko berhasil dihapus.');
    }

    private function validatedData(Request $request, $kapasitasLama = null): array
    {
        $kapasitasRule = ['required', 'integer', 'min:0'];

        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'kapasitas' => $kapasitasRule,
            'terisi' => ['nullable', 'integer', 'min:0', 'lte:kapasitas'],
            'kontak' => ['nullable', 'string', 'max:255'],
            'petugas' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'string'],
        ]);
    }
}
