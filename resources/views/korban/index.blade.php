@extends('layouts.app')
@section('title', 'Data Korban')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-users me-2 text-primary"></i>Data Korban</h2>
            <p class="text-muted mb-0">Kelola data korban bencana</p>
        </div>
        <a href="{{ route('korban.create') }}" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i>Tambah Korban</a>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('korban.index') }}">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Cari nama, status, ciri fisik..." value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card disaster-table-card shadow-sm border-0">
        <div class="card-header bg-white">
            <span class="fw-bold">Daftar Korban</span>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>Nama</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Prioritas Medis</th>
                    <th>Kebutuhan Medis</th>
                    <th>Kontak Keluarga</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($korbans as $korban)
                <tr>
                    <td>{{ $korban->nama }}</td>
                    <td>{{ $korban->usia }}</td>
                    <td>{{ $korban->jenis_kelamin }}</td>
                    <td>{{ $korban->alamat }}</td>
                    <td>{{ $korban->lokasi }}</td>
                    <td>{{ $korban->status }}</td>
                    <td>{{ $korban->prioritas_medis }}</td>
                    <td>{{ $korban->kebutuhan_medis }}</td>
                    <td>{{ $korban->kontak_keluarga }}</td>
                    <td>{{ $korban->keterangan }}</td>
                    <td>
                        <a href="{{ route('korban.show', $korban->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('korban.edit', $korban->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('korban.destroy', $korban->id) }}" method="POST" style="display:inline-block;">
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
</div>
@endsection
