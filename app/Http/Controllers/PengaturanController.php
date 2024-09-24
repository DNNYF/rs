<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = [
            'nama_aplikasi' => Pengaturan::ambil('nama_aplikasi', config('app.name')),
            'logo_aplikasi' => Pengaturan::ambil('logo_aplikasi'),
        ];

        return view('pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update nama aplikasi
        Pengaturan::atur('nama_aplikasi', $request->nama_aplikasi);

        // Handle unggah logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logo', 'public');
            Pengaturan::atur('logo_aplikasi', $logoPath);
        }

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
