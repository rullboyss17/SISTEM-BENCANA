@extends('layouts.app')
@section('title', 'Matching Korban')
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-exchange-alt text-primary me-2"></i>Matching Korban</h2>
            <p class="text-muted mb-0">Pencocokan otomatis korban hilang dengan korban ditemukan</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;background:#fde2e1;">
                                <i class="fas fa-user-times fa-lg text-danger"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">KORBAN HILANG</h6>
                            <h3 class="mb-0">{{ $korbanHilang->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;background:#fff3cd;">
                                <i class="fas fa-user-check fa-lg text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">KORBAN DITEMUKAN</h6>
                            <h3 class="mb-0">{{ $korbanDitemukan->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;background:#e3f2fd;">
                                <i class="fas fa-link fa-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">KEMUNGKINAN COCOK</h6>
                            <h3 class="mb-0">{{ count($matches) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;background:#eafbe7;">
                                <i class="fas fa-star fa-lg text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">CONFIDENCE TINGGI</h6>
                            <h3 class="mb-0">{{ collect($matches)->where('confidence', 'high')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius:12px;">
        <div class="card-body">
            <form action="{{ route('matching.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Pencarian</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, lokasi..." value="{{ $searchQuery }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Filter Confidence</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Level</option>
                        <option value="high" {{ $statusFilter === 'high' ? 'selected' : '' }}>Tinggi (≥75%)</option>
                        <option value="medium" {{ $statusFilter === 'medium' ? 'selected' : '' }}>Sedang (50-74%)</option>
                        <option value="low" {{ $statusFilter === 'low' ? 'selected' : '' }}>Rendah (25-49%)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Urutkan</label>
                    <select name="sort" class="form-select">
                        <option value="similarity">Similarity</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Matching Results -->
    <div class="card shadow-sm border-0" style="border-radius:12px;">
        <div class="card-header bg-white" style="border-radius:12px 12px 0 0;">
            <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Hasil Matching ({{ count($matches) }})</h5>
        </div>
        <div class="card-body p-0">
            @forelse($matches as $match)
            <div class="border-bottom p-4 hover-bg-light" style="transition: background 0.2s;">
                <div class="row align-items-center">
                    <!-- Confidence Badge -->
                    <div class="col-md-1 text-center">
                        <div class="mb-2">
                            @if($match['confidence'] === 'high')
                                <span class="badge bg-success" style="font-size:0.9rem;padding:0.5rem 0.75rem;">
                                    <i class="fas fa-star me-1"></i>{{ $match['similarity'] }}%
                                </span>
                            @elseif($match['confidence'] === 'medium')
                                <span class="badge bg-warning text-dark" style="font-size:0.9rem;padding:0.5rem 0.75rem;">
                                    <i class="fas fa-star-half-alt me-1"></i>{{ $match['similarity'] }}%
                                </span>
                            @else
                                <span class="badge bg-secondary" style="font-size:0.9rem;padding:0.5rem 0.75rem;">
                                    {{ $match['similarity'] }}%
                                </span>
                            @endif
                        </div>
                        <small class="text-muted">
                            @if($match['confidence'] === 'high')
                                Tinggi
                            @elseif($match['confidence'] === 'medium')
                                Sedang
                            @else
                                Rendah
                            @endif
                        </small>
                    </div>

                    <!-- Korban Hilang -->
                    <div class="col-md-5">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center text-white" style="width:40px;height:40px;">
                                    <i class="fas fa-user-times"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $match['hilang']->nama }}</h6>
                                <div class="small text-muted">
                                    <div><i class="fas fa-venus-mars me-1"></i>{{ $match['hilang']->jenis_kelamin }}, {{ $match['hilang']->usia ?? '-' }} tahun</div>
                                    <div><i class="fas fa-map-marker-alt me-1"></i>{{ $match['hilang']->lokasi ?? '-' }}</div>
                                    @if($match['hilang']->keterangan)
                                    <div class="mt-1"><i class="fas fa-info-circle me-1"></i>{{ Str::limit($match['hilang']->keterangan, 50) }}</div>
                                    @endif
                                </div>
                                <span class="badge bg-danger mt-2">Hilang</span>
                            </div>
                        </div>
                    </div>

                    <!-- Arrow -->
                    <div class="col-md-1 text-center">
                        <i class="fas fa-arrow-right fa-2x text-primary"></i>
                    </div>

                    <!-- Korban Ditemukan -->
                    <div class="col-md-5">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-dark" style="width:40px;height:40px;">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $match['ditemukan']->nama }}</h6>
                                <div class="small text-muted">
                                    <div><i class="fas fa-venus-mars me-1"></i>{{ $match['ditemukan']->jenis_kelamin }}, {{ $match['ditemukan']->usia ?? '-' }} tahun</div>
                                    <div><i class="fas fa-map-marker-alt me-1"></i>{{ $match['ditemukan']->lokasi ?? '-' }}</div>
                                    @if($match['ditemukan']->keterangan)
                                    <div class="mt-1"><i class="fas fa-info-circle me-1"></i>{{ Str::limit($match['ditemukan']->keterangan, 50) }}</div>
                                    @endif
                                </div>
                                <span class="badge bg-warning text-dark mt-2">Ditemukan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="col-md-12 mt-3">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('korban.show', $match['hilang']->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="fas fa-eye me-1"></i>Lihat Hilang
                            </a>
                            <a href="{{ route('korban.show', $match['ditemukan']->id) }}" class="btn btn-sm btn-outline-warning" target="_blank">
                                <i class="fas fa-eye me-1"></i>Lihat Ditemukan
                            </a>
                            <form action="{{ route('matching.confirm') }}" method="POST" class="d-inline" onsubmit="return confirm('Konfirmasi matching ini? Status kedua korban akan diubah menjadi Selamat.')">
                                @csrf
                                <input type="hidden" name="hilang_id" value="{{ $match['hilang']->id }}">
                                <input type="hidden" name="ditemukan_id" value="{{ $match['ditemukan']->id }}">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-check me-1"></i>Konfirmasi Match
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada matching ditemukan</h5>
                <p class="text-muted">Sistem belum menemukan kecocokan antara korban hilang dan ditemukan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.hover-bg-light:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
