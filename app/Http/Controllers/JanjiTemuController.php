<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Slot;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\JanjiTemu;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Services\ApnsService;
use Illuminate\Support\Carbon;
use App\Jobs\SendJanjiTemuReminder;
use Illuminate\Support\Facades\Log;
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

    public function createJanjiTemu(Request $request, ApnsService $apns)
    {
        $userId = Auth::id();
        $validatedData = $request->validate([
            'tanggal'   => 'required|date',          // format Y-m-d
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'slot_id'   => 'required|exists:slots,id',
        ]);

        $user   = User::find($userId);
        $pasien = Pasien::find($validatedData['pasien_id']);

        if ($user->nama == $pasien->nama && $user->dob == $pasien->dob) {
            $validatedData['tipe_pasien'] = 'diri_sendiri';
        } else {
            $validatedData['tipe_pasien'] = 'orang_lain';
        }

        if (Pasien::where('id', $validatedData['pasien_id'])->where('user_id', $userId)->doesntExist()) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        // tanggal harus >= hari ini
        if (strtotime($validatedData['tanggal']) < strtotime(date('Y-m-d'))) {
            return response()->json(['message' => 'Tanggal janji temu harus ≥ hari ini'], 400);
        }

        // tidak bentrok cuti
        $cuti = Cuti::where('dokter_id', $validatedData['dokter_id'])
            ->where('tanggal_mulai', '<=', $validatedData['tanggal'])
            ->where('tanggal_selesai', '>=', $validatedData['tanggal'])
            ->exists();
        if ($cuti) {
            return response()->json(['message' => 'Tanggal janji temu bertabrakan dengan jadwal cuti dokter'], 400);
        }

        // hari sesuai jadwal dokter
        $hariArray = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = $hariArray[date('w', strtotime($validatedData['tanggal']))];
        $jadwalExists = Jadwal::where('dokter_id', $validatedData['dokter_id'])
            ->where('hari', $hari)
            ->exists();
        if (!$jadwalExists) {
            return response()->json(['message' => 'Hari pada jadwal janji temu tidak sesuai dengan jadwal dokter'], 400);
        }

        // === Simpan janji temu ===
        $janjiTemu = JanjiTemu::create($validatedData);

        // === Kirim KONFIRMASI sekarang (opsional, enak untuk UX) ===
        $tokens = DeviceToken::where('user_id', $userId)->where('platform', 'ios')->pluck('token');
        // if ($tokens->isNotEmpty()) {
        //     $tz = config('app.timezone', 'Asia/Jakarta');
        //     $slot = Slot::find($validatedData['slot_id']);
        //     // GANTI kalau nama kolom beda:
        //     $slotStart = $slot?->slot_mulai; // 'HH:mm'
        //     $startAt   = $slotStart ? Carbon::parse("{$validatedData['tanggal']} {$slotStart}", $tz) : null;
        //     $jamTgl    = $startAt ? $startAt->translatedFormat('d M Y, H:i') : $validatedData['tanggal'];

        //     foreach ($tokens as $t) {
        //         $apns->sendAlert(
        //             deviceToken: $t,
        //             title: 'Konfirmasi Janji Temu',
        //             body: "Janji temu kamu terjadwal pada {$jamTgl}.",
        //             badge: 1,
        //             custom: [
        //                 'type'        => 'appointment_created',
        //                 'janji_temu'  => $janjiTemu->id,
        //                 'dokter_id'   => $janjiTemu->dokter_id,
        //             ]
        //         );
        //     }
        // }

        // === Jadwalkan REMINDER H-60 ===
        $this->scheduleReminderHMinus60($janjiTemu->id, $validatedData['tanggal'], $validatedData['slot_id']);


        Log::info('Janji temu created', ['janji_temu_id' => $janjiTemu->id, 'user_id' => $userId]);

        return response()->json([
            'message' => 'Janji temu berhasil dibuat',
            'data'    => $janjiTemu
        ], 201);
    }

    public function updateJanjiTemuById(Request $request, $janjiTemuId)
    {
        $userId = Auth::id();

        $validatedData = $request->validate([
            'tanggal'   => 'required|date',
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'slot_id'   => 'required|exists:slots,id',
        ]);

        $janjiTemu = JanjiTemu::with(['pasien'])->findOrFail($janjiTemuId);
        if ($janjiTemu->pasien->user_id !== $userId) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        // tanggal ≥ hari ini
        if (strtotime($validatedData['tanggal']) < strtotime(date('Y-m-d'))) {
            return response()->json(['message' => 'Tanggal janji temu harus ≥ hari ini'], 400);
        }

        // tidak bentrok cuti
        $cuti = Cuti::where('dokter_id', $validatedData['dokter_id'])
            ->where('tanggal_mulai', '<=', $validatedData['tanggal'])
            ->where('tanggal_selesai', '>=', $validatedData['tanggal'])
            ->exists();
        if ($cuti) {
            return response()->json(['message' => 'Tanggal janji temu bertabrakan dengan jadwal cuti dokter'], 400);
        }

        // hari sesuai jadwal dokter
        $hariArray = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = $hariArray[date('w', strtotime($validatedData['tanggal']))];
        $jadwalExists = Jadwal::where('dokter_id', $validatedData['dokter_id'])
            ->where('hari', $hari)
            ->exists();
        if (!$jadwalExists) {
            return response()->json(['message' => 'Hari pada jadwal janji temu tidak sesuai dengan jadwal dokter'], 400);
        }

        $janjiTemu->update($validatedData);

        // Jadwalkan ulang REMINDER H-60; job akan self-guard jika jadwal lama masih ada
        $this->scheduleReminderHMinus60($janjiTemu->id, $validatedData['tanggal'], $validatedData['slot_id']);

        return response()->json([
            'message' => 'Janji temu berhasil diperbarui',
            'data'    => $janjiTemu
        ], 200);
    }

    public function deleteJanjiTemuById($janjiTemuId)
    {
        $janjiTemu = JanjiTemu::with(['pasien'])->findOrFail($janjiTemuId);
        $userId = Auth::id();
        if ($janjiTemu->pasien->user_id !== $userId) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }
        $janjiTemu->delete();

        // Tidak perlu cancel job: saat eksekusi nanti job akan cek janjiTemu sudah tidak ada → langsung return
        return response()->json(['message' => 'Janji temu berhasil dihapus'], 200);
    }

    private function scheduleReminderHMinus60(int $janjiTemuId, string $tanggal, int $slotId): void
    {
        $tz   = config('app.timezone', 'Asia/Jakarta');
        $slot = Slot::find($slotId);

        // GANTI kolom ini sesuai schema:
        $slotStart = $slot?->slot_mulai; // 'HH:mm'
        if (!$slotStart) {
            // log error supaya kamu tahu kolom slot yang dipakai
            Log::warning('Slot start time column missing for reminder', ['slot_id' => $slotId]);
            return;
        }

        $startAtLocal = Carbon::parse("{$tanggal} {$slotStart}", $tz);
        $remindAtLocal = $startAtLocal->copy()->subMinutes(60);

        // Jangan jadwalkan masa lalu
        if ($remindAtLocal->isPast()) return;

        // Simpan expectedStartAt (UTC ISO) untuk verifikasi saat job jalan
        $expectedUtcIso = $startAtLocal->copy()->utc()->toIso8601String();

        SendJanjiTemuReminder::dispatch(
            janjiTemuId: $janjiTemuId,
            expectedStartAtIso: $expectedUtcIso
        )->delay($remindAtLocal);
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

    public function getAllJanjiTemuByUserId()
    {
        $userId = Auth::id();
        $janjiTemu = JanjiTemu::whereHas('pasien', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['pasien', 'dokter', 'slot'])->get();

        return response()->json([
            'message' => 'Data janji temu berhasil diambil',
            'data' => $janjiTemu
        ], 200);
    }
}
