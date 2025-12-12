<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page-break { page-break-after: always; }
        }
        body { font-family: 'Times New Roman', serif; }
        .header-logo { border-bottom: 3px solid #000; padding-bottom: 1rem; margin-bottom: 1.5rem; }
        .signature-box { margin-top: 3rem; }
        table { font-size: 0.9rem; }
        .badge { padding: 0.35em 0.65em; }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Print Button -->
        <div class="no-print mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('laporan-harian.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <button class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak Laporan
            </button>
        </div>

        <!-- Report Header -->
        <div class="header-logo text-center">
            <h4 class="fw-bold mb-1">BADAN NASIONAL PENANGGULANGAN BENCANA</h4>
            <h5 class="mb-1">SISTEM PENDATAAN KORBAN BENCANA (SIPENKORBAN)</h5>
            <p class="mb-0 text-muted">Jl. Pramuka No. 38, Jakarta Timur 13120</p>
        </div>

        <!-- Report Title -->
        <div class="text-center mb-4">
            <h5 class="fw-bold text-decoration-underline">LAPORAN HARIAN</h5>
            <p class="mb-0">Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</p>
        </div>

        <!-- Statistics Summary -->
        <div class="row mb-4">
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-0">{{ $stats['total_quick_reports'] }}</h3>
                        <small class="text-muted">Laporan Cepat</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <h3 class="text-danger mb-0">{{ $stats['total_casualties'] }}</h3>
                        <small class="text-muted">Total Korban</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-0">{{ $stats['total_victims'] }}</h3>
                        <small class="text-muted">Korban Terdaftar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <h3 class="text-warning mb-0">{{ $stats['total_active_disasters'] }}</h3>
                        <small class="text-muted">Bencana Aktif</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Reports Section -->
        @if($quickReports->count() > 0)
        <div class="mb-4">
            <h6 class="fw-bold border-bottom pb-2 mb-3">
                <i class="fas fa-exclamation-circle text-danger me-2"></i>Laporan Cepat Hari Ini
            </h6>
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Waktu</th>
                        <th width="25%">Lokasi</th>
                        <th width="35%">Deskripsi</th>
                        <th width="10%">Korban</th>
                        <th width="10%">Pelapor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quickReports as $index => $report)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $report->created_at->format('H:i') }}</td>
                        <td>{{ $report->lokasi }}</td>
                        <td>{{ Str::limit($report->deskripsi, 80) }}</td>
                        <td class="text-center">
                            <span class="badge bg-danger">{{ $report->jumlah_korban }}</span>
                        </td>
                        <td>{{ $report->nama_pelapor }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Registered Victims Section -->
        @if($victims->count() > 0)
        <div class="mb-4">
            <h6 class="fw-bold border-bottom pb-2 mb-3">
                <i class="fas fa-users text-primary me-2"></i>Korban Terdaftar Hari Ini
            </h6>
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama</th>
                        <th width="15%">NIK</th>
                        <th width="20%">Alamat</th>
                        <th width="20%">Bencana</th>
                        <th width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($victims as $index => $victim)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $victim->nama }}</td>
                        <td>-</td>
                        <td>{{ Str::limit($victim->alamat, 40) }}</td>
                        <td>{{ $victim->disaster->nama ?? '-' }}</td>
                        <td>
                            @if($victim->status == 'selamat')
                                <span class="badge bg-success">Selamat</span>
                            @elseif($victim->status == 'luka')
                                <span class="badge bg-warning">Luka</span>
                            @elseif($victim->status == 'hilang')
                                <span class="badge bg-info">Hilang</span>
                            @else
                                <span class="badge bg-danger">Meninggal</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Active Disasters Section -->
        @if($disasters->count() > 0)
        <div class="mb-4">
            <h6 class="fw-bold border-bottom pb-2 mb-3">
                <i class="fas fa-mountain text-warning me-2"></i>Bencana Aktif
            </h6>
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama Bencana</th>
                        <th width="15%">Jenis</th>
                        <th width="25%">Lokasi</th>
                        <th width="15%">Tanggal</th>
                        <th width="10%">Korban</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($disasters as $index => $disaster)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $disaster->nama }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($disaster->jenis) }}</span>
                        </td>
                        <td>{{ $disaster->lokasi }}</td>
                        <td>{{ \Carbon\Carbon::parse($disaster->tanggal)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <span class="badge bg-danger">{{ $disaster->korbans_count }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Empty State -->
        @if($quickReports->count() == 0 && $victims->count() == 0)
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            Tidak ada laporan atau data korban pada tanggal {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-box">
            <div class="row">
                <div class="col-6">
                    <p class="mb-5">Mengetahui,<br><strong>Koordinator Lapangan</strong></p>
                    <p class="mt-5 pt-4 border-top d-inline-block" style="min-width: 200px;">
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                    </p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-1">Jakarta, {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
                    <p class="mb-5"><strong>Petugas Pelapor</strong></p>
                    <p class="mt-5 pt-4 border-top d-inline-block" style="min-width: 200px;">
                        @auth
                        ({{ Auth::user()->name }})
                        @else
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                        @endauth
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4 text-muted">
            <small>
                Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB<br>
                SIPENKORBAN v2.0 - Badan Nasional Penanggulangan Bencana
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
