<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::with(['pasien', 'dokterJaga', 'dokterSpesialis', 'perawat'])->get();
        return view('kamar.index', compact('kamars'));
    }

    public function create()
    {
        $pasiens = Pasien::all();
        $dokterJagas = User::where('role', 'dokter_jaga')->get();
        $dokterSpesialis = Dokter::all();
        $perawats = User::where('role', 'perawat')->get();
        return view('kamar.create', compact('pasiens', 'dokterJagas', 'dokterSpesialis', 'perawats'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_kamar' => 'required|unique:kamars,nomor_kamar',
            'tipe_kamar' => 'required',
            'pasien_id' => 'nullable|exists:pasiens,id',
            'dokter_jaga_id' => 'nullable|exists:users,id',
            'dokter_spesialis_id' => 'nullable|exists:dokters,id',
            'perawat_id' => 'nullable|exists:users,id',
            'status' => 'required|in:kosong,terisi',
        ]);

        Kamar::create($validatedData);

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit(Kamar $kamar)
{
    $pasiens = Pasien::all();
    $dokterJagas = User::where('role', 'dokter_jaga')->get();
    $dokterSpesialis = Dokter::all();
    $perawats = User::where('role', 'perawat')->get();

    return view('kamar.edit', compact('kamar', 'pasiens', 'dokterJagas', 'dokterSpesialis', 'perawats'));
}

public function update(Request $request, Kamar $kamar)
{
    $validatedData = $request->validate([
        'nomor_kamar' => 'required|unique:kamars,nomor_kamar,' . $kamar->id,
        'tipe_kamar' => 'required',
        'pasien_id' => 'nullable|exists:pasiens,id',
        'dokter_jaga_id' => 'nullable|exists:users,id',
        'dokter_spesialis_id' => 'nullable|exists:dokters,id',
        'perawat_id' => 'nullable|exists:users,id',
        'status' => 'required|in:kosong,terisi',
    ]);

    $kamar->update($validatedData);

    return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui');
}
}
