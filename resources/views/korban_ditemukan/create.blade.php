@extends('layouts.app')
@section('title', 'Tambah Korban Ditemukan')
@section('content')
<div class="container">
    <h2>Tambah Korban Ditemukan</h2>
    <form action="{{ route('korban_ditemukan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="status_korban" class="form-label">Status Korban</label>
            <select name="status_korban" id="status_korban" class="form-select" required>
                <option value="selamat">Selamat</option>
                <option value="luka">Luka</option>
                <option value="meninggal">Meninggal</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama (isi jika diketahui)</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Kosongkan jika tidak diketahui">
            <small class="text-muted">Jika tidak diketahui, akan otomatis diberi kode: Korban-X-001</small>
        </div>
        <div class="mb-3">
            <label for="ciri_fisik" class="form-label">Ciri Fisik</label>
            <textarea name="ciri_fisik" id="ciri_fisik" class="form-control" placeholder="Tinggi, pakaian, tato, tanda lahir, dll" required></textarea>
        </div>
        <div class="mb-3">
            <label for="barang_bawaan" class="form-label">Barang Bawaan</label>
            <textarea name="barang_bawaan" id="barang_bawaan" class="form-control" placeholder="Jam tangan, KTP rusak, dompet, dll"></textarea>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Wajah / Badan</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="gps_lokasi" class="form-label">GPS Lokasi Penemuan</label>
            <input type="text" name="gps_lokasi" id="gps_lokasi" class="form-control" placeholder="Contoh: -7.12345, 110.12345" required>
        </div>
        <div class="mb-3">
            <label for="posko_rujukan" class="form-label">Posko Pengungsian / Rumah Sakit Rujukan</label>
            <input type="text" name="posko_rujukan" id="posko_rujukan" class="form-control" placeholder="Nama posko atau rumah sakit" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
