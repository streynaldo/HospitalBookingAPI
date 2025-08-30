<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Klinik;
use Illuminate\Http\Request;

class KlinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $kliniks = Klinik::paginate(9);
        return view('klinik.index', compact('kliniks'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('klinik.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $klinik = new Klinik();
        $klinik->nama = $request->nama;
        $klinik->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('klinik/gambar', 'public'); // Store in 'storage/app/public/klinik/gambar'
            $klinik->gambar = $gambarPath; // Save the relative path
            $klinik->gambar_url = asset('storage/' . $gambarPath); // Set the full URL for the image
        }

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('klinik/icon', 'public'); // Store in 'storage/app/public/klinik/icon'
            $klinik->icon = $iconPath; // Save the relative path
            $klinik->icon_url = asset('storage/' . $iconPath);
        }

        $klinik->save();

        return redirect()->route('admin.klinik.index')->with('success', 'Klinik berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($klinikId)
    {
        $klinik = Klinik::find($klinikId);

        $dokter = $klinik->dokter()->paginate(9);

        // if (!$klinik) {
        //     return view('errors.404');
        // }

        return view('klinik.detail', compact('klinik', 'dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($klinikId)
    {
        $klinik = Klinik::findOrFail($klinikId);

        return view('klinik.edit', compact('klinik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $klinikId)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $klinik = Klinik::findOrFail($klinikId);

        $klinik->nama = $request->nama;
        $klinik->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            // Delete the old image if it exists
            if ($klinik->gambar) {
                $oldGambarPath = storage_path('app/public/' . $klinik->gambar);
                if (file_exists($oldGambarPath)) {
                    unlink($oldGambarPath);
                }
            }

            // Store the new image
            $gambarPath = $request->file('gambar')->store('klinik/gambar', 'public'); // Store in 'storage/app/public/klinik/gambar'
            $klinik->gambar = $gambarPath; // Save the relative path
            $klinik->gambar_url = asset('storage/' . $gambarPath); // Update the full URL for the image
        }

        if ($request->hasFile('icon')) {
            // Delete the old icon if it exists
            if ($klinik->icon) {
                $oldIconPath = storage_path('app/public/' . $klinik->icon);
                if (file_exists($oldIconPath)) {
                    unlink($oldIconPath);
                }
            }

            // Store the new icon
            $iconPath = $request->file('icon')->store('klinik/icon', 'public'); // Store in 'storage/app/public/klinik/icon'
            $klinik->icon = $iconPath; // Save the relative path
            $klinik->icon_url = asset('storage/' . $iconPath); // Update the full URL for the icon
        }

        $klinik->save();

        return redirect()->route('admin.klinik.show', $klinik->id)->with('success', 'Klinik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($klinikId)
    {
        $klinik = Klinik::where('id', $klinikId);

        if ($klinik->gambar && file_exists(public_path('images/' . $klinik->gambar))) {
            unlink(public_path('images/' . $klinik->gambar));
        }

        if ($klinik->icon && file_exists(public_path('icons/' . $klinik->icon))) {
            unlink(public_path('icons/' . $klinik->icon));
        }

        $klinik->delete();

        return redirect()->route('admin.klinik.index')->with('success', 'Klinik berhasil dihapus.');
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
