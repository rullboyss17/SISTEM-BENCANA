@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-question-circle me-2"></i> Bantuan
                </div>
                <div class="card-body">
                    <p>Selamat datang di halaman bantuan. Berikut panduan singkat:</p>
                    <ul>
                        <li>Gunakan menu "Data Korban" untuk mengelola data korban.</li>
                        <li>Gunakan menu "Data Bencana" untuk mengelola data bencana.</li>
                        <li>Menu "Laporan Harian" menampilkan laporan yang masuk.</li>
                        <li>Halaman "Export Data" menyediakan unduhan CSV untuk analisis.</li>
                    </ul>
                    <p class="mb-0">Butuh bantuan lebih lanjut? Hubungi admin sistem atau lihat dokumentasi internal.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
