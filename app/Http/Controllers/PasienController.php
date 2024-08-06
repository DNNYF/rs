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
        $request->validate(
            [
                'alamat_lengkap' => 'required',
                'alamat' => 'required',
                'tgl_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'tinggi_badan' => 'require|integer',
                'berat_badan' => 'required|integer',
                'golongan_darah' => 'required',
            ]
        );
        Pasien::create($request->all());
        return redirect() -> route('pasiens.index')->with('success', 'Pasie Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        return view('pasiens.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $request->validate(
            [
                'alamat_lengkap' => 'required',
                'alamat' => 'required',
                'tgl_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'tinggi_badan' => 'require|integer',
                'berat_badan' => 'required|integer',
                'golongan_darah' => 'required',
            ]);
            $pasien->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasien.index')->with('Success', 'Data Pasien Berhasil Dihapus!');
    }
}
