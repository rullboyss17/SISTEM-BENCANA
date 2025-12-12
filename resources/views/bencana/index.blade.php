@extends('layouts.app')
@section('title', 'Daftar Bencana')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-mountain me-2 text-primary"></i>Daftar Bencana</h2>
            <p class="text-muted mb-0">Kelola data bencana dan statusnya</p>
        </div>
        <a href="{{ route('bencana.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Tambah Bencana</a>
    </div>

    @if($bencanas->isEmpty())
        <div class="alert alert-info">
            Belum ada data bencana. <a href="{{ route('bencana.create') }}">Tambah sekarang</a>
        </div>
    @else
        <div class="card disaster-table-card shadow-sm border-0">
            <div class="card-header bg-white">
                <span class="fw-bold">Data Bencana</span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>Nama Bencana</th>
                        <th>Jenis</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Jumlah Korban</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bencanas as $bencana)
                    <tr>
                        <td class="fw-bold">{{ $bencana->nama }}</td>
                        <td>{{ $bencana->jenis }}</td>
                        <td>{{ $bencana->lokasi }}</td>
                        <td>{{ \Carbon\Carbon::parse($bencana->tanggal)->format('d M Y') }}</td>
                        <td>
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
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $bencana->jumlah_korban }} korban</span>
                        </td>
                        <td>
                            <a href="{{ route('bencana.show', $bencana) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('bencana.edit', $bencana) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('bencana.destroy', $bencana) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
