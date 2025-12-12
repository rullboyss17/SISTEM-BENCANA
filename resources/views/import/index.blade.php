@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-file-import text-primary me-2"></i>Import Data</h2>
            <p class="text-muted mb-0">Import data korban, bencana, atau posko dari file Excel/CSV</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Upload Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4" style="border-radius:12px;">
                <div class="card-header bg-white" style="border-radius:12px 12px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload File</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Type Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tipe Data</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="type" id="type-korban" value="korban" checked>
                                <label class="btn btn-outline-primary" for="type-korban" style="border-radius:8px 0 0 0;">
                                    <i class="fas fa-users me-2"></i>Data Korban
                                </label>

                                <input type="radio" class="btn-check" name="type" id="type-bencana" value="bencana">
                                <label class="btn btn-outline-primary" for="type-bencana" style="border-radius:0;">
                                    <i class="fas fa-mountain me-2"></i>Data Bencana
                                </label>

                                <input type="radio" class="btn-check" name="type" id="type-posko" value="posko">
                                <label class="btn btn-outline-primary" for="type-posko" style="border-radius:0 8px 8px 0;">
                                    <i class="fas fa-clinic-medical me-2"></i>Data Posko
                                </label>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih File</label>
                            <div class="position-relative">
                                <input type="file" class="form-control form-control-lg" id="file-input" name="file" 
                                       accept=".xlsx,.csv,.xls" required style="cursor:pointer;">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>Format yang didukung: Excel (.xlsx, .xls), CSV
                                </small>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div id="preview-section" style="display:none;">
                            <div class="alert alert-info mb-4">
                                <h6 class="alert-heading mb-2"><i class="fas fa-eye me-2"></i>Preview File</h6>
                                <table class="table table-sm table-striped mb-0">
                                    <thead>
                                        <tr id="preview-header"></tr>
                                    </thead>
                                    <tbody id="preview-body"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fas fa-upload me-2"></i>Import Data
                            </button>
                            <a href="{{ route('import.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Template Section -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4" style="border-radius:12px;background:#f8f9fa;">
                <div class="card-header bg-white" style="border-radius:12px 12px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-list me-2 text-info"></i>Format Kolom</h5>
                </div>
                <div class="card-body">
                    <!-- Korban Format -->
                    <div id="korban-format">
                        <h6 class="fw-bold mb-3">Data Korban</h6>
                        <div class="mb-3">
                            <div class="bg-white p-2 rounded mb-2" style="border-left:3px solid #0d6efd;">
                                <small class="text-muted d-block"><strong>Kolom Wajib:</strong></small>
                                <ul class="list-unstyled mb-0 ps-2">
                                    <li><i class="fas fa-circle text-primary me-1" style="font-size:0.4rem;"></i><code>nama</code></li>
                                    <li><i class="fas fa-circle text-primary me-1" style="font-size:0.4rem;"></i><code>jenis_kelamin</code> (L/P atau Laki-laki/Perempuan)</li>
                                    <li><i class="fas fa-circle text-primary me-1" style="font-size:0.4rem;"></i><code>status</code> (hilang/ditemukan/selamat)</li>
                                </ul>
                            </div>
                            <div class="bg-white p-2 rounded" style="border-left:3px solid #6c757d;">
                                <small class="text-muted d-block"><strong>Kolom Opsional:</strong></small>
                                <ul class="list-unstyled mb-0 ps-2">
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>usia</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>lokasi</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>alamat</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>kebutuhan_medis</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>prioritas_medis</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>kontak_keluarga</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>keterangan</code></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Download Template -->
                        <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#templateModal">
                            <i class="fas fa-download me-1"></i>Download Template Korban
                        </button>
                    </div>

                    <!-- Bencana Format -->
                    <div id="bencana-format" style="display:none;">
                        <h6 class="fw-bold mb-3">Data Bencana</h6>
                        <div class="mb-3">
                            <div class="bg-white p-2 rounded mb-2" style="border-left:3px solid #0d6efd;">
                                <small class="text-muted d-block"><strong>Kolom Wajib:</strong></small>
                                <ul class="list-unstyled mb-0 ps-2">
                                    <li><i class="fas fa-circle text-primary me-1" style="font-size:0.4rem;"></i><code>nama</code></li>
                                </ul>
                            </div>
                            <div class="bg-white p-2 rounded" style="border-left:3px solid #6c757d;">
                                <small class="text-muted d-block"><strong>Kolom Opsional:</strong></small>
                                <ul class="list-unstyled mb-0 ps-2">
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>jenis</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>lokasi</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>tanggal</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>status</code> (aktif/pemulihan/selesai)</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Download Template -->
                        <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#templateModal">
                            <i class="fas fa-download me-1"></i>Download Template Bencana
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="card shadow-sm border-0" style="border-radius:12px;background:#e7f3ff;border-left:4px solid #0d6efd;">
                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="fas fa-lightbulb me-2"></i>Tips
                    </h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Baris pertama</strong> harus berisi nama kolom
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Pastikan <strong>ejaan kolom</strong> sudah benar
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Data kosong di kolom opsional tidak masalah
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Maksimal <strong>1000 baris</strong> per file
                        </li>
                    </ul>
                </div>

                    <!-- Posko Format -->
                    <div id="posko-format" style="display:none;">
                        <h6 class="fw-bold mb-3">Data Posko</h6>
                        <div class="mb-3">
                            <div class="bg-white p-2 rounded mb-2" style="border-left:3px solid #0d6efd;">
                                <small class="text-muted d-block"><strong>Kolom Wajib:</strong></small>
                                <ul class="list-unstyled mb-0 ps-2">
                                    <li><i class="fas fa-circle text-primary me-1" style="font-size:0.4rem;"></i><code>nama</code></li>
                                    <li><i class="fas fa-circle text-primary me-1" style="font-size:0.4rem;"></i><code>lokasi</code></li>
                                </ul>
                            </div>
                            <div class="bg-white p-2 rounded" style="border-left:3px solid #6c757d;">
                                <small class="text-muted d-block"><strong>Kolom Opsional:</strong></small>
                                <ul class="list-unstyled mb-0 ps-2">
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>kapasitas</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>terisi</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>petugas</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>status</code></li>
                                    <li><i class="fas fa-circle text-secondary me-1" style="font-size:0.4rem;"></i><code>kontak</code></li>
                                </ul>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#templateModal">
                            <i class="fas fa-download me-1"></i>Download Template Posko
                        </button>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Template Modal -->
<div class="modal fade" id="templateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-download me-2"></i>Download Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Pilih template yang ingin diunduh:</p>
                <div class="d-grid gap-2">
                    <a href="javascript:downloadTemplate('korban')" class="btn btn-primary">
                        <i class="fas fa-users me-2"></i>Template Data Korban
                    </a>
                    <a href="javascript:downloadTemplate('bencana')" class="btn btn-warning">
                        <i class="fas fa-mountain me-2"></i>Template Data Bencana
                    </a>
                    <a href="javascript:downloadTemplate('posko')" class="btn btn-success">
                        <i class="fas fa-clinic-medical me-2"></i>Template Data Posko
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle format sections
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const isBencana = this.value === 'bencana';
        const isPosko = this.value === 'posko';
        document.getElementById('korban-format').style.display = (!isBencana && !isPosko) ? 'block' : 'none';
        document.getElementById('bencana-format').style.display = isBencana ? 'block' : 'none';
        document.getElementById('posko-format').style.display = isPosko ? 'block' : 'none';
    });
});

// Download template function
function downloadTemplate(type) {
    let templateData;
    if (type === 'korban') {
        templateData = [
            ['nama', 'jenis_kelamin', 'status', 'usia', 'lokasi', 'alamat', 'kebutuhan_medis', 'prioritas_medis', 'kontak_keluarga', 'keterangan']
        ];
    } else if (type === 'bencana') {
        templateData = [
            ['nama', 'jenis', 'lokasi', 'tanggal', 'status']
        ];
    } else {
        templateData = [
            ['Nama Posko', 'Lokasi', 'Kapasitas', 'Terisi', 'Petugas', 'Status', 'Kontak']
        ];
    }
    
    downloadCSV(templateData, `template_${type}.csv`);
}

function downloadCSV(data, filename) {
    const csv = data.map(row => row.map(cell => `"${cell}"`).join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
@endsection
