<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Dokter;
use Illuminate\Http\Request;

class CutiController extends Controller
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
        $dokter = Dokter::find($dokterId);
        return view('dokter.cuti.add', compact('dokter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $dokter_id)
    {
        $data = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);
        $data['dokter_id'] = $dokter_id;

        Cuti::create($data);

        return redirect()->route('admin.dokter.show', $dokter_id)
            ->with('success', 'Data cuti berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuti $cuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($cutiId)
    {
        $dokter = Dokter::findOrFail(Cuti::findOrFail($cutiId)->dokter_id);
        $cuti = Cuti::findOrFail($cutiId);
        // dd($cuti);
        return view('dokter.cuti.edit', compact('cuti', 'dokter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cutiId)
    {
        $cuti = Cuti::findOrFail($cutiId);
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $cuti->update($request->all());

        return redirect()->route('admin.dokter.show', $cuti->dokter->id)
            ->with('success', 'Data cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cutiId)
    {
        $cuti = Cuti::findOrFail($cutiId);
        $dokter = Dokter::findOrFail($cuti->dokter_id);
        $cuti->delete();

        return redirect()->route('admin.dokter.show', $dokter->id)
            ->with('success', 'Data cuti berhasil dihapus.');
    }

    public function getCutiByDokterId($dokterId)
    {
        // ambil satu data cuti trakhir
        $cuti = Cuti::where('dokter_id', $dokterId)->latest()->first();
        
        if (!$cuti) {
            return response()->json([
                'message' => 'Data cuti tidak ditemukan',
                'data' => null
            ], 200);
        }

        return response()->json([
            'message' => 'Data cuti berhasil diambil',
            'data' => $cuti
        ], 200);
    }
}
