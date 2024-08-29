<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operators = DB::table('users')->where('role','pasien')->paginate(10);;
        return view('operator.index', compact('operators'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operator.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
            'about_me' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'about_me' =>  $validatedData['about_me'],
            'password' => Hash::make($validatedData['password']),
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $operators = User::findOrFail($id);
        return view('admin.show', compact('operators'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $operators = User::findOrFail($id);
        return view('operator.edit',compact('operators'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'about_me' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $operator = User::findOrFail($id);

        $operator->name = $request->input('name');
        $operator->email = $request->input('email');
        $operator->phone = $request->input('phone');
        $operator->about_me = $request->input('about_me');

        if ($request->filled('password')) {
            $operator->password = Hash::make($request->input('password'));
        }

        $operator->save();

        return redirect()->route('operator.index')->with('success', 'Operator berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
