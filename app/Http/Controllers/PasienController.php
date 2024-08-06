<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasiens = Pasien::all();
        return view('pasiens.index', ['pasiens' => $pasiens]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pasiens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tb' => 'required|integer',
        ]);

        Pasien::create($request->all());
        return redirect()->route('pasiens.index')->with('success', 'Pasien Berhasil Ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasiens.show', compact('pasien'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasiens.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_lengkap' => 'required|string|max:255',
                'alamat' => 'required|string',
                'tgl_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tb' => 'required|integer',
            ]

        );
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());

        return redirect()->route('pasiens.index')->with('success', 'Data Pasien Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pasien = Pasien::find($id);

        if ($pasien) {
            $pasien->delete();
            return redirect()->route('pasiens.index')->with('success', 'Data Pasien Berhasil Dihapus!');
        } else {
            return redirect()->route('pasiens.index')->with('error', 'Data Pasien Tidak Ditemukan!');
        }
    }
}
