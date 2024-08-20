<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::all();
        return view('dokters.index', ['dokters' => $dokters]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method called');
        Log::info($request->all());

        $validatedData = $request->validate([
            'nama_dokter' => 'required|string',
            'nip' => 'required|string',
            'sip' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'spesialis' => 'required|in:Umum,Spesialis',
            'nama_spesialis' => 'nullable|required_if:spesialis,Spesialis|string|max:255',
            'biaya_pelayanan' => 'required|integer',
            'tlp' => 'required|string',
            'email' => 'required|email',
        ]);

        Log::info('Validation passed');

        if ($validatedData['spesialis'] === 'Umum') {
            $validatedData['nama_spesialis'] = ''; 
        }

        Log::info('Before creating Dokter');
        Dokter::create($validatedData);
        Log::info('After creating Dokter');

        return redirect()->route('dokters.index')->with('success', 'Data dokter berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dokter = Dokter::findOrFail($id);
        return view('dokters.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dokter = Dokter::FindOrFail($id);
        return view('dokters.edit', compact('dokter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'nama_dokter' => 'required|string|max:255',
                'nip' => 'required|string|max:50',
                'sip' => 'required|string|max:50',
                // 'gelar_depan' => 'required|string|max:50',
                // 'gelar_belakang' => 'required|string|max:50',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'spesialis' => 'required|string',
                'nama_spesialis' => 'nullable|required_if:spesialis,Spesialis|string|max:255',
                'biaya_pelayanan' => 'required|integer',
                // 'alamat' => 'required|string|max:50',
                'tlp' => 'required|string|max:15',
                'email' => 'required|string|max:50',
            ]
        );

        $dokter = Dokter::FindOrFail($id);
        $dokter->update($request->all());

        return redirect()->route('dokters.index')->with('success', "Data Dokter Berhasil Diperbaharui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokter = Dokter::find($id);
        if ($dokter) {
            $dokter->delete();
            return  redirect()->route('dokters.index')->with('success', 'Data Dokter Berhasil Dihapus!');
        } else {
            return redirect()->route('dokters.index')->with('error', 'Data Dokter Tidak Ditemukan!');
        }
    }
}
