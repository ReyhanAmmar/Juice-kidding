<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->id_role == 3) {
            return $next($request);
        } else {
            return back()->with('error', 'Anda tidak memiliki izin akses ke halaman Admin.');
        }
    }
}