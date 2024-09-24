<?php

namespace App\Http\Controllers;

use App\Models\Vod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VodController extends Controller
{
    public function index()
    {
        $vods = Vod::all(); 
        return view('vod.index', compact('vods')); 
    }

    public function create()
    {
        return view('vod.create'); 
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

        
        $videoPath = $request->file('file_path')->store('vods', 'public');
        $thumbnailPath = null;

        
        if ($request->hasFile('thumbnail_path')) {
            $thumbnailPath = $request->file('thumbnail_path')->store('vod_thumbnails', 'public');
        }

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
        return view('vod.edit', compact('vod')); 
    }

    public function show(Vod $vod)
    {
        
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
            Storage::disk('public')->delete($vod->file_path);
            $videoPath = $request->file('file_path')->store('vods', 'public');
            $vod->file_path = $videoPath;
        }

        if ($request->hasFile('thumbnail_path')) {
            if ($vod->thumbnail_path) {
                Storage::disk('public')->delete($vod->thumbnail_path);
            }
            $thumbnailPath = $request->file('thumbnail_path')->store('vod_thumbnails', 'public');
            $vod->thumbnail_path = $thumbnailPath;
        }

        $vod->title = $validated['title'];
        $vod->description = $validated['description'];
        $vod->is_premium = $request->has('is_premium');
        $vod->save();

        return redirect()->route('vod.index')->with('success', 'VOD updated successfully');
    }

    public function destroy(Vod $vod)
    {
        Storage::disk('public')->delete($vod->file_path);
        if ($vod->thumbnail_path) {
            Storage::disk('public')->delete($vod->thumbnail_path);
        }
        $vod->delete();

        return redirect()->route('vod.index')->with('success', 'VOD deleted successfully');
    }
}
