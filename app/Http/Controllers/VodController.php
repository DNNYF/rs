<?php

namespace App\Http\Controllers;

use App\Models\Vod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VodController extends Controller
{
    public function index()
    {
        $vods = Vod::all(); // Ambil semua data VOD
        return view('vod.index', compact('vods')); // Kirim data ke view
    }

    public function create()
    {
        return view('vod.create'); // Tampilkan form tambah VOD
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|file|mimetypes:video/mp4',
            'thumbnail_path' => 'nullable|image|max:2048',
            'is_premium' => 'boolean',
        ]);

        // Simpan file video
        $videoPath = $request->file('file_path')->store('vods', 'public');
        $thumbnailPath = null;

        // Simpan thumbnail jika ada
        if ($request->hasFile('thumbnail_path')) {
            $thumbnailPath = $request->file('thumbnail_path')->store('vod_thumbnails', 'public');
        }

        // Buat entri baru di database
        Vod::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'is_premium' => $request->has('is_premium'),
        ]);

        return redirect()->route('vod.index')->with('success', 'VOD uploaded successfully');
    }

    public function edit(Vod $vod)
    {
        return view('vod.edit', compact('vod')); // Tampilkan form edit VOD
    }

    public function show(Vod $vod)
    {
        // Memastikan bahwa model yang diterima adalah instance Vod
        return view('vod.show', compact('vod'));
    }

    public function update(Request $request, Vod $vod)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimetypes:video/mp4',
            'thumbnail_path' => 'nullable|image|max:2048',
            'is_premium' => 'boolean',
        ]);

        if ($request->hasFile('file_path')) {
            // Hapus file lama
            Storage::disk('public')->delete($vod->file_path);
            // Simpan file video baru
            $videoPath = $request->file('file_path')->store('vods', 'public');
            $vod->file_path = $videoPath;
        }

        if ($request->hasFile('thumbnail_path')) {
            // Hapus thumbnail lama
            if ($vod->thumbnail_path) {
                Storage::disk('public')->delete($vod->thumbnail_path);
            }
            // Simpan thumbnail baru
            $thumbnailPath = $request->file('thumbnail_path')->store('vod_thumbnails', 'public');
            $vod->thumbnail_path = $thumbnailPath;
        }

        // Update entri di database
        $vod->title = $validated['title'];
        $vod->description = $validated['description'];
        $vod->is_premium = $request->has('is_premium');
        $vod->save();

        return redirect()->route('vod.index')->with('success', 'VOD updated successfully');
    }

    public function destroy(Vod $vod)
    {
        // Hapus file dan thumbnail dari storage
        Storage::disk('public')->delete($vod->file_path);
        if ($vod->thumbnail_path) {
            Storage::disk('public')->delete($vod->thumbnail_path);
        }
        // Hapus entri dari database
        $vod->delete();

        return redirect()->route('vod.index')->with('success', 'VOD deleted successfully');
    }
}
