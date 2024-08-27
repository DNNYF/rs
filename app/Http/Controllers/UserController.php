<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showNavbar()
    {
        $userRole = Auth::user()->role; 
        return view('layouts.navbars.admin.nav', compact('userRole'));
    }
}
