<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(JanjiTemu $janjiTemu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JanjiTemu $janjiTemu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $janjiTemuId)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($janjiTemuId)
    {
        //
    }

    public function createJanjiTemu(Request $request)
    {
        $userId = Auth::id();
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'slot_id' => 'required|exists:slots,id',
        ]);

        if (Pasien::where('id', $validatedData['pasien_id'])->where('user_id', $userId)->doesntExist()) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        // check apakah tanggal janji temu lebih dari hari ini
        if (strtotime($validatedData['tanggal']) < strtotime(date('Y-m-d'))) {
            return response()->json(['message' => 'Tanggal janji temu harus lebih dari atau sama dengan hari ini'], 400);
        }

        // check apakah tanggal janji temu tidak bertabrakan dengan tanggal mulai hingga tanggal akhir cuti dokter
        $cuti = Cuti::where('dokter_id', $validatedData['dokter_id'])
            ->where('tanggal_mulai', '<=', $validatedData['tanggal'])
            ->where('tanggal_selesai', '>=', $validatedData['tanggal'])
            ->exists();

        if ($cuti) {
            return response()->json(['message' => 'Tanggal janji temu bertabrakan dengan jadwal cuti dokter'], 400);
        }

        // check apakah hari pada jadwal janji temu sudah sesuai dengan hari pada jadwal dokter (hari nya dalam bahasa indonesia)
        $hariArray = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = $hariArray[date('w', strtotime($validatedData['tanggal']))];
        $jadwalExists = Jadwal::where('dokter_id', $validatedData['dokter_id'])
            ->where('hari', $hari)
            ->exists();
        if (!$jadwalExists) {
            return response()->json(['message' => 'Hari pada jadwal janji temu tidak sesuai dengan hari pada jadwal dokter'], 400);
        }

        $janjiTemu = JanjiTemu::create($validatedData);
        return response()->json([
            'message' => 'Janji temu berhasil dibuat',
            'data' => $janjiTemu
        ], 201);
    }

    public function updateJanjiTemuById(Request $request, $janjiTemuId)
    {
        $userId = Auth::id();

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'slot_id' => 'required|exists:slots,id',
        ]);

        $janjiTemu = JanjiTemu::findOrFail($janjiTemuId);
        if ($janjiTemu->pasien->user_id !== $userId) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        // check apakah tanggal janji temu lebih dari hari ini
        if (strtotime($validatedData['tanggal']) < strtotime(date('Y-m-d'))) {
            return response()->json(['message' => 'Tanggal janji temu harus lebih dari atau sama dengan hari ini'], 400);
        }

        // check apakah tanggal janji temu tidak bertabrakan dengan tanggal mulai hingga tanggal akhir cuti dokter
        $cuti = Cuti::where('dokter_id', $validatedData['dokter_id'])
            ->where('tanggal_mulai', '<=', $validatedData['tanggal'])
            ->where('tanggal_selesai', '>=', $validatedData['tanggal'])
            ->exists();

        if ($cuti) {
            return response()->json(['message' => 'Tanggal janji temu bertabrakan dengan jadwal cuti dokter'], 400);
        }

        // check apakah hari pada jadwal janji temu sudah sesuai dengan hari pada jadwal dokter (hari nya dalam bahasa indonesia)
        $hariArray = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = $hariArray[date('w', strtotime($validatedData['tanggal']))];
        $jadwalExists = Jadwal::where('dokter_id', $validatedData['dokter_id'])
            ->where('hari', $hari)
            ->exists();
        if (!$jadwalExists) {
            return response()->json(['message' => 'Hari pada jadwal janji temu tidak sesuai dengan hari pada jadwal dokter'], 400);
        }

        $janjiTemu->update($validatedData);

        return response()->json([
            'message' => 'Janji temu berhasil diperbarui',
            'data' => $janjiTemu
        ], 200);
    }

    public function deleteJanjiTemuById($janjiTemuId)
    {
        
        $janjiTemu = JanjiTemu::findOrFail($janjiTemuId);
        $userId = Auth::id();
        if ($janjiTemu->pasien->user_id !== $userId) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }
        $janjiTemu->delete();

        return response()->json(['message' => 'Janji temu berhasil dihapus'], 200);
    }

    public function checkTotalPasien($slotId, $tanggal)
    {
        $exists = JanjiTemu::where('slot_id', $slotId)
            ->where('tanggal', $tanggal)
            ->count();

        return response()->json([
            'message' => 'Total pasien berhasil dihitung',
            'total_pasien' => $exists
        ], 200);
    }

    public function getAllJanjiTemuByUserId(){
        $userId = Auth::id();
        $janjiTemu = JanjiTemu::whereHas('pasien', function($query) use ($userId){
            $query->where('user_id', $userId);
        })->with(['pasien', 'dokter', 'slot'])->get();

        return response()->json([
            'message' => 'Data janji temu berhasil diambil',
            'data' => $janjiTemu
        ], 200);
    }
}
