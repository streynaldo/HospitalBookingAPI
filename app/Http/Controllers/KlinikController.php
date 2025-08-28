<?php

namespace App\Http\Controllers;

use App\Models\Klinik;
use Illuminate\Http\Request;

class KlinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function show($klinikId)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Klinik $klinik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Klinik $klinik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Klinik $klinik)
    {
        //
    }

    public function getAllKlinik()
    {
        $klinik = Klinik::all();
        return response()->json(
            [
                'message' => 'Data klinik berhasil diambil',
                'data' => $klinik
            ]
        );
    }

    public function getKlinikById($klinikId)
    {
        $klinik = Klinik::find($klinikId);

        if (!$klinik) {
            return response()->json(['message' => 'Klinik tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data klinik berhasil diambil',
            'data' => $klinik
        ], 200);
    }
}
