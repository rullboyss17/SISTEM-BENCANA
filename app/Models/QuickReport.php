<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickReport extends Model
{
    protected $fillable = [
        'foto_path',
        'jumlah_korban',
        'lokasi',
        'waktu',
        'keterangan',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];
}
