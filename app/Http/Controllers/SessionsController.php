<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        // $attributes = request()->validate([
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);

        // if (Auth::attempt($attributes)) {
        //     session()->regenerate();

        //     // Mendapatkan role pengguna setelah login
        //     $user = Auth::user();
        //     $role = $user->role; // pastikan Anda memiliki kolom 'role' di tabel 'users'

        //     // Redirect berdasarkan role
        //     if ($role === 'admin') {
        //         return redirect()->route('admin.dashboard')->with(['success' => 'You are logged in.']);
        //     } elseif ($role === 'operator') {
        //         return redirect()->route('operator.dashboard')->with(['success' => 'You are logged in.']);
        //     } elseif ($role === 'doctor') {
        //         return redirect()->route('doctor.dashboard')->with(['success' => 'You are logged in.']);
        //     } else {
        //         // Jika role tidak dikenali, logout pengguna
        //         Auth::logout();
        //         return redirect('/login')->withErrors(['email' => 'Your account does not have access to this system.']);
        //     }
        // } else {
        //     return back()->withErrors(['email' => 'Email or password invalid.']);
        // }
    
        $attributes = request()->validate([
            'email'=>'required|email',
            'password'=>'required' 
        ]);

        if(Auth::attempt($attributes))
        {
            session()->regenerate();
            return redirect('dashboard')->with(['success'=>'You are logged in.']);
        }
        else{

            return back()->withErrors(['email'=>'Email or password invalid.']);
        }
    }
    
    public function destroy(Request $request)
{
    Auth::logout(); 

    $request->session()->flush(); 
    $request->session()->regenerateToken();

    return redirect('/login')->with(['success' => 'You\'ve been logged out.']);
}
}
