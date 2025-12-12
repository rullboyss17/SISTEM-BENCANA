<?php

namespace App\Http\Controllers;

use App\Models\QuickReport;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index()
    {
        $reports = QuickReport::orderBy('created_at', 'desc')->paginate(15);
        return view('laporan_harian.index', compact('reports'));
    }

    public function destroy(QuickReport $quick_report)
    {
        $quick_report->delete();
        return redirect()->route('laporan-harian.index')->with('success', 'Laporan berhasil dihapus!');
    }

    public function notifications()
    {
        $reports = QuickReport::orderBy('created_at', 'desc')
            ->take(5)
            ->get(['id', 'lokasi', 'jumlah_korban', 'created_at']);
        
        return response()->json([
            'count' => QuickReport::count(),
            'reports' => $reports
        ]);
    }
}
