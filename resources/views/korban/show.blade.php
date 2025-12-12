@extends('layouts.app')
@section('title', 'Detail Korban')
@section('content')
<div class="container">
    <h2>Detail Korban</h2>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Nama</div>
                <div class="col-md-8">{{ $korban->nama }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Usia</div>
                <div class="col-md-8">{{ $korban->usia ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                <div class="col-md-8">{{ $korban->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Alamat</div>
                <div class="col-md-8">{{ $korban->alamat ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Lokasi</div>
                <div class="col-md-8">{{ $korban->lokasi ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Status</div>
                <div class="col-md-8 text-capitalize">{{ $korban->status }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Prioritas Medis</div>
                <div class="col-md-8 text-capitalize">{{ $korban->prioritas_medis }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Status Medis</div>
                <div class="col-md-8">{{ $korban->status_medis ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Kebutuhan Medis</div>
                <div class="col-md-8">{{ $korban->kebutuhan_medis ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Kontak Keluarga</div>
                <div class="col-md-8">{{ $korban->kontak_keluarga ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Keterangan</div>
                <div class="col-md-8">{{ $korban->keterangan ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('korban.index') }}" class="btn btn-outline-secondary">Kembali</a>
        <a href="{{ route('korban.edit', $korban->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('korban.destroy', $korban->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
