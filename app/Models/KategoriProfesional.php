<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProfesional extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function profesionals()
    {
        return $this->hasMany(Profesional::class);
    }
}
