<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    protected $fillable = [
        'tanggal',
        'tipe_pasien',
        'pasien_id',
        'dokter_id',
        'slot_id',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
