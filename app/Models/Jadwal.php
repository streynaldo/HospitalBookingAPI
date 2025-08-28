<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'jam_mulai',
        'jam_selesai',
        'hari',
        'dokter_id',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}
