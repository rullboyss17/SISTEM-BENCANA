@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Search Header -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius:12px;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-search fa-2x text-primary me-3"></i>
                <div>
                    <h4 class="mb-1">Hasil Pencarian</h4>
                    <p class="text-muted mb-0">Kata kunci: <strong>"{{ $q }}"</strong></p>
                </div>
            </div>
            
            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="mt-3">
                <div class="input-group">
                    <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari korban, bencana..." value="{{ $q }}" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($q === '')
        <!-- Empty State -->
        <div class="card shadow-sm border-0" style="border-radius:12px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Masukkan kata kunci untuk mencari</h5>
                <p class="text-muted">Anda dapat mencari data korban atau bencana</p>
            </div>
        </div>
    @else
        <!-- Summary -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100" style="border-radius:12px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px;background:#e3f2fd;">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">DATA KORBAN</h6>
                                <h3 class="mb-0">{{ $korbans->count() }} <small class="text-muted">hasil</small></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100" style="border-radius:12px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px;background:#fff3e0;">
                                    <i class="fas fa-mountain fa-2x text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">DATA BENCANA</h6>
                                <h3 class="mb-0">{{ $bencanas->count() }} <small class="text-muted">hasil</small></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results: Korban -->
        @if($korbans->count() > 0)
        <div class="card shadow-sm border-0 mb-4" style="border-radius:12px;">
            <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-radius:12px 12px 0 0;">
                <span class="fw-bold">
                    <i class="fas fa-users text-primary me-2"></i>Data Korban ({{ $korbans->count() }})
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Usia</th>
                            <th>Jenis Kelamin</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($korbans as $korban)
                        <tr>
                            <td><strong>{{ $korban->nama }}</strong></td>
                            <td>{{ $korban->usia ?? '-' }}</td>
                            <td>{{ $korban->jenis_kelamin }}</td>
                            <td>{{ $korban->lokasi ?? '-' }}</td>
                            <td>
                                @switch($korban->status)
                                    @case('hilang')
                                        <span class="badge bg-danger">Hilang</span>
                                        @break
                                    @case('ditemukan')
                                        <span class="badge bg-warning text-dark">Ditemukan</span>
                                        @break
                                    @case('selamat')
                                        <span class="badge bg-success">Selamat</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $korban->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                @if($korban->prioritas_medis)
                                    @switch($korban->prioritas_medis)
                                        @case('tinggi')
                                            <span class="badge bg-danger">Tinggi</span>
                                            @break
                                        @case('sedang')
                                            <span class="badge bg-warning text-dark">Sedang</span>
                                            @break
                                        @default
                                            <span class="badge bg-success">Rendah</span>
                                    @endswitch
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('korban.show', $korban->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Results: Bencana -->
        @if($bencanas->count() > 0)
        <div class="card shadow-sm border-0 mb-4" style="border-radius:12px;">
            <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-radius:12px 12px 0 0;">
                <span class="fw-bold">
                    <i class="fas fa-mountain text-warning me-2"></i>Data Bencana ({{ $bencanas->count() }})
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Bencana</th>
                            <th>Jenis</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bencanas as $bencana)
                        <tr>
                            <td><strong>{{ $bencana->nama }}</strong></td>
                            <td>{{ $bencana->jenis }}</td>
                            <td>{{ $bencana->lokasi }}</td>
                            <td>{{ $bencana->tanggal }}</td>
                            <td>
                                @switch($bencana->status)
                                    @case('aktif')
                                        <span class="badge bg-danger">Aktif</span>
                                        @break
                                    @case('pemulihan')
                                        <span class="badge bg-warning text-dark">Pemulihan</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Selesai</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('bencana.show', $bencana->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- No Results -->
        @if($korbans->count() === 0 && $bencanas->count() === 0)
        <div class="card shadow-sm border-0" style="border-radius:12px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada hasil ditemukan</h5>
                <p class="text-muted">Coba gunakan kata kunci yang berbeda</p>
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
