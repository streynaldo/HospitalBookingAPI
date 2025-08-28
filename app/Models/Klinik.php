<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klinik extends Model
{
    protected $fillable = [
        'nama', 
        'deskripsi',
        'gambar',
        'icon'
    ];

    public function dokter()
    {
        return $this->hasMany(Dokter::class);
    }
}
