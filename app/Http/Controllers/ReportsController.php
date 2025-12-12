<?php

namespace App\Http\Controllers;

use App\Models\QuickReport;
use App\Models\Korban;
use App\Models\Disaster;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function printDaily(Request $request)
    {
        // Get date filter (default today)
        $date = $request->get('date', Carbon::today()->toDateString());
        $startDate = Carbon::parse($date)->startOfDay();
        $endDate = Carbon::parse($date)->endOfDay();

        // Get quick reports for the day
        $quickReports = QuickReport::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get victim registrations for the day
        $victims = Korban::whereBetween('created_at', [$startDate, $endDate])
            ->with('disaster')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active disasters
        $disasters = Disaster::where('status', 'aktif')
            ->withCount('korbans')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total_quick_reports' => $quickReports->count(),
            'total_victims' => $victims->count(),
            'total_active_disasters' => $disasters->count(),
            'total_casualties' => $quickReports->sum('jumlah_korban'),
        ];

        return view('reports.print-daily', compact(
            'quickReports',
            'victims',
            'disasters',
            'stats',
            'date'
        ));
    }
}
