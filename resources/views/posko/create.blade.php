@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Tambah Posko</h2>
        <p class="text-muted mb-0">Input data posko baru</p>
    </div>
    <a href="{{ route('posko.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('posko.store') }}" method="POST" class="card shadow-sm">
    @csrf
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Posko *</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Lokasi *</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Kapasitas *</label>
            <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', 0) }}" min="0" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Terisi</label>
            <input type="number" name="terisi" class="form-control" value="{{ old('terisi', 0) }}" min="0">
        </div>
        <div class="col-md-4">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                @foreach(['Aktif','Penuh','Nonaktif'] as $status)
                    <option value="{{ $status }}" @selected(old('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Petugas Penanggung Jawab</label>
            <input type="text" name="petugas" class="form-control" value="{{ old('petugas') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" value="{{ old('kontak') }}">
        </div>
        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" rows="3" class="form-control">{{ old('catatan') }}</textarea>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
@endsection
