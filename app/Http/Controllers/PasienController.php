<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasiens = Pasien::paginate(10);

        return view('pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($pasienId)
    {
        //  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($pasienId)
    {
        $pasien = Pasien::find($pasienId);
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $pasienId)
    {
        $pasien = Pasien::find($pasienId);
        $request->validate([
            'nama' => 'required|string|max:255',
            'dob' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);
        $pasien->update($request->all());
        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pasienId)
    {
        $pasien = Pasien::find($pasienId);
        $pasien->delete();
        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil dihapus');
    }

    public function createPasien(Request $request)
    {
        $id = Auth::id();

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'dob' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);
        $validatedData['user_id'] = $id;
        $pasien = Pasien::create($validatedData);
        return response()->json([
            'message' => 'Pasien baru berhasil ditambahkan',
            'data' => $pasien
        ], 201);
    }

    public function getPasienById($pasienId)
    {
        $user_id = Auth::id();

        $pasien = Pasien::find($pasienId);

        if($pasien->user_id !== $user_id){
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        if (!$pasien) {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }

        return response()->json([
            "message" => "Data pasien ditemukan",
            'data' => $pasien
        ], 200);
    }

    public function getPasienByUserId()
    {
        $userId = Auth::id();
        $pasien = Pasien::where('user_id', $userId)->get();

        if (!$pasien) {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }

        return response()->json([
            "message" => "Data pasien ditemukan",
            'data' => $pasien
        ], 200);
    }

    public function updatePasienById(Request $request, $pasienId)
    {
        $user_id = Auth::id();

        $pasien = Pasien::find($pasienId);

        if (!$pasien) {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }

        if($pasien->user_id !== $user_id){
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'dob' => 'sometimes|required|date',
            'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
        ]);

        $pasien->update($validatedData);

        return response()->json(['message' => 'Data pasien berhasil diperbarui', 'data' => $pasien], 200);
    }

    public function deletePasienById($pasienId)
    {
        $pasien = Pasien::find($pasienId);

        if (!$pasien) {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }

        if($pasien->user_id !== Auth::id()){
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $pasien->delete();

        return response()->json(['message' => 'Data pasien berhasil dihapus'], 200);
    }
}
