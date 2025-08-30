<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
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
    public function create($dokterId)
    {
        $dokter = Dokter::findOrFail($dokterId);
        return view('dokter.jadwal.add', compact('dokter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $dokterId)
    {
        $request->validate([
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $request['dokter_id'] = $dokterId;

        // Simpan jadwal
        $jadwal = Jadwal::create($request->all());

        // Buat slot berdasarkan interval 30 menit
        try {
            $jamMulai = Carbon::createFromFormat('H:i', trim($request->jam_mulai));
            $jamSelesai = Carbon::createFromFormat('H:i', trim($request->jam_selesai));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Format waktu tidak valid. Pastikan format jam adalah HH:mm.']);
        }

        while ($jamMulai->lt($jamSelesai)) {
            $slotMulai = $jamMulai->format('H:i');
            $jamMulai->addMinutes(30);
            $slotSelesai = $jamMulai->format('H:i');

            // Simpan slot
            $jadwal->slots()->create([
                'slot_mulai' => $slotMulai,
                'slot_selesai' => $slotSelesai,
                'slot_mulai' => $slotMulai,
                'slot_selesai' => $slotSelesai,
            ]);
        }

        return redirect()->route('admin.dokter.show', $dokterId)
            ->with('success', 'Jadwal dan slot berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($dokterId, $jadwalId)
    {
        $dokter = Dokter::findOrFail($dokterId);
        $jadwal = Jadwal::findOrFail($jadwalId);
        return view('dokter.jadwal.edit', compact('jadwal', 'dokter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $jadwalId)
{
    $jadwal = Jadwal::findOrFail($jadwalId);

    $request->validate([
        'hari' => 'required|string|max:20',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i',
    ]);

    // Update jadwal
    $jadwal->update($request->all());

    // Hapus slot lama
    $jadwal->slots()->delete();

    try {
        // Bersihkan dan validasi format waktu
        $jamMulaiStr = trim($request->jam_mulai);
        $jamSelesaiStr = trim($request->jam_selesai);
        
        
        // Hapus karakter yang tidak terlihat
        $jamMulaiStr = preg_replace('/[^\d:]/', '', $jamMulaiStr);
        $jamSelesaiStr = preg_replace('/[^\d:]/', '', $jamSelesaiStr);
        
        // Validasi format waktu dengan regex
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $jamMulaiStr) || 
            !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $jamSelesaiStr)) {
            throw new \Exception('Format waktu tidak valid. Gunakan format HH:MM');
        }

        // Metode alternatif untuk membuat Carbon object
        $jamMulai = Carbon::today()->setTimeFromTimeString($jamMulaiStr);
        $jamSelesai = Carbon::today()->setTimeFromTimeString($jamSelesaiStr);
        

        // Validasi bahwa jam selesai lebih besar dari jam mulai
        if ($jamSelesai->lte($jamMulai)) {
            throw new \Exception('Jam selesai harus lebih besar dari jam mulai');
        }

        // Buat slot berdasarkan interval 30 menit
        $currentTime = $jamMulai->copy(); // Gunakan copy() untuk menghindari mutasi
        
        while ($currentTime->lt($jamSelesai)) {
            $slotMulai = $currentTime->format('H:i');
            $currentTime->addMinutes(30);
            
            // Pastikan slot selesai tidak melebihi jam selesai
            $slotSelesai = $currentTime->gt($jamSelesai) 
                ? $jamSelesai->format('H:i') 
                : $currentTime->format('H:i');

            // Simpan slot hanya jika masih dalam rentang waktu
            if ($currentTime->lte($jamSelesai)) {
                $jadwal->slots()->create([
                    'slot_mulai' => $slotMulai,
                    'slot_selesai' => $slotSelesai,
                ]);
            }
        }

    } catch (\Exception $e) {
        return redirect()->back()
            ->withErrors(['error' => 'Error dalam membuat slot: ' . $e->getMessage()])
            ->withInput();
    }

    return redirect()->route('admin.dokter.show', $jadwal->dokter_id)
        ->with('success', 'Jadwal dan slot berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($dokterId,$jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);
        $jadwal->delete();

        return redirect()->route('admin.dokter.show', $dokterId)
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    public function getJadwalByDokterId($dokterId)
    {
        $jadwals = Jadwal::where('dokter_id', $dokterId)->with('slots')->get();

        if ($jadwals->isEmpty()) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data jadwal dokter berhasil diambil',
            'data' => $jadwals
        ], 200);
    }
}
