@extends('layouts.app')
@section('title', 'Edit Bencana')
@section('content')
<div class="container">
    <h2>Edit Bencana</h2>
    <form action="{{ route('bencana.update', $bencana) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Bencana</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" 
                           placeholder="Contoh: Gempa Bumi Cianjur" value="{{ old('nama', $bencana->nama) }}" required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Bencana</label>
                    <input type="text" name="jenis" id="jenis" class="form-control @error('jenis') is-invalid @enderror" 
                           placeholder="Contoh: Gempa, Banjir, Tanah Longsor" value="{{ old('jenis', $bencana->jenis) }}" required>
                    @error('jenis')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                           placeholder="Contoh: Kabupaten Cianjur" value="{{ old('lokasi', $bencana->lokasi) }}" required>
                    @error('lokasi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Bencana</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                           value="{{ old('tanggal', $bencana->tanggal) }}" required>
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" @selected(old('status', $bencana->status) === 'aktif')>Aktif</option>
                        <option value="pemulihan" @selected(old('status', $bencana->status) === 'pemulihan')>Pemulihan</option>
                        <option value="selesai" @selected(old('status', $bencana->status) === 'selesai')>Selesai</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="jumlah_korban" class="form-label">Jumlah Korban</label>
                    <input type="number" name="jumlah_korban" id="jumlah_korban" class="form-control @error('jumlah_korban') is-invalid @enderror" 
                           value="{{ old('jumlah_korban', $bencana->jumlah_korban) }}" min="0" required>
                    @error('jumlah_korban')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('bencana.index') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
