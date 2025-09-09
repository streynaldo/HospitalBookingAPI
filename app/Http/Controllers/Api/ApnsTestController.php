<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ApnsService;
use App\Http\Controllers\Controller;

class ApnsTestController extends Controller
{
    public function sendToToken(Request $r, ApnsService $apns)
    {
        $data = $r->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body'  => 'nullable|string',
        ]);
        $resp = $apns->sendAlert($data['token'], $data['title'], $data['body'] ?? null, 1, [
            // custom payload kalau perlu:
            // 'deeplink' => 'fitnessku://agenda/123',
        ]);
        return response()->json($resp);
    }

    public function sendToUser(Request $r, ApnsService $apns, $userId)
    {
        $data = $r->validate([
            'title' => 'required|string',
            'body'  => 'nullable|string',
        ]);

        $user = User::findOrFail($userId);
        $tokens = $user->deviceTokens()->where('platform', 'ios')->pluck('token');
        $results = [];
        foreach ($tokens as $t) {
            $results[] = $apns->sendAlert($t, $data['title'], $data['body'] ?? null);
        }
        return response()->json([
            'success' => true,
            'results' => $results,
        ]);
    }
}
