@extends('layouts.app')
@section('title', 'Detail Bencana')
@section('content')
<div class="container">
    <h2>Detail Bencana</h2>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nama Bencana</div>
                <div class="col-md-8">{{ $bencana->nama }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Jenis Bencana</div>
                <div class="col-md-8">{{ $bencana->jenis }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Lokasi</div>
                <div class="col-md-8">{{ $bencana->lokasi }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal</div>
                <div class="col-md-8">{{ \Carbon\Carbon::parse($bencana->tanggal)->format('d M Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Status</div>
                <div class="col-md-8">
                    @switch($bencana->status)
                        @case('aktif')
                            <span class="badge bg-danger">Aktif</span>
                        @break
                        @case('pemulihan')
                            <span class="badge bg-warning text-dark">Pemulihan</span>
                        @break
                        @case('selesai')
                            <span class="badge bg-secondary">Selesai</span>
                        @break
                        @default
                            <span class="badge bg-light text-dark">{{ $bencana->status }}</span>
                    @endswitch
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Jumlah Korban</div>
                <div class="col-md-8"><strong>{{ $bencana->jumlah_korban }}</strong> orang</div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Korban Bencana Ini ({{ $bencana->korbans_count ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @if($bencana->korbans->isEmpty())
                <p class="text-muted">Belum ada data korban untuk bencana ini.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Usia</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>Prioritas Medis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bencana->korbans as $korban)
                            <tr>
                                <td>{{ $korban->nama }}</td>
                                <td>{{ $korban->usia ?? '-' }}</td>
                                <td>{{ $korban->jenis_kelamin }}</td>
                                <td>{{ $korban->status }}</td>
                                <td>
                                    @switch($korban->prioritas_medis)
                                        @case('tinggi')<span class="badge bg-danger">Tinggi</span>@break
                                        @case('sedang')<span class="badge bg-warning text-dark">Sedang</span>@break
                                        @default <span class="badge bg-success">Rendah</span>
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('bencana.index') }}" class="btn btn-outline-secondary">Kembali</a>
        <a href="{{ route('bencana.edit', $bencana) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('bencana.destroy', $bencana) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus data?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
