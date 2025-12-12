@extends('layouts.app')
@section('title', 'Surat Keterangan Korban')
@section('content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h4 class="mb-0">Surat Keterangan Korban Bencana</h4>
                <small class="text-muted">Nomor: {{ 'SKK-' . $korban->id }}</small>
            </div>

            <table class="table table-sm mb-3">
                <tbody>
                    <tr>
                        <th style="width:220px">Nama</th>
                        <td>{{ $korban->nama }}</td>
                    </tr>
                    <tr>
                        <th>Usia</th>
                        <td>{{ $korban->usia ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $korban->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $korban->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $korban->lokasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Korban</th>
                        <td class="text-capitalize">{{ $korban->status }}</td>
                    </tr>
                    <tr>
                        <th>Status Medis</th>
                        <td>{{ $korban->status_medis ?? '-' }} (Prioritas: {{ $korban->prioritas_medis }})</td>
                    </tr>
                    <tr>
                        <th>Kebutuhan Medis</th>
                        <td>{{ $korban->kebutuhan_medis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kontak Keluarga</th>
                        <td>{{ $korban->kontak_keluarga ?? '-' }}</td>
                    </tr>
                    @if($korban->disaster)
                    <tr>
                        <th>Bencana Terkait</th>
                        <td>{{ $korban->disaster->nama }} ({{ $korban->disaster->jenis }}) - {{ $korban->disaster->lokasi }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $korban->keterangan ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            <p>Demikian surat keterangan ini dibuat untuk keperluan penanganan bencana.</p>

            <div class="row mt-4">
                <div class="col-6"></div>
                <div class="col-6 text-end">
                    <p class="mb-1">{{ config('app.name') }}, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="mb-5">Petugas Penanganan Bencana</p>
                    <p class="fw-bold">(.............................................)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-3">
        <a href="{{ route('korban.index') }}" class="btn btn-outline-secondary">Kembali</a>
        <a href="{{ route('korban.surat', $korban->id) }}" class="btn btn-primary">Unduh PDF</a>
    </div>
</div>
@endsection
