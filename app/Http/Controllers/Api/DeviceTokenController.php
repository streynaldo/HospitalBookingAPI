<?php

namespace App\Http\Controllers\Api;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceTokenController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'token' => 'required|string',
            'platform' => 'nullable|in:ios,android'
        ]);

        $token = DeviceToken::updateOrCreate(
            ['token' => $data['token']],
            [
                'user_id' => $r->user()->id,          // pastikan route pakai auth (Sanctum/JWT)
                'platform' => $data['platform'] ?? 'ios',
                'last_seen_at' => now(),
            ]
        );

        return response()->json(['ok' => true, 'id' => $token->id]);
    }
}
