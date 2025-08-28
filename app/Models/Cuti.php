<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai',
        'dokter_id',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
