<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Korban;
use App\Models\Disaster;
use App\Models\Posko;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
            'type' => 'required|in:korban,bencana,posko',
        ]);

        try {
            $file = $request->file('file');
            $type = $request->type;

            if ($type === 'korban') {
                $this->importKorban($file);
                $message = 'Data korban berhasil diimport!';
            } elseif ($type === 'bencana') {
                $this->importBencana($file);
                $message = 'Data bencana berhasil diimport!';
            } else {
                $this->importPosko($file);
                $message = 'Data posko berhasil diimport!';
            }

            return redirect()->route('import.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('import.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function importKorban($file)
    {
        $rows = Excel::toArray([], $file);
        $rowsData = $rows[0] ?? [];

        if (empty($rowsData)) {
            throw new \Exception('File kosong atau format tidak valid');
        }

        $headers = $rowsData[0] ?? [];
        $headersNormalized = array_map(function($h) {
            return strtolower(str_replace(' ', '_', trim($h)));
        }, $headers);

        // Jika baris pertama bukan header (misal langsung data), pakai header default urutan umum
        $requiredHeaders = ['nama', 'jenis_kelamin', 'status'];
        $hasRequired = count(array_intersect($requiredHeaders, $headersNormalized)) === count($requiredHeaders);
        if (!$hasRequired) {
            $headers = ['nama','usia','jenis_kelamin','alamat','lokasi','status','prioritas_medis','kebutuhan_medis','kontak_keluarga','keterangan'];
        }

        $dataRows = $hasRequired ? array_slice($rowsData, 1) : $rowsData;

        $normalizeKey = function ($value) {
            $cleaned = is_string($value) ? $value : (string) ($value ?? '');
            return strtolower(trim(preg_replace('/\s+/', ' ', $cleaned)));
        };

        foreach ($dataRows as $row) {
            if (!isset($row[0]) || !$row[0]) {
                continue;
            }

            $data = [];
            foreach ($headers as $index => $header) {
                $header = strtolower(str_replace(' ', '_', trim($header)));
                if (isset($row[$index])) {
                    $data[$header] = $row[$index];
                }
            }

            if (empty($data['nama'] ?? null)) {
                continue;
            }

            $nama = trim($data['nama'] ?? '');
            $lokasi = trim($data['lokasi'] ?? '');
            $alamat = trim($data['alamat'] ?? '');
            $kontak = trim($data['kontak_keluarga'] ?? '');
            $usia = isset($data['usia']) ? trim($data['usia']) : null;
            $statusKorban = trim($data['status'] ?? 'hilang');

            $namaKey = $normalizeKey($nama);
            $lokasiKey = $normalizeKey($lokasi);
            $alamatKey = $normalizeKey($alamat);
            $kontakKey = $normalizeKey($kontak);

            $jk = strtolower(trim($data['jenis_kelamin'] ?? ''));
            if (in_array($jk, ['laki-laki', 'l', 'laki'])) {
                $jk = 'L';
            } elseif (in_array($jk, ['perempuan', 'p'])) {
                $jk = 'P';
            } else {
                $jk = 'L';
            }

            $payload = [
                'nama' => $nama,
                'usia' => $usia,
                'jenis_kelamin' => $jk,
                'alamat' => $alamat ?: null,
                'lokasi' => $lokasi ?: null,
                'status' => $statusKorban ?: 'hilang',
                'kebutuhan_medis' => $data['kebutuhan_medis'] ?? null,
                'prioritas_medis' => $data['prioritas_medis'] ?? 'rendah',
                'status_medis' => $data['status_medis'] ?? null,
                'kontak_keluarga' => $kontak ?: null,
                'keterangan' => $data['keterangan'] ?? null,
            ];

            // Cari existing dengan prioritas:
            // 1) nama + kontak (jika kontak ada)
            // 2) nama + (alamat &/atau lokasi) untuk menyatu saat kontak baru ditambahkan
            $record = Korban::whereRaw('LOWER(TRIM(nama)) = ?', [$namaKey])
                ->where(function ($query) use ($kontakKey, $alamatKey, $lokasiKey) {
                    if ($kontakKey !== '') {
                        $query->whereRaw('LOWER(TRIM(kontak_keluarga)) = ?', [$kontakKey]);
                    }

                    if ($alamatKey !== '' || $lokasiKey !== '') {
                        $query->orWhere(function ($sub) use ($alamatKey, $lokasiKey) {
                            if ($alamatKey !== '') {
                                $sub->whereRaw('LOWER(TRIM(alamat)) = ?', [$alamatKey]);
                            }
                            if ($lokasiKey !== '') {
                                $sub->whereRaw('LOWER(TRIM(lokasi)) = ?', [$lokasiKey]);
                            }
                        });
                    }
                })
                ->first();

            if ($record) {
                $record->update($payload);
            } else {
                Korban::create($payload);
            }
        }
    }

    private function importBencana($file)
    {
        $rows = Excel::toArray([], $file);
        $rowsData = $rows[0] ?? [];

        if (empty($rowsData)) {
            throw new \Exception('File kosong atau format tidak valid');
        }

        $headers = $rowsData[0] ?? [];
        $dataRows = array_slice($rowsData, 1);

        foreach ($dataRows as $row) {
            if (!isset($row[0]) || !$row[0]) {
                continue;
            }

            $data = [];
            foreach ($headers as $index => $header) {
                $header = strtolower(str_replace(' ', '_', trim($header)));
                if (isset($row[$index])) {
                    $data[$header] = $row[$index];
                }
            }

            if (empty($data['nama'] ?? null)) {
                continue;
            }

            $nama = trim($data['nama'] ?? '');
            $lokasi = trim($data['lokasi'] ?? '');
            $jenis = trim($data['jenis'] ?? '');
            $status = trim($data['status'] ?? 'aktif');
            $tanggal = $data['tanggal'] ?? now()->format('Y-m-d');

            $namaKey = strtolower(preg_replace('/\s+/', ' ', $nama));
            $lokasiKey = strtolower(preg_replace('/\s+/', ' ', $lokasi));

            $payload = [
                'nama' => $nama,
                'lokasi' => $lokasi,
                'jenis' => $jenis,
                'status' => $status ?: 'aktif',
                'tanggal' => $tanggal,
            ];

            $existing = Disaster::whereRaw('LOWER(TRIM(nama)) = ?', [$namaKey])
                ->whereRaw('LOWER(TRIM(lokasi)) = ?', [$lokasiKey])
                ->first();

            if ($existing) {
                $existing->update($payload);
            } else {
                Disaster::create($payload);
            }
        }
    }

    private function importPosko($file)
    {
        $rows = Excel::toArray([], $file);
        $rowsData = $rows[0] ?? [];

        if (empty($rowsData)) {
            throw new \Exception('File kosong atau format tidak valid');
        }

        $headers = $rowsData[0] ?? [];
        $headersNormalized = array_map(function ($h) {
            return strtolower(str_replace(' ', '_', trim($h)));
        }, $headers);

        // Petakan variasi header (misal "Nama Posko" -> nama)
        $mappedHeaders = array_map(function ($h) {
            return match ($h) {
                'nama_posko', 'posko' => 'nama',
                'kontak_posko' => 'kontak',
                default => $h,
            };
        }, $headersNormalized);

        $requiredHeaders = ['nama', 'lokasi'];
        $hasRequired = count(array_intersect($requiredHeaders, $mappedHeaders)) === count($requiredHeaders);

        if (!$hasRequired) {
            $headers = ['nama', 'lokasi', 'kapasitas', 'terisi', 'kontak', 'petugas', 'status', 'catatan'];
            $mappedHeaders = $headers; // fallback ke header baku
        }

        $dataRows = $hasRequired ? array_slice($rowsData, 1) : $rowsData;

        foreach ($dataRows as $row) {
            if (!isset($row[0]) || !$row[0]) {
                continue;
            }

            $data = [];
            foreach ($mappedHeaders as $index => $header) {
                if (isset($row[$index])) {
                    $data[$header] = $row[$index];
                }
            }

            // Deteksi baris header yang ikut terbaca (misal baris pertama bukan di-skip karena header tak dikenali)
            $firstCell = strtolower(trim((string) ($row[0] ?? '')));
            if (in_array($firstCell, ['nama posko', 'nama', 'posko'])) {
                // Jika baris ini terlihat seperti header (kapasitas, lokasi, dsb)
                $maybeHeaders = array_map(function ($cell) {
                    return strtolower(trim((string) $cell));
                }, $row);
                if (in_array('lokasi', $maybeHeaders) || in_array('kapasitas', $maybeHeaders)) {
                    continue;
                }
            }

            if (empty($data['nama'] ?? null) || empty($data['lokasi'] ?? null)) {
                continue;
            }

            $nama = trim($data['nama']);
            $lokasi = trim($data['lokasi']);
            $kapasitas = isset($data['kapasitas']) ? (int) $data['kapasitas'] : 0;
            $terisi = isset($data['terisi']) ? (int) $data['terisi'] : 0;
            $status = trim($data['status'] ?? 'Aktif');

            $payload = [
                'nama' => $nama,
                'lokasi' => $lokasi,
                'kapasitas' => max(0, $kapasitas),
                'terisi' => min(max(0, $terisi), max(0, $kapasitas)),
                'kontak' => $data['kontak'] ?? null,
                'petugas' => $data['petugas'] ?? null,
                'status' => $status ?: 'Aktif',
                'catatan' => $data['catatan'] ?? null,
            ];

            $namaKey = strtolower(preg_replace('/\s+/', ' ', $nama));
            $lokasiKey = strtolower(preg_replace('/\s+/', ' ', $lokasi));

            $existing = Posko::whereRaw('LOWER(TRIM(nama)) = ?', [$namaKey])
                ->whereRaw('LOWER(TRIM(lokasi)) = ?', [$lokasiKey])
                ->first();

            if ($existing) {
                $existing->update($payload);
            } else {
                Posko::create($payload);
            }
        }
    }
}
