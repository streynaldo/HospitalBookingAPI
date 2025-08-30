<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dokter extends Model
{
    protected $fillable = 
    [
        'nama', 
        'spesialis',
        'gambar',
        'klinik_id',
        'gambar_url'
    ];

    // protected $appends = ['gambar_url'];

    // public function getGambarUrlAttribute(): ?string
    // {
    //     if (!$this->gambar) {
    //         return asset('image/dokter.webp');
    //     }
    //     if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://') || str_starts_with($this->gambar, '/')) {
    //         return $this->gambar;
    //     }
    //     return Storage::disk('public')->url($this->gambar); // butuh `php artisan storage:link`
    // }

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

    public function cutis()
    {
        return $this->hasMany(Cuti::class);
    }
}
