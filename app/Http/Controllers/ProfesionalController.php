<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\KategoriProfesional;
use App\Models\Profesional;
use Illuminate\Http\Request;

class ProfesionalController extends Controller
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
        $kategoriProfesional = KategoriProfesional::all();
        $dokter = Dokter::findOrFail($dokterId);
        return view('dokter.profesional.add', compact('kategoriProfesional', 'dokter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $dokterId)
    {
        
        $request->validate([
            'deskripsi' => 'required|string',
            'tahun' => 'required|string|max:4',
            'kategori_profesional_id' => 'required|exists:kategori_profesionals,id',

        ]);
        // dd('here');
        $data = $request->all();
        $data['dokter_id'] = $dokterId;

        Profesional::create($data);

        return redirect()->route('admin.dokter.show', $dokterId)
            ->with('success', 'Data profesional berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profesional $profesional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($profesionalId)
    {
        $profesional = Profesional::findOrFail($profesionalId);
        $kategoriProfesional = KategoriProfesional::all();
        $dokter = Dokter::findOrFail($profesional->dokter_id);
        return view('dokter.profesional.edit', compact('profesional', 'kategoriProfesional', 'dokter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $profesionalId)
    {
        $profesional = Profesional::findOrFail($profesionalId);

        $request->validate([
            'deskripsi' => 'required|string',
            'tahun' => 'required|string|max:4',
            'kategori_profesional_id' => 'required|exists:kategori_profesionals,id',
        ]);

        $profesional->update($request->all());

        return redirect()->route('admin.dokter.show', $profesional->dokter_id)
            ->with('success', 'Data profesional berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profesional $profesional)
    {
        //
    }

    public function getRiwayatPendidikanByDokterId($dokterId)
    {
        $riwayatPendidikan = Profesional::where('dokter_id', $dokterId)
            ->whereHas('kategori_profesional', function ($q) {
                $q->where('nama', 'Riwayat Pendidikan');
            })
            ->with('kategori_profesional')
            ->get();

        return response()->json($riwayatPendidikan);
    }
    public function getPengalamanByDokterId($dokterId)
    {
        $pengalamanPraktik = Profesional::where('dokter_id', $dokterId)
            ->whereHas('kategori_profesional', function ($q) {
                $q->where('nama', 'Pengalaman Praktik');
            })
            ->with('kategori_profesional')
            ->get();

        return response()->json($pengalamanPraktik);
    }
    public function getPrestasiByDokterId($dokterId)
    {
        $prestasiPenghargaan = Profesional::where('dokter_id', $dokterId)
            ->whereHas('kategori_profesional', function ($q) {
                $q->where('nama', 'Prestasi & Penghargaan');
            })
            ->with('kategori_profesional')
            ->get();

        return response()->json($prestasiPenghargaan);
    }
}
