<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    /** @use HasFactory<\Database\Factories\KorbanFactory> */
    use HasFactory;

    protected $fillable = [
        'disaster_id',
        'nama',
        'usia',
        'jenis_kelamin',
        'alamat',
        'lokasi',
        'status',
        'kebutuhan_medis',
        'prioritas_medis',
        'status_medis',
        'kontak_keluarga',
        'keterangan',
    ];

    public function disaster()
    {
        return $this->belongsTo(Disaster::class);
    }
}
