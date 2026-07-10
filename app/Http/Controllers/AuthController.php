<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/'],
            'password' => 'required'
        ]);

        // Logout dulu jika sudah login (biar bisa ganti akun)
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->id_role;

            // Redirect based on role
            if ($role == 1) { // Admin
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            } elseif ($role == 3) { // Penjual/Dapur
                return redirect()->route('dapur.dashboard');
            } elseif ($role == 4) { // Driver
                return redirect()->route('driver.pengantaran');
            } else { // Customer
                return redirect()->intended(route('beranda'))->with('success', 'Berhasil login!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ========== GOOGLE LOGIN ==========

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Logout dulu jika sudah login
            if (Auth::check()) {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }

            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Hubungkan google_id jika sebelumnya daftar manual dengan email sama
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                Auth::login($user);
            } else {
                // Registrasi akun baru
                $newUser = User::create([
                    'nama_lengkap' => $googleUser->name,
                    'email' => $googleUser->email,
                    'username' => Str::slug($googleUser->name) . rand(100, 999),
                    'password' => bcrypt(Str::random(16)), // Password acak aman
                    'id_role' => 2, // Customer
                    'google_id' => $googleUser->id,
                    'is_active' => 1,
                    'poin' => 0,
                ]);
                Auth::login($newUser);
            }

            request()->session()->regenerate();

            return redirect()->route('beranda')->with('success', 'Berhasil login melalui Google!');
        } catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors('Gagal login menggunakan Google. Silakan coba kembali.');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'nama_lengkap' => $request->name,
            'email' => $request->email,
            'username' => Str::slug($request->name) . rand(100, 999),
            'password' => bcrypt($request->password),
            'id_role' => 2, // Customer
            'is_active' => 1,
            'poin' => 0,
        ]);

        Auth::login($user);

        return redirect()->route('beranda')->with('success', 'Registrasi berhasil! Selamat datang di Juice Kidding.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('beranda');
    }
}