<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'no_telp'  => 'nullable|string|max:15',
            'dob'      => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
        ]);

        $user = User::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'no_telp'  => $data['no_telp'] ?? null,
            'dob'      => $data['dob'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
        ]);

        $user->assignRole('pasien');

        Pasien::create([
            'nama' => $data['nama'],
            'dob' => $data['dob'] ?? null,
            'user_id' => $user->id,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
        ]);

        // abilities sesuai role
        $abilities = ['doctor.read'];

        // buat token baru
        $token = $user->createToken('api-token', $abilities);

        return response()->json([
            'token_type' => 'Bearer',
            'token'      => $token->plainTextToken,
            'abilities'  => $abilities,
            'user'       => $user,
        ], 201);
    }

    public function login(Request $r)
    {
        $r->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $r->email)->first();

        if (! $user || ! Hash::check($r->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // abilities sesuai role
        $abilities = ['doctor.read'];

        // hapus token lama biar cuma ada satu token aktif
        $user->tokens()->where('name', 'api-token')->delete();

        // buat token baru
        $token = $user->createToken('api-token', $abilities);

        return response()->json([
            'token_type' => 'Bearer',
            'token'      => $token->plainTextToken,
            'abilities'  => $abilities,
            'user'       => $user,
            'message'    => 'Login successful',
        ]);
    }

    public function logout(Request $r)
    {
        $r->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
