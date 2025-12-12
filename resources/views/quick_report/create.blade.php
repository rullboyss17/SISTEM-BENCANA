@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-header bg-white" style="border-radius:12px 12px 0 0;">
                    <span class="fw-bold"><i class="fas fa-plus-circle text-danger me-2"></i>Laporan Cepat Kejadian</span>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('quick-report.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Foto Kejadian</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                            @error('foto')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Korban</label>
                            <input type="number" name="jumlah_korban" class="form-control" min="0" required>
                            @error('jumlah_korban')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Desa X, Kec. Y" required>
                            @error('lokasi')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu Kejadian</label>
                            <input type="datetime-local" name="waktu" class="form-control">
                            @error('waktu')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Detail singkat kondisi kejadian, akses, kebutuhan mendesak, dll"></textarea>
                            @error('keterangan')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-danger"><i class="fas fa-paper-plane me-1"></i>Kirim Laporan</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('last_report'))
            <div class="card shadow-sm border-0 mt-3" style="border-radius:12px;">
                <div class="card-header bg-white" style="border-radius:12px 12px 0 0;">
                    <span class="fw-bold"><i class="fas fa-info-circle text-primary me-2"></i>Laporan Terakhir</span>
                </div>
                <div class="card-body">
                    @php($r = session('last_report'))
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-2"><strong>Lokasi:</strong> {{ $r['lokasi'] }}</div>
                            <div class="mb-2"><strong>Jumlah Korban:</strong> {{ $r['jumlah_korban'] }}</div>
                            <div class="mb-2"><strong>Waktu:</strong> {{ $r['waktu'] }}</div>
                            <div class="mb-2"><strong>Keterangan:</strong> {{ $r['keterangan'] ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            @if(!empty($r['foto_path']))
                                <img src="{{ asset('storage/'.$r['foto_path']) }}" alt="Foto kejadian" class="img-fluid rounded">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
