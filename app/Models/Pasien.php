<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'nama',
        'dob',
        'jenis_kelamin',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function janjiTemus(){
        return $this->hasMany(JanjiTemu::class);
    }
}
