<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KorbanHilang extends Model
{
    protected $fillable = [
        'disaster_id',
        'nama',
        'usia',
        'jenis_kelamin',
        'alamat',
        'lokasi',
        'ciri_fisik',
        'barang_bawaan',
        'kontak_keluarga',
        'keterangan',
    ];

    public function disaster()
    {
        return $this->belongsTo(Disaster::class);
    }
}
