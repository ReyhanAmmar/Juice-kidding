<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        if (Auth::user()->id_role == 2) {
            return $next($request);
        }

        // Bukan customer — redirect ke dashboard masing-masing
        $role = Auth::user()->id_role;
        $redirect = match ($role) {
            1 => route('admin.dashboard'),
            3 => route('dapur.dashboard'),
            4 => route('driver.pengantaran'),
            default => route('beranda'),
        };

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Anda tidak memiliki izin akses ke halaman Customer.'], 403);
        }

        return redirect($redirect)->with('error', 'Halaman ini khusus untuk pelanggan.');
    }
}