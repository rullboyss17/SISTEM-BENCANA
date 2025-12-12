<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posko extends Model
{
    protected $fillable = [
        'nama',
        'lokasi',
        'kapasitas',
        'terisi',
        'kontak',
        'petugas',
        'status',
        'catatan',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
        'terisi' => 'integer',
    ];
}
