<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Korban;
use App\Models\Disaster;
use Barryvdh\DomPDF\Facade\Pdf;

class KorbanController extends Controller
{
    public function create()
    {
        $disasters = Disaster::all();
        return view('korban.create', compact('disasters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'usia' => 'nullable|integer|min:0',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'required|in:hilang,ditemukan,meninggal,selamat',
            'kebutuhan_medis' => 'nullable|string|max:255',
            'prioritas_medis' => 'required|in:tinggi,sedang,rendah',
            'status_medis' => 'nullable|string|max:255',
            'kontak_keluarga' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'disaster_id' => 'nullable|integer',
        ]);

        // Beri nama otomatis jika kosong agar sesuai kolom non-nullable.
        if (empty($validated['nama'])) {
            $validated['nama'] = 'Korban-' . strtoupper(uniqid());
        }

        Korban::create($validated);

        return redirect()->route('korban.index')->with('success', 'Data korban berhasil ditambahkan');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = request('q');
        $korbans = Korban::query();
        if ($query) {
            $korbans = $korbans->where(function($q) use ($query) {
                $q->where('nama', 'like', "%$query%")
                  ->orWhere('lokasi', 'like', "%$query%")
                  ->orWhere('status', 'like', "%$query%")
                  ->orWhere('alamat', 'like', "%$query%")
                  ->orWhere('kebutuhan_medis', 'like', "%$query%")
                  ->orWhere('kontak_keluarga', 'like', "%$query%")
                  ->orWhere('keterangan', 'like', "%$query%");
            });
        }
        $korbans = $korbans->get();
        return view('korban.index', compact('korbans'));
    }

    public function show(Korban $korban)
    {
        return view('korban.show', compact('korban'));
    }

    public function edit(Korban $korban)
    {
        $disasters = Disaster::all();
        return view('korban.edit', compact('korban', 'disasters'));
    }

    public function update(Request $request, Korban $korban)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'usia' => 'nullable|integer|min:0',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'required|in:hilang,ditemukan,meninggal,selamat',
            'kebutuhan_medis' => 'nullable|string|max:255',
            'prioritas_medis' => 'required|in:tinggi,sedang,rendah',
            'status_medis' => 'nullable|string|max:255',
            'kontak_keluarga' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'disaster_id' => 'nullable|integer',
        ]);

        if (empty($validated['nama'])) {
            $validated['nama'] = 'Korban-' . strtoupper(uniqid());
        }

        $korban->update($validated);

        return redirect()->route('korban.index')->with('success', 'Data korban berhasil diperbarui');
    }

    public function destroy(Korban $korban)
    {
        $korban->delete();
        return redirect()->route('korban.index')->with('success', 'Data korban berhasil dihapus');
    }

    // Surat generation removed per request
}
