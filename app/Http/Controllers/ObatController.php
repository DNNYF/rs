<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('obats', 'nama_obat'),
            ],
            'quantity' => 'required|integer',
            'harga' => 'required|numeric',
        ], [
            'name.unique' => 'Nama obat sudah ada.' // Pesan error kustom
        ]);

        Obat::create([
            'nama_obat' => $request->name,
            'stok_obat' => $request->quantity,
            'harga_obat' => $request->harga,
        ]);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    public function update(Request $request, $id_obat)
    {
        $obat = Obat::findOrFail($id_obat);

        $request->validate([
            'nama_obat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('obats', 'nama_obat')->ignore($id_obat, 'id_obat'),
            ],
            'stok_obat' => 'required|integer',
            'harga_obat' => 'required|numeric|min:0',
        ], [
            'nama_obat.unique' => 'Nama obat sudah ada.' // Pesan error kustom
        ]);

        $obat->update([
            'nama_obat' => $request->nama_obat,
            'stok_obat' => $request->stok_obat,
            'harga_obat' => $request->harga_obat,
        ]);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diupdate.');
    }

    public function destroy($id_obat)
    {
        $obat = Obat::findOrFail($id_obat);
        $obat->delete();

        return redirect()->route('obat.index')->with('warning', 'Obat berhasil dihapus.');
    }
}
