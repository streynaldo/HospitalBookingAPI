<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banner.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        // Generate a custom file name
        // $originalName = pathinfo($request->file('gambar')->getClientOriginalName(), PATHINFO_FILENAME);
        // $extension = $request->file('gambar')->getClientOriginalExtension();
        // $customFileName = $originalName . '-' . time() . '.' . $extension;

        // Store the file with the custom name
        // $gambar = $request->file('gambar')->storeAs('banners', $customFileName, 'public');
        $imageName = $request->file('gambar')->store('banners', 'public');

        Banner::create([
            'gambar' => $imageName,
            'deskripsi' => $request->deskripsi,            
            'gambar_url' => asset('storage/' . $imageName),
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bannerId)
    {
        $banner = Banner::findOrFail($bannerId);
        // remove the image file from storage
        $path = storage_path('app/public/' . $banner->gambar);
        if (file_exists($path)) {
            unlink($path);
        }
        $banner->delete();
        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner deleted successfully.');
    }

    public function getAllBanners()
    {
        $banners = Banner::all();
        return response()->json([
            'message' => 'Banners berhasil diambil',
            'data' => $banners
        ], 200);
    }
}
