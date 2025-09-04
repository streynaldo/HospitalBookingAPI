<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\JanjiTemu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $janjiTemus = JanjiTemu::with(['pasien', 'dokter', 'slot'])->paginate(10);
        // dd($janjiTemus);
        return view('janjitemu.index', compact('janjiTemus'));
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
    public function edit($janjiTemuId)
    {
        $janjitemu = JanjiTemu::with(['pasien', 'dokter', 'slot'])->findOrFail($janjiTemuId);

        // Get available days for the doctor
        $dokterHariTersedia = Jadwal::where('dokter_id', $janjitemu->dokter_id)
            ->pluck('hari')
            ->toArray();

        // Map English day names to Indonesian
        $hariArray = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        // Get the day of the week in Indonesian
        $hari = $hariArray[date('l', strtotime($janjitemu->tanggal))];

        // Fetch all slots for the doctor on the selected date
        $slots = [];
        if ($janjitemu->tanggal) {
            $slots = Jadwal::where('dokter_id', $janjitemu->dokter_id)
                ->where('hari', $hari)
                ->with('slots') // Ensure the slot relationship is loaded
                ->get()
                ->pluck('slots')
                ->flatten();
        }
        // dd($slots);

        return view('janjitemu.edit', compact('janjitemu', 'dokterHariTersedia', 'slots'));
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
        $janjiTemu = JanjiTemu::findOrFail($janjiTemuId);
        $janjiTemu->delete();
        return redirect()->route('admin.janjitemu.index')->with('success', 'Janji temu berhasil dihapus.');
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

        $user = User::find($userId);
        $pasien = Pasien::find($validatedData['pasien_id']);

        if ($user->nama == $pasien->nama && $user->dob == $pasien->dob) {
            $validatedData['tipe_pasien'] = 'diri_sendiri';
        } else {
            $validatedData['tipe_pasien'] = 'orang_lain';
        }

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
