<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disaster;
use App\Models\Korban;
use App\Models\KorbanDitemukan;
use App\Models\KorbanHilang;

class DashboardController extends Controller
{
    public function publicDashboard()
    {
        // Redirect authenticated users to full dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard-petugas');
        }

        // Statistics for public
        $totalBencana = Disaster::count();
        $bencanaBaru = Disaster::where('tanggal', '>=', now()->subDays(7))->count();
        
        $totalKorban = Korban::count();
        $korbanBaru = Korban::where('created_at', '>=', now()->subDay())->count();
        $korbanDitemukan = Korban::where('status', 'ditemukan')->count();
        $korbanHilang = Korban::where('status', 'hilang')->count();
        $korbanTerselamatkan = Korban::where('status', 'selamat')->count();
        $persenTerselamatkan = $totalKorban ? round($korbanTerselamatkan / $totalKorban * 100) . '%' : '0%';
        $persenHilang = $totalKorban ? round($korbanHilang / $totalKorban * 100) . '%' : '0%';
        $persenDitemukan = $totalKorban ? round($korbanDitemukan / $totalKorban * 100) . '%' : '0%';

        $kasusKritis = Korban::where('prioritas_medis', 'tinggi')->count();
        $kasusKritisTurun = 0;

        // Recent disasters
        $bencanaTerbaru = Disaster::orderBy('tanggal', 'desc')->take(5)->get();
        
        // Priority cases
        $prioritasTinggi = Korban::where('prioritas_medis', 'tinggi')->take(10)->get();

        return view('guest-dashboard', compact(
            'totalBencana', 'bencanaBaru',
            'totalKorban', 'korbanBaru', 'korbanDitemukan', 'korbanHilang', 'korbanTerselamatkan',
            'persenTerselamatkan', 'persenHilang', 'persenDitemukan',
            'kasusKritis', 'kasusKritisTurun',
            'bencanaTerbaru', 'prioritasTinggi'
        ));
    }

    public function index()
    {
        // Statistics
        $totalBencana = Disaster::count();
        $bencanaBaru = Disaster::where('tanggal', '>=', now()->subDays(7))->count();
        $bencanaStatus = Disaster::where('status', 'aktif')->count() . ' sedang berlangsung, ' . Disaster::where('status', 'pemulihan')->count() . ' dalam pemulihan';

        $totalKorban = Korban::count();
        $korbanBaru = Korban::where('created_at', '>=', now()->subDay())->count();
        $korbanDitemukan = Korban::where('status', 'ditemukan')->count();
        $korbanHilang = Korban::where('status', 'hilang')->count();
        $korbanTerselamatkan = Korban::where('status', 'selamat')->count();
        $persenTerselamatkan = $totalKorban ? round($korbanTerselamatkan / $totalKorban * 100) . '%' : '0%';
        $persenHilang = $totalKorban ? round($korbanHilang / $totalKorban * 100) . '%' : '0%';
        $persenDitemukan = $totalKorban ? round($korbanDitemukan / $totalKorban * 100) . '%' : '0%';

        $kasusKritis = Korban::where('prioritas_medis', 'tinggi')->count();
        $kasusKritisTurun = 0; // Implement logic for decrease if needed

        // Recent disasters
        $bencanaTerbaru = Disaster::orderBy('tanggal', 'desc')->take(5)->get();
        $bencanaAktif = Disaster::where('status', 'aktif')->orderBy('tanggal', 'desc')->first()
            ?? Disaster::orderBy('tanggal', 'desc')->first();

        // Priority cases
        $prioritasTinggi = Korban::where('prioritas_medis', 'tinggi')->take(10)->get();

        return view('dashboard', compact(
            'totalBencana', 'bencanaBaru', 'bencanaStatus',
            'totalKorban', 'korbanBaru', 'korbanDitemukan', 'korbanHilang', 'korbanTerselamatkan',
            'persenTerselamatkan', 'persenHilang', 'persenDitemukan',
            'kasusKritis', 'kasusKritisTurun',
            'bencanaTerbaru', 'bencanaAktif', 'prioritasTinggi'
        ));
    }
}
