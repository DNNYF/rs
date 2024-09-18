<?php

namespace App\Http\Controllers;
use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Pasien;

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
        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        return view('kamar.create', compact('dokters', 'pasiens'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_kamar' => 'required',
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_jaga_id' => 'required|exists:dokters,id',
            'dokter_spesialis_id' => 'required|exists:dokters,id',
            'perawat' => 'required',
            'tipe_kamar' => 'required',
            'status' => 'required|in:kosong,terisi',
        ]);

        Kamar::create($validatedData);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit(Kamar $kamar)
    {
        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        return view('kamar.edit', compact('kamar', 'dokters', 'pasiens'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $validatedData = $request->validate([
            'nomor_kamar' => 'required',
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_jaga_id' => 'required|exists:dokters,id',
            'dokter_spesialis_id' => 'required|exists:dokters,id',
            'perawat' => 'required',
            'tipe_kamar' => 'required',
            'status' => 'required|in:kosong,terisi',
        ]);

        $kamar->update($validatedData);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}

