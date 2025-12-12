<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disaster extends Model
{
    protected $fillable = [
        'nama',
        'jenis',
        'lokasi',
        'status',
        'tanggal',
        'jumlah_korban',
    ];

    public function korbans()
    {
        return $this->hasMany(Korban::class);
    }
    public function korbanDitemukans()
    {
        return $this->hasMany(KorbanDitemukan::class);
    }
    public function korbanHilangs()
    {
        return $this->hasMany(KorbanHilang::class);
    }
}
