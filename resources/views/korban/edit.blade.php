@extends('layouts.app')
@section('title', 'Edit Korban')
@section('content')
<div class="container">
    <h2>Edit Data Korban</h2>
    <form action="{{ route('korban.update', $korban->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $korban->nama) }}">
        </div>
        <div class="mb-3">
            <label for="usia" class="form-label">Usia</label>
            <input type="number" name="usia" id="usia" class="form-control" value="{{ old('usia', $korban->usia) }}">
        </div>
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                <option value="L" @selected(old('jenis_kelamin', $korban->jenis_kelamin) === 'L')>Laki-laki</option>
                <option value="P" @selected(old('jenis_kelamin', $korban->jenis_kelamin) === 'P')>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $korban->alamat) }}">
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ old('lokasi', $korban->lokasi) }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="hilang" @selected(old('status', $korban->status) === 'hilang')>Hilang</option>
                <option value="ditemukan" @selected(old('status', $korban->status) === 'ditemukan')>Ditemukan</option>
                <option value="meninggal" @selected(old('status', $korban->status) === 'meninggal')>Meninggal</option>
                <option value="selamat" @selected(old('status', $korban->status) === 'selamat')>Selamat</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="kebutuhan_medis" class="form-label">Kebutuhan Medis</label>
            <input type="text" name="kebutuhan_medis" id="kebutuhan_medis" class="form-control" value="{{ old('kebutuhan_medis', $korban->kebutuhan_medis) }}">
        </div>
        <div class="mb-3">
            <label for="prioritas_medis" class="form-label">Prioritas Medis</label>
            <select name="prioritas_medis" id="prioritas_medis" class="form-select">
                <option value="tinggi" @selected(old('prioritas_medis', $korban->prioritas_medis) === 'tinggi')>Tinggi</option>
                <option value="sedang" @selected(old('prioritas_medis', $korban->prioritas_medis) === 'sedang')>Sedang</option>
                <option value="rendah" @selected(old('prioritas_medis', $korban->prioritas_medis) === 'rendah')>Rendah</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status_medis" class="form-label">Status Medis</label>
            <input type="text" name="status_medis" id="status_medis" class="form-control" value="{{ old('status_medis', $korban->status_medis) }}">
        </div>
        <div class="mb-3">
            <label for="kontak_keluarga" class="form-label">Kontak Keluarga</label>
            <input type="text" name="kontak_keluarga" id="kontak_keluarga" class="form-control" value="{{ old('kontak_keluarga', $korban->kontak_keluarga) }}">
        </div>
        <div class="mb-3">
            <label for="disaster_id" class="form-label">Bencana Terkait (Opsional)</label>
            <select name="disaster_id" id="disaster_id" class="form-select">
                <option value="">-- Pilih Bencana --</option>
                @foreach($disasters as $disaster)
                    <option value="{{ $disaster->id }}" @selected(old('disaster_id', $korban->disaster_id) == $disaster->id)>{{ $disaster->nama }} ({{ $disaster->jenis }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan', $korban->keterangan) }}</textarea>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('korban.index') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
