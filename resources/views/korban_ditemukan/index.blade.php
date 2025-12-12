@extends('layouts.app')
@section('title', 'Data Korban Ditemukan')
@section('content')
<div class="container">
    <h2>Data Korban Ditemukan</h2>
    <a href="{{ route('korban_ditemukan.create') }}" class="btn btn-primary mb-3">Tambah Korban Ditemukan</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status Korban</th>
                    <th>Nama</th>
                    <th>Ciri Fisik</th>
                    <th>Barang Bawaan</th>
                    <th>Foto</th>
                    <th>GPS Lokasi</th>
                    <th>Posko Rujukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($korban_ditemukans as $korban)
                <tr>
                    <td>{{ $korban->status_korban }}</td>
                    <td>{{ $korban->nama }}</td>
                    <td>{{ $korban->ciri_fisik }}</td>
                    <td>{{ $korban->barang_bawaan }}</td>
                    <td>
                        @if($korban->foto)
                            <img src="{{ asset('storage/foto_korban/' . $korban->foto) }}" alt="Foto" width="60">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $korban->gps_lokasi }}</td>
                    <td>{{ $korban->posko_rujukan }}</td>
                    <td>
                        {{-- Tombol detail/edit/hapus bisa ditambahkan di sini --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
