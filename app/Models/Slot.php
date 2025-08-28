<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = [
        'slot_mulai',
        'slot_selesai',
        'jadwal_id',
    ];
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
    public function janjiTemus()
    {
        return $this->hasMany(JanjiTemu::class);
    }
}
