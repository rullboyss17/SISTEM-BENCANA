<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KorbanController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\QuickReportController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PoskoController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes - accessible tanpa login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard - untuk guest dan petugas
Route::get('/dashboard', function () {
    if (Auth::check()) {
        // Redirect authenticated users to dashboard with controller
        return redirect('/dashboard-petugas');
    }
    return view('guest-dashboard');
})->name('dashboard')->middleware('web');

// Dashboard Petugas - hanya untuk authenticated
Route::get('/dashboard-petugas', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard-petugas');

// Laporan Cepat - publik bisa akses
Route::get('/quick-report/create', [QuickReportController::class, 'create'])->name('quick-report.create');
Route::post('/quick-report', [QuickReportController::class, 'store'])->name('quick-report.store');

// Laporan Harian - publik bisa lihat list
Route::get('/laporan-harian', [DailyReportController::class, 'index'])->name('laporan-harian.index');
Route::get('/notifications/quick-reports', [DailyReportController::class, 'notifications'])->name('notifications.quick-reports');

// Surat Keterangan - publik bisa akses
Route::get('/surat', function () {
    return view('surat.index');
})->name('surat.index');

// Search route
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

// Protected routes - hanya untuk authenticated users (petugas)
Route::middleware(['auth', 'verified'])->group(function () {
    // Data Korban - hanya petugas
    Route::resource('korban', KorbanController::class);
    
    // Data Bencana - hanya petugas
    Route::get('bencana/latest/json', [DisasterController::class, 'latest'])->name('bencana.latest');
    Route::resource('bencana', DisasterController::class);
    
    // Matching Korban - hanya petugas
    Route::post('matching/confirm', [MatchingController::class, 'confirm'])->name('matching.confirm');
    Route::resource('matching', MatchingController::class);
    
    // Import Data - hanya petugas
    Route::get('import', [App\Http\Controllers\ImportController::class, 'index'])->name('import.index');
    Route::post('import', [App\Http\Controllers\ImportController::class, 'store'])->name('import.store');
    Route::get('disasters/dashboard', function() {
        return redirect()->route('bencana.index');
    })->name('disasters.dashboard');

    // Manajemen Pengguna - hanya petugas
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // Data Posko - hanya petugas
    Route::resource('posko', PoskoController::class);

    // Pengaturan Sistem - hanya petugas
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    
    // Delete laporan harian - hanya petugas
    Route::delete('/laporan-harian/{id}', [DailyReportController::class, 'destroy'])->name('laporan-harian.destroy');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Export Data - hanya petugas
    Route::get('export', [App\Http\Controllers\ExportController::class, 'index'])->name('export.index');
    Route::get('export/disasters.csv', [App\Http\Controllers\ExportController::class, 'disastersCsv'])->name('export.disasters.csv');
    Route::get('export/korban.csv', [App\Http\Controllers\ExportController::class, 'korbanCsv'])->name('export.korban.csv');

    // Bantuan - hanya petugas
    Route::get('help', [App\Http\Controllers\HelpController::class, 'index'])->name('help.index');

    // Cetak Laporan Harian - hanya petugas
    Route::get('/laporan-harian/print', [App\Http\Controllers\ReportsController::class, 'printDaily'])->name('laporan-harian.print');
});

require __DIR__.'/auth.php';
