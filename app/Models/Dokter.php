<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = 
    [
        'nama', 
        'spesialis',
        'gambar',
        'klinik_id'
    ];

    public function klinik()
    {
        return $this->belongsTo(Klinik::class);
    }
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
    public function janjiTemus()
    {
        return $this->hasMany(JanjiTemu::class);
    }
    public function profesionals()
    {
        return $this->hasMany(Profesional::class);
    }
}
