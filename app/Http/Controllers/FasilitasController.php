<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Fasilitas::query();
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('fasilitas', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        $fasilitas = $query->paginate(10);
    
        return view('operator.fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operator.fasilitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Validate = $request->validate([
            'fasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status'    => 'required|boolean'
        ]);

        Fasilitas::create($Validate);

        return redirect()->route('operator.fasilitas.index')->with('success','Data Berhasl Ditmabahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('operator.fasilitas.edit',compact("fasilitas"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $updateData = $request->validate([
            'fasilitas' => 'string',
            'deskripsi' => 'string',
            'status' => 'boolean',
        ]);

        $fasilitas->update($updateData);
        return redirect()->route('operator.fasilitas.index')->with('success', 'Data Berhasil Diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fasilitas = Fasilitas::find($id);
        if($fasilitas){
            $fasilitas->delete();
            return redirect()->route('operator.fasilitas.index')->with('success', 'Data Berhasil Dihapus!');
        }
    }
}
