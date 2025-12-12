<?php

namespace App\Http\Controllers;

use App\Models\QuickReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuickReportController extends Controller
{
    public function create()
    {
        return view('quick_report.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto' => ['required','image','max:4096'],
            'jumlah_korban' => ['required','integer','min:0'],
            'lokasi' => ['required','string','max:255'],
            'waktu' => ['nullable','date_format:Y-m-d\TH:i'],
            'keterangan' => ['nullable','string','max:2000'],
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $filename = Str::uuid().'.'.$request->file('foto')->getClientOriginalExtension();
            $path = $request->file('foto')->storeAs('quick-reports', $filename, 'public');
        }

        // Parse waktu dari datetime-local format dengan timezone Asia/Jakarta
        $waktu = null;
        if (!empty($validated['waktu'])) {
            $waktu = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['waktu'], 'Asia/Jakarta');
        } else {
            $waktu = now('Asia/Jakarta');
        }

        // Persist to database
        QuickReport::create([
            'foto_path' => $path,
            'jumlah_korban' => $validated['jumlah_korban'],
            'lokasi' => $validated['lokasi'],
            'waktu' => $waktu,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('quick-report.create')
            ->with('success', 'Laporan cepat berhasil dikirim!');
    }
}
