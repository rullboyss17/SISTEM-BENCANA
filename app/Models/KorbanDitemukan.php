<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KorbanDitemukan extends Model
{
    protected $fillable = [
        'disaster_id',
        'nama',
        'identified',
        'status_korban',
        'ciri_fisik',
        'barang_bawaan',
        'foto',
        'gps_lokasi',
        'posko_rujukan',
        'usia',
        'jenis_kelamin',
        'lokasi',
        'ciri_ciri',
        'status',
        'status_medis',
        'prioritas_medis',
        'kontak_keluarga',
        'keterangan',
    ];

    public function disaster()
    {
        return $this->belongsTo(Disaster::class);
    }
}
