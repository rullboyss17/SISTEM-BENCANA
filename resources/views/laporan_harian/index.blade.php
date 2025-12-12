@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-file-alt me-2 text-primary"></i>Laporan Harian</h2>
                    <p class="text-muted">Daftar laporan cepat yang telah dikirim</p>
                </div>
                <a href="{{ route('quick-report.create') }}" class="btn btn-danger">
                    <i class="fas fa-plus-circle me-1"></i>Buat Laporan Baru
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card disaster-table-card shadow-sm border-0">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Daftar Laporan Cepat</span>
                <small class="text-muted">Total: {{ $reports->total() }} laporan</small>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="120px">Foto</th>
                        <th>Lokasi Kejadian</th>
                        <th width="100px">Jumlah Korban</th>
                        <th width="180px">Waktu</th>
                        <th>Keterangan</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>
                            @if($report->foto_path)
                                <img src="{{ asset('storage/'.$report->foto_path) }}" alt="Foto" class="img-thumbnail" style="max-width:100px; max-height:80px; object-fit:cover;">
                            @else
                                <span class="badge bg-secondary">Tidak ada foto</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $report->lokasi }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $report->jumlah_korban }} orang</span>
                        </td>
                        <td>
                            <small>{{ $report->waktu ? $report->waktu->format('d M Y H:i') : '-' }}</small><br>
                            <small class="text-muted">Dibuat: {{ $report->created_at->format('d M Y H:i') }}</small>
                        </td>
                        <td>
                            @if($report->keterangan)
                                <small>{{ Str::limit($report->keterangan, 50) }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $report->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form action="{{ route('laporan-harian.destroy', $report->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal{{ $report->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Laporan - {{ $report->lokasi }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            @if($report->foto_path)
                                                <img src="{{ asset('storage/'.$report->foto_path) }}" alt="Foto" class="img-fluid rounded" style="max-height:400px; object-fit:cover;">
                                            @else
                                                <div class="alert alert-secondary">Tidak ada foto</div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lokasi Kejadian</label>
                                                <p>{{ $report->lokasi }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jumlah Korban</label>
                                                <p><span class="badge bg-info fs-6">{{ $report->jumlah_korban }} orang</span></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Waktu Kejadian</label>
                                                <p>{{ $report->waktu ? $report->waktu->format('d M Y H:i') : '-' }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tanggal Laporan</label>
                                                <p>{{ $report->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Keterangan</label>
                                            <p>{{ $report->keterangan ?? 'Tidak ada keterangan' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                            Belum ada laporan. <a href="{{ route('quick-report.create') }}">Buat laporan baru</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($reports->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $reports->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
