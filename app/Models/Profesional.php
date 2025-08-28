<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    protected $fillable = [
        'deskripsi',
        'tahun',
        'kategori_profesional_id',
        'dokter_id',
    ];
    public function kategori_profesional()
    {
        return $this->belongsTo(Kategoriprofesional::class);
    }
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
