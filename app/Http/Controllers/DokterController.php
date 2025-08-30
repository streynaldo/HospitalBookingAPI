<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Klinik;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dokter::with('klinik');

        // Apply filter if 'klinik_id' is provided
        if ($request->has('klinik_id') && $request->klinik_id != '') {
            $query->where('klinik_id', $request->klinik_id);
        }

        $dokters = $query->paginate(10);
        $kliniks = Klinik::all(); // Retrieve klinik data for filtering

        return view('dokter.index', compact('dokters', 'kliniks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Add logic to retrieve necessary data for creating a dokter
        $kliniks = Klinik::all(); // Assuming you have a Klinik model
        return view('dokter.add', compact('kliniks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'klinik_id' => 'required|exists:kliniks,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $dokter = new Dokter();
        $dokter->nama = $request->nama;
        $dokter->spesialis = $request->spesialis;
        $dokter->klinik_id = $request->klinik_id;
        

        if ($request->hasFile('gambar')) {
            $imageName = $request->file('gambar')->store('dokter', 'public'); // Store in 'storage/app/public/dokter'
            $dokter->gambar = $imageName; // Save the relative path
            $dokter->gambar_url = asset($dokter->gambar ?? 'storage/' . $dokter->gambar); // Set the full URL for the image
        }

        $dokter->save();

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($dokterId)
    {
        $dokter = Dokter::with(['profesionals', 'cutis'])->findOrFail($dokterId);
        $klinik = Klinik::find($dokter->klinik_id);
        $pendidikans = $dokter->profesionals->where('kategori_profesional_id', 1);
        $pengalamans = $dokter->profesionals->where('kategori_profesional_id', 2);
        $prestasis = $dokter->profesionals->where('kategori_profesional_id', 3);
        $cutis = $dokter->cutis;

        // Urutan hari
        $orderHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Ambil jadwal dan urutkan berdasarkan hari
        $jadwals = Jadwal::where('dokter_id', $dokterId)
            ->get()
            ->sortBy(function ($jadwal) use ($orderHari) {
                return array_search($jadwal->hari, $orderHari);
            });

        return view('dokter.detail', compact('dokter', 'klinik', 'pendidikans', 'pengalamans', 'prestasis', 'jadwals', 'cutis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($dokterId)
    {
        $dokter = Dokter::findOrFail($dokterId);
        $kliniks = Klinik::all(); // Retrieve klinik data for the edit form
        return view('dokter.edit', compact('dokter', 'kliniks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $dokterId)
    {
        $dokter = Dokter::findOrFail($dokterId);    
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'klinik_id' => 'required|exists:kliniks,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $dokter->nama = $request->nama;
        $dokter->spesialis = $request->spesialis;
        $dokter->klinik_id = $request->klinik_id;

        if ($request->hasFile('gambar')) {
            // Delete the old image if it exists
            if ($dokter->gambar) {
                $oldImagePath = storage_path('app/public/' . $dokter->gambar);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Store the new image
            $imageName = $request->file('gambar')->store('dokter', 'public'); // Store in 'storage/app/public/dokter'
            $dokter->gambar = $imageName; // Save the relative path
            $dokter->gambar_url = asset('storage/' . $dokter->gambar); // Update the full URL for the image
        }

        $dokter->save();

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($dokterId)
    {
        $dokter = Dokter::findOrFail($dokterId);
        $dokter->delete();
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }

    public function getAllDokter()
    {
        $dokters = Dokter::all();
        // $dokters->each->append('gambar_url');

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
