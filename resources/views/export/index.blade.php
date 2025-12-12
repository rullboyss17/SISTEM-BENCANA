@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-download me-2"></i> Export Data
                </div>
                <div class="card-body">
                    <p class="text-muted">Pilih dataset yang ingin diexport dalam format CSV.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('export.disasters.csv') }}" class="btn btn-outline-primary">
                            <i class="fas fa-mountain me-2"></i> Export Data Bencana (CSV)
                        </a>
                        <a href="{{ route('export.korban.csv') }}" class="btn btn-outline-danger">
                            <i class="fas fa-users me-2"></i> Export Data Korban (CSV)
                        </a>
                    </div>
                    <hr>
                    <small class="text-muted">CSV dapat dibuka di Excel, Google Sheets, atau aplikasi serupa.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
