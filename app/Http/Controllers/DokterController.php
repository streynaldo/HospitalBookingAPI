<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
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
    public function show(Dokter $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $doctor)
    {
        //
    }

    public function getAllDokter()
    {
        $dokters = Dokter::all();
        return response()->json(
            [
                'message' => 'Data dokter ditemukan',
                'data' => $dokters
            ]
        );
    }

    public function getAllDokterByKlinikId($klinikId, Request $r)
    {
        $data = Dokter::where('klinik_id', $klinikId)->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'Tidak ada Dokter di klinik ini'], 404);
        }

        return response()->json([
            'message' => 'Data dokter ditemukan',
            'data' => $data
        ], 200);
    }

    private function authorizeAbility(Request $r, string $ability)
    {
        abort_unless(collect($r->user()->currentAccessToken()->abilities ?? [])->contains($ability), 403, 'Forbidden');
    }
}
