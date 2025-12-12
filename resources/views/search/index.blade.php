@extends('layouts.app')
@section('title', 'Hasil Pencarian')
@section('content')
<div class="container">
    <h2 class="mb-3">Hasil Pencarian</h2>
    <form method="GET" action="{{ route('search') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Cari korban, bencana..." value="{{ $q }}">
            <button class="btn btn-outline-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header fw-bold">Korban</div>
                <div class="card-body">
                    @if($korbans->isEmpty())
                        <p class="text-muted">Tidak ada hasil untuk data korban.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($korbans as $korban)
                                    <tr>
                                        <td>{{ $korban->nama }}</td>
                                        <td class="text-capitalize">{{ $korban->status }}</td>
                                        <td>{{ $korban->lokasi ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('korban.show', $korban->id) }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="{{ route('korban.edit', $korban->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header fw-bold">Bencana</div>
                <div class="card-body">
                    @if($bencanas->isEmpty())
                        <p class="text-muted">Tidak ada hasil untuk data bencana.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bencanas as $bencana)
                                    <tr>
                                        <td>{{ $bencana->nama }}</td>
                                        <td>{{ $bencana->jenis }}</td>
                                        <td class="text-capitalize">{{ $bencana->status }}</td>
                                        <td>{{ $bencana->lokasi }}</td>
                                        <td>
                                            <a href="{{ route('bencana.show', $bencana->id) }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="{{ route('bencana.edit', $bencana->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
