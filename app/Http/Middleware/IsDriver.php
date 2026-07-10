<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsDriver
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->id_role == 4) {
            return $next($request);
        }

        // Bukan driver — redirect ke dashboard masing-masing
        $role = Auth::user()->id_role;
        $redirect = match ($role) {
            1 => route('admin.dashboard'),
            2 => route('beranda'),
            3 => route('dapur.dashboard'),
            default => route('beranda'),
        };

        return redirect($redirect)->with('error', 'Halaman ini khusus untuk driver.');
    }
}