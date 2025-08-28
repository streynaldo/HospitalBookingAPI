<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getLoggedInUser()
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id);
        $filteredData = $user->only(['id', 'nama', 'email', 'no_telp', 'dob', 'jenis_kelamin', 'created_at', 'updated_at']);
        return response()->json([
            "message" => "Data akun berhasil didapatkan",
            "data" => $filteredData
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id);

        $data = $request->validate([
            'nama'     => 'sometimes|required|string|max:100',
            'email'    => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:6',
            'no_telp'  => 'required|string|max:15',
            'dob'      => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $pasien = Pasien::where('user_id', $user->id)
            ->where('nama', $user->nama)
            ->where('dob', $user->dob)
            ->first();
        if ($pasien) {
            $pasien->update([
                'nama' => $data['nama'] ?? $pasien->nama,
                'dob' => $data['dob'] ?? $pasien->dob,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? $pasien->jenis_kelamin,
            ]);
        }

        $user->update($data);

        return response()->json(['message' => 'Profile berhasil diubah', 'user' => $user]);
    }

    public function deleteAccount()
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id);
        $user->delete();

        return response()->json(['message' => 'Akun berhasil dihapus']);
    }
}
