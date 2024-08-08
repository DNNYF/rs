<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('obats.index', compact('obats'));
    }

    public function create()
    {
        return view('obats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        Obat::create($request->only(['name', 'quantity']));

        return redirect()->route('obat.index')->with('success', 'Obat added successfully.');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('obats.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($request->only(['name', 'quantity']));

        return redirect()->route('obat.index')->with('success', 'Obat updated successfully.');
    }

    public function destroy($id)
    {
        Obat::destroy($id);
        return redirect()->route('obat.index')->with('success', 'Obat removed successfully.');
    }
}
