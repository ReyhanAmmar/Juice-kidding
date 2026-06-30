<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $request)
    {
        // Akan kita buat logikanya setelah halaman login jadi
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function prosesRegister(Request $request)
    {
        // Akan kita buat logikanya setelah halaman register jadi
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('beranda');
    }
}