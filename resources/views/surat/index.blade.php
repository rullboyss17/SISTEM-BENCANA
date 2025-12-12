@extends('layouts.blank')
@section('title', 'Halaman Surat')
@section('content')
<div class="container">
  <h2 class="mb-3">Halaman Surat</h2>
  <style>
    body { padding: 20px; }
    .kop { text-align:center; border-bottom: 2px solid #000; padding-bottom: 12px; margin-bottom: 18px; }
    .kop .instansi { font-weight:700; font-size:18px; }
    .no-print { margin-bottom: 18px; }
    @media print {
      .no-print { display: none !important; }
      body { padding: 0; }
    }
    .field-label { width: 180px; display: inline-block; }
    .signature { margin-top: 36px; }
  </style>
  <div class="container">
    <div class="no-print">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="m-0">Template Surat Keterangan Korban Bencana</h4>
        <div>
          <button class="btn btn-primary btn-sm" onclick="window.print()">Cetak / Print</button>
          <button class="btn btn-outline-secondary btn-sm" onclick="resetForm()">Reset</button>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          <div class="row g-2">
            <div class="col-md-4">
              <label class="form-label">Jenis Surat</label>
              <select id="jenisSurat" class="form-select" onchange="renderSurat()">
                <option value="umum">Surat Keterangan Korban Bencana (Umum)</option>
                <option value="sakit">Surat Keterangan Korban Sakit / Luka</option>
                <option value="meninggal">Surat Keterangan Korban Meninggal</option>
                <option value="hilang">Surat Keterangan Orang Hilang / Tidak Ditemukan</option>
              </select>
            </div>
            <div class="col-md-8">
              <label class="form-label">Instansi / Penanda Tangan</label>
              <input id="instansi" class="form-control" placeholder="Contoh: KEPALA BPBD KAB. XXX" value="PEMERINTAH KABUPATEN XXX\nBADAN PENANGGULANGAN BENCANA DAERAH (BPBD)">
            </div>

            <div class="col-12">
              <hr>
              <h6>Data Korban</h6>
            </div>

            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input id="nama" class="form-control" placeholder="Nama lengkap">
            </div>
            <div class="col-md-6">
              <label class="form-label">NIK</label>
              <input id="nik" class="form-control" placeholder="NIK / No. Identitas">
            </div>
            <div class="col-md-4">
              <label class="form-label">Tempat, Tgl Lahir</label>
              <input id="ttl" class="form-control" placeholder="Contoh: Jakarta, 1 Januari 1990">
            </div>
            <div class="col-md-4">
              <label class="form-label">Jenis Kelamin</label>
              <input id="jk" class="form-control" placeholder="Laki-laki / Perempuan">
            </div>
            <div class="col-md-4">
              <label class="form-label">Alamat</label>
              <input id="alamat" class="form-control" placeholder="Alamat lengkap">
            </div>

            <div class="col-md-6">
              <label class="form-label">Waktu Kejadian</label>
              <input id="waktu" class="form-control" placeholder="Tanggal kejadian">
            </div>
            <div class="col-md-6">
              <label class="form-label">Lokasi Kejadian</label>
              <input id="lokasi" class="form-control" placeholder="Lokasi kejadian">
            </div>

            <div class="col-12">
              <label class="form-label">Keterangan Tambahan (misal: jenis luka / keterangan meninggal / ciri-ciri jika hilang)</label>
              <textarea id="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-12">
              <label class="form-label">Tujuan Surat (opsional)</label>
              <input id="tujuan" class="form-control" placeholder="Contoh: untuk pengajuan bantuan dan administrasi">
            </div>

            <div class="col-12 mt-2">
              <button class="btn btn-success" onclick="renderSurat()">Tampilkan Surat</button>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Surat tertampil di sini -->
    <div id="suratArea">
      <!-- akan di-generate oleh JS -->
    </div>

  </div>

<script>
function escapeHtml(text) {
  if (!text) return '';
  return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>');
}

function renderSurat(){
  const jenis = document.getElementById('jenisSurat').value;
  const instansi = escapeHtml(document.getElementById('instansi').value || '');
  const nama = escapeHtml(document.getElementById('nama').value);
  const nik = escapeHtml(document.getElementById('nik').value);
  const ttl = escapeHtml(document.getElementById('ttl').value);
  const jk = escapeHtml(document.getElementById('jk').value);
  const alamat = escapeHtml(document.getElementById('alamat').value);
  const waktu = escapeHtml(document.getElementById('waktu').value);
  const lokasi = escapeHtml(document.getElementById('lokasi').value);
  const keterangan = escapeHtml(document.getElementById('keterangan').value);
  const tujuan = escapeHtml(document.getElementById('tujuan').value || 'Surat ini dibuat untuk dipergunakan sebagaimana mestinya, antara lain sebagai syarat pengajuan bantuan, administrasi, dan keperluan hukum lainnya.');

  const kop = `
    <div class="kop">
      <div class="instansi">${instansi.replace(/<br>/g,'<br>')}</div>
      <div style="font-size:12px;">Alamat: .................................... Telp:  (   )</div>
    </div>`;

  let judul = '';
  let isiPernyataan = '';

  if (jenis === 'umum'){
    judul = 'SURAT KETERANGAN KORBAN BENCANA';
    isiPernyataan = `Dengan ini menerangkan bahwa saudara/i yang tersebut di bawah ini benar merupakan korban terdampak bencana yang terjadi pada ${waktu} di ${lokasi}.`;
  } else if (jenis === 'sakit'){
    judul = 'SURAT KETERANGAN KORBAN SAKIT / LUKA AKIBAT BENCANA';
    isiPernyataan = `Benar bahwa saudara/i tersebut mengalami sakit/luka akibat bencana pada ${waktu} di ${lokasi}. Keterangan medis / penanganan: ${keterangan}`;
  } else if (jenis === 'meninggal'){
    judul = 'SURAT KETERANGAN KORBAN MENINGGAL AKIBAT BENCANA';
    isiPernyataan = `Benar bahwa saudara/i yang tersebut di bawah ini telah meninggal dunia akibat bencana yang terjadi pada ${waktu} di ${lokasi}. Keterangan tambahan: ${keterangan}`;
  } else if (jenis === 'hilang'){
    judul = 'SURAT KETERANGAN ORANG HILANG / TIDAK DITEMUKAN';
    isiPernyataan = `Benar bahwa sampai dengan tanggal pembuatan surat ini, saudara/i tersebut dinyatakan hilang / tidak ditemukan setelah peristiwa bencana pada ${waktu} di ${lokasi}. Ciri-ciri / keterangan: ${keterangan}`;
  }

  const nomor = 'Nomor: __________ / SKB / ____ / ' + new Date().getFullYear();

  const identitas = `
    <table class="table table-borderless" style="max-width:720px;">
      <tbody>
        <tr><td class="field-label">Nama</td><td>: ${nama}</td></tr>
        <tr><td class="field-label">NIK</td><td>: ${nik}</td></tr>
        <tr><td class="field-label">Tempat/Tgl Lahir</td><td>: ${ttl}</td></tr>
        <tr><td class="field-label">Jenis Kelamin</td><td>: ${jk}</td></tr>
        <tr><td class="field-label">Alamat</td><td>: ${alamat}</td></tr>
      </tbody>
    </table>`;

  const badanSurat = `
    ${kop}
    <div style="text-align:center; margin-top:6px;">
      <h5 style="margin:0; font-weight:700">${judul}</h5>
      <div style="font-size:13px; margin-bottom:6px;">${nomor}</div>
    </div>

    <div style="margin-top:12px;">
      ${identitas}
      <p style="text-align:justify;">${isiPernyataan}</p>
      <p style="text-align:justify;">${tujuan}</p>
    </div>

    <div class="signature">
      <div style="float:right; text-align:center;">
        <div>........., ${new Date().toLocaleDateString('id-ID')}</div>
        <div>Mengetahui / Penanggung Jawab</div>
        <div style="height:70px;"></div>
        <div style="text-decoration:underline; font-weight:700">(....................)</div>
        <div>NIP: ..................</div>
      </div>
      <div style="clear:both;"></div>
    </div>
  `;

  document.getElementById('suratArea').innerHTML = '<div class="card"><div class="card-body">'+badanSurat+'</div></div>';
}

function resetForm(){
  document.getElementById('instansi').value = 'PEMERINTAH KABUPATEN XXX\nBADAN PENANGGULANGAN BENCANA DAERAH (BPBD)';
  document.getElementById('nama').value='';
  document.getElementById('nik').value='';
  document.getElementById('ttl').value='';
  document.getElementById('jk').value='';
  document.getElementById('alamat').value='';
  document.getElementById('waktu').value='';
  document.getElementById('lokasi').value='';
  document.getElementById('keterangan').value='';
  document.getElementById('tujuan').value='';
  renderSurat();
}

// initial render
renderSurat();
</script>
</div>
@endsection
