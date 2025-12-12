@extends('layouts.app')
@section('title', 'Tambah Korban')
@section('content')
<div class="container">
    <h2>Tambah Korban</h2>
    <form action="{{ route('korban.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama lengkap" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="usia" class="form-label">Usia</label>
                    <input type="number" name="usia" id="usia" class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat domisili">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Lokasi terakhir / penemuan">
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="hilang">Hilang</option>
                        <option value="ditemukan">Ditemukan</option>
                        <option value="meninggal">Meninggal</option>
                        <option value="selamat">Selamat</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="prioritas_medis" class="form-label">Prioritas Medis</label>
                    <select name="prioritas_medis" id="prioritas_medis" class="form-select" required>
                        <option value="tinggi">Tinggi</option>
                        <option value="sedang">Sedang</option>
                        <option value="rendah">Rendah</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="status_medis" class="form-label">Status Medis</label>
                    <input type="text" name="status_medis" id="status_medis" class="form-control" placeholder="Cedera, stabil, kritis, dll">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="kebutuhan_medis" class="form-label">Kebutuhan Medis</label>
                    <input type="text" name="kebutuhan_medis" id="kebutuhan_medis" class="form-control" placeholder="Obat, oksigen, operasi, dll">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="kontak_keluarga" class="form-label">Kontak Keluarga</label>
                    <input type="text" name="kontak_keluarga" id="kontak_keluarga" class="form-control" placeholder="Nomor telepon / kontak darurat">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="disaster_id" class="form-label">Bencana Terkait (Opsional)</label>
                    <select name="disaster_id" id="disaster_id" class="form-select">
                        <option value="">-- Pilih Bencana --</option>
                        @foreach($disasters as $disaster)
                            <option value="{{ $disaster->id }}">{{ $disaster->nama }} ({{ $disaster->jenis }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan"></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('korban.index') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
