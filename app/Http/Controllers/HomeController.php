<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;


class HomeController extends Controller
{
    public function home()
    {
        $role = Auth::user()->role;
        $roleComponents = Config::get("roles.$role");

        return view('dashboard');
    }
}