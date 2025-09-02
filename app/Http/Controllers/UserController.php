<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use App\Models\Klinik;
use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function indexUser(){
        $users = User::role('pasien')->paginate(10); // Filter pengguna dengan peran 'admin'
        return view('user.index', compact('users'));
    }
    public function indexAdmin(){
        $users = User::role('admin')->paginate(10); // Filter pengguna dengan peran 'admin'
        return view('admin.index', compact('users'));
    }

    public function index(){
        $pasien = Pasien::count();
        $user = User::count();
        $klinik = Klinik::count();
        $dokter = Dokter::count();

        // dd($pasien);

        return view('dashboard', compact('pasien', 'user', 'klinik', 'dokter'));
    }

    public function create(){
        return view('user.add');
    }
    public function createAdmin(){
        return view('admin.add');
    }

    public function store(Request $request){
        $data = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'no_telp'  => 'required|string|max:15',
            'dob'      => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $user->assignRole('admin');

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($userId){
        $user = User::findOrFail($userId);
        return view('user.edit', compact('user'));
    }
    public function editAdmin($userId){
        $user = User::findOrFail($userId);
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, $userId){
        $user = User::findOrFail($userId);

        $data = $request->validate([
            'nama'     => 'sometimes|required|string|max:100',
            'email'    => 'sometimes|required|email|unique:users,email,' . $user->id,
            'no_telp'  => 'required|string|max:15',
            'dob'      => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        if ($user->hasRole('pasien')) {
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
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
    }
    public function updateAdmin(Request $request, $userId){
        $user = User::findOrFail($userId);

        $data = $request->validate([
            'nama'     => 'sometimes|required|string|max:100',
            'email'    => 'sometimes|required|email|unique:users,email,' . $user->id,
            'no_telp'  => 'required|string|max:15',
            'dob'      => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil diupdate');
    }

    public function destroy($userId){
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
    public function destroyAdmin($userId){
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil dihapus');
    }

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
