<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = [
        'platform',
        'token',
        'last_seen_at',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
