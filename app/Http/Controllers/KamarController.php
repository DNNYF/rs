<?php

namespace App\Http\Controllers;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kamars = Kamar::query()
                        ->where('nomor_kamar', 'like', "%{$search}%")
                        ->orWhere('tipe_kamar', 'like', "%{$search}%")
                        ->get();

        return view('kamar.index', compact('kamars'));
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
            'penghuni_kamar' => 'nullable|string|max:255',
            'dokter_jaga' => 'nullable|string|max:255',
            'dokter_spesialis' => 'nullable|string|max:255',
            'perawat' => 'nullable|string|max:255',
            'status' => 'required|string|in:kosong,terisi',
        ]);

        Kamar::create($request->all());

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Kamar $kamar)
    {
        return view('kamar.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
{
    $request->validate([
        'nomor_kamar' => 'required|string|max:255',
        'tipe_kamar' => 'required|string|max:255',
        'penghuni_kamar' => 'nullable|string|max:255',
        'dokter_jaga' => 'nullable|string|max:255',
        'dokter_spesialis' => 'nullable|string|max:255',
        'perawat' => 'nullable|string|max:255',
        'status' => 'required|string|in:kosong,terisi',
    ]);

    $kamar->update($request->all());

    return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui.');
}

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}

