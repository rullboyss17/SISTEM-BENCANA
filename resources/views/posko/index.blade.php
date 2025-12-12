@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Data Posko</h2>
        <p class="text-muted mb-0">Pemantauan kapasitas dan status posko</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('posko.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Tambah Posko</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="stats-label">TOTAL POSKO</div>
                    <div class="stats-number">{{ $summary['total_posko'] }}</div>
                </div>
                <div class="stats-icon-container bg-primary-subtle text-primary">
                    <i class="fas fa-clinic-medical"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="stats-label">TOTAL KAPASITAS</div>
                    <div class="stats-number">{{ $summary['total_kapasitas'] }}</div>
                </div>
                <div class="stats-icon-container bg-info-subtle text-info">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="stats-label">TOTAL TERISI</div>
                    <div class="stats-number">{{ $summary['total_terisi'] }}</div>
                </div>
                <div class="stats-icon-container bg-warning-subtle text-warning">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="stats-label">SISA KAPASITAS</div>
                    <div class="stats-number text-success">{{ $summary['sisa_kapasitas'] }}</div>
                </div>
                <div class="stats-icon-container bg-success-subtle text-success">
                    <i class="fas fa-bed"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card disaster-table-card shadow-sm border-0">
    <div class="card-header bg-white">
        <span class="fw-bold">Daftar Posko</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Posko</th>
                        <th>Lokasi</th>
                        <th>Kapasitas</th>
                        <th>Terisi</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Kontak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($poskos as $posko)
                        <tr>
                            <td>{{ $posko->nama }}</td>
                            <td>{{ $posko->lokasi }}</td>
                            <td>{{ $posko->kapasitas }}</td>
                            <td>{{ $posko->terisi }}</td>
                            <td>{{ $posko->petugas }}</td>
                            <td>
                                @php $status = strtolower($posko->status); @endphp
                                <span class="badge @if($status === 'aktif') bg-success @elseif($status === 'penuh') bg-danger @else bg-secondary @endif">{{ $posko->status }}</span>
                            </td>
                            <td>{{ $posko->kontak }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('posko.edit', $posko) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('posko.destroy', $posko) }}" method="POST" onsubmit="return confirm('Hapus posko ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data posko.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $poskos->links() }}
        </div>
    </div>
</div>
@endsection
