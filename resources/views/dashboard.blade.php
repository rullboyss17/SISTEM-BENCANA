@extends('layouts.app')

@section('content')

<div class="container-fluid px-0">

    {{-- Banner dihapus: sudah ditampilkan di layout utama --}}

    {{-- ===================== STATISTIK ===================== --}}
    <div class="row mb-4">
        {{-- TOTAL BENCANA --}}
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-label">TOTAL BENCANA</div>
                        <div class="stats-number text-dark">{{ $totalBencana }}</div>
                    </div>
                    <div class="stats-icon-container bg-primary-subtle text-primary">
                        <i class="fas fa-mountain"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL KORBAN --}}
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-label">TOTAL KORBAN</div>
                        <div class="stats-number text-dark">{{ $totalKorban }}</div>
                    </div>
                    <div class="stats-icon-container bg-warning-subtle text-warning">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- KRITIS --}}
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-label">KASUS KRITIS</div>
                        <div class="stats-number text-dark">{{ $kasusKritis }}</div>
                    </div>
                    <div class="stats-icon-container bg-danger-subtle text-danger">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TERSELAMATKAN --}}
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-label">TERSELAMATKAN</div>
                        <div class="stats-number text-dark">{{ $korbanTerselamatkan }}</div>
                    </div>
                    <div class="stats-icon-container bg-success-subtle text-success">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        {{-- ===================== TABEL BENCANA TERBARU ===================== --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 disaster-table-card">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fas fa-hurricane me-2 text-primary"></i>
                    <span class="fw-bold">Bencana Terbaru</span>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Bencana</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bencanaTerbaru as $bencana)
                            <tr>
                                <td>{{ $bencana->nama }}</td>
                                <td>{{ $bencana->jenis }}</td>
                                <td>{{ $bencana->lokasi }}</td>
                                <td>
                                    @switch($bencana->status)
                                        @case('aktif')<span class="badge bg-danger">Aktif</span>@break
                                        @case('pemulihan')<span class="badge bg-warning text-dark">Pemulihan</span>@break
                                        @default <span class="badge bg-secondary">Selesai</span>
                                    @endswitch
                                </td>
                                <td>{{ $bencana->tanggal }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data bencana.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ===================== PANEL AKSI CEPAT ===================== --}}
            <div class="row mt-4">
                <div class="col-md-3 mb-2">
                    <a href="{{ route('korban.create') }}" class="btn btn-secondary w-100 quick-button text-white">
                        <i class="fas fa-user-plus fa-lg mb-1"></i>
                        Tambah Korban
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('matching.index') }}" class="btn btn-secondary w-100 quick-button text-white">
                        <i class="fas fa-exchange-alt fa-lg mb-1"></i>
                        Matching
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('korban.index') }}" class="btn btn-secondary w-100 quick-button text-white">
                        <i class="fas fa-file-medical fa-lg mb-1"></i>
                        Laporan
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('surat.index') }}" class="btn btn-secondary w-100 quick-button text-white">
                        <i class="fas fa-file-contract fa-lg mb-1"></i>
                        Surat
                    </a>
                </div>
            </div>

            {{-- ===================== PRIORITAS TINGGI ===================== --}}
            <div class="card shadow-sm border-0 mt-4 priority-card">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <span class="fw-bold">Kasus Prioritas Tinggi</span>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Korban</th>
                                <th>Usia</th>
                                <th>Jenis Kelamin</th>
                                <th>Lokasi</th>
                                <th>Status Medis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prioritasTinggi as $korban)
                            <tr>
                                <td>{{ $korban->nama }}</td>
                                <td>{{ $korban->usia ?? '-' }}</td>
                                <td>{{ $korban->jenis_kelamin }}</td>
                                <td>{{ $korban->lokasi ?? '-' }}</td>
                                <td>
                                    @switch($korban->prioritas_medis)
                                        @case('tinggi')<span class="badge bg-danger">Tinggi</span>@break
                                        @case('sedang')<span class="badge bg-warning text-dark">Sedang</span>@break
                                        @default <span class="badge bg-success">Rendah</span>
                                    @endswitch
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data prioritas tinggi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        {{-- ===================== PROGRESS + KONTAK DARURAT ===================== --}}
        <div class="col-lg-4 mb-4">

            {{-- PROGRESS CHART --}}
            <div class="card shadow-sm border-0 progress-chart-card mb-4">
                <div class="card-header bg-white">
                    <span class="fw-bold"><i class="fas fa-chart-pie text-info me-2"></i>Status Korban</span>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Korban Hilang</span>
                            <span class="fw-bold text-dark">{{ $korbanHilang }} ({{ $persenHilang }})</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width:{{ $persenHilang }}"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Korban Ditemukan</span>
                            <span class="fw-bold text-dark">{{ $korbanDitemukan }} ({{ $persenDitemukan }})</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width:{{ $persenDitemukan }}"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Korban Terselamatkan</span>
                            <span class="fw-bold text-dark">{{ $korbanTerselamatkan }} ({{ $persenTerselamatkan }})</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width:{{ $persenTerselamatkan }}"></div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- KONTAK DARURAT --}}
            <div class="card shadow-sm border-0 emergency-contact-card">
                <div class="card-header bg-white">
                    <span class="fw-bold"><i class="fas fa-phone-alt text-danger me-2"></i>Kontak Darurat</span>
                </div>

                <div class="card-body">

                    <div class="mb-3 d-flex align-items-center">
                        <i class="fas fa-phone-volume text-danger me-3"></i>
                        <div>
                            <div class="fw-bold">BNPB Call Center</div>
                            <div class="h5 mb-0">117</div>
                            <small class="text-muted">Badan Nasional Penanggulangan Bencana</small>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <i class="fas fa-ambulance text-warning me-3"></i>
                        <div>
                            <div class="fw-bold">Ambulans Darurat</div>
                            <div class="h5 mb-0">119</div>
                            <small class="text-muted">Layanan gawat darurat 24 jam</small>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <i class="fas fa-shield-alt text-primary me-3"></i>
                        <div>
                            <div class="fw-bold">Polisi & SAR</div>
                            <div class="h5 mb-0">110</div>
                            <small class="text-muted">Kepolisian & Tim SAR</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>


{{-- ===================== JAVASCRIPT ===================== --}}
@push('scripts')
<script>
(() => {
    const bannerText = document.getElementById('banner-text');
    if (!bannerText) return;

    let items = @json($bencanaTerbaru->map(fn($b) => [
        'id' => $b->id,
        'text' => $b->nama . ' - ' . $b->lokasi
    ]));

    const show = (item) => {
        bannerText.classList.add('opacity-0');
        setTimeout(() => {
            bannerText.textContent = item.text;
            bannerText.classList.remove('opacity-0');
        }, 250);
    };

    let idx = 0;

    if (items.length) show(items[idx]);

    setInterval(() => {
        if (items.length > 1) {
            idx = (idx + 1) % items.length;
            show(items[idx]);
        }
    }, 4500);
})();
</script>
@endpush

@endsection
