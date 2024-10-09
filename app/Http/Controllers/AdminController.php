<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::query();

            // Filter by role
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }

            // Search functionality
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('role', 'LIKE', "%{$searchTerm}%");
                });
            }

            $admins = $query->paginate(10);

            if ($request->ajax()) {
                return view('admin.table', compact('admins'))->render();
            }

            return view('admin.index', compact('admins'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@index: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function create()
    {
        $roles = ['admin', 'operator', 'pasien', 'perawat', 'dokter_jaga'];
        return view('admin.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,operator,pasien,perawat,dokter_jaga'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $admin = User::findOrFail($id);
        $roles = ['admin', 'operator', 'pasien', 'perawat', 'dokter_jaga'];
        return view('admin.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $admin = User::findOrFail($id);

        $updateData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|in:admin,operator,pasien,perawat,dokter_jaga'
        ]);

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        } else {
            unset($updateData['password']);
        }

        $admin->update($updateData);

        return redirect()->route('admin.index')->with('success', 'Data User berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->delete();
            return redirect()->route('admin.index')->with('success', 'Data Berhasil Dihapus!');
        } else {
            return redirect()->route('admin.index')->with('error', 'Data Tidak Ditemukan!');
        }
    }

    public function show(Request $request, $id){
        $admin = User::findOrFail($id);
        return view('admin.show',compact('admin'));
    }
}
