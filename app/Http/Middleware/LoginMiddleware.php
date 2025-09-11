<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $u = Auth::user();
            if (method_exists($u, 'isAdmin') && $u->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }
            if (method_exists($u, 'isKasir') && $u->isKasir()) {
                return redirect()->intended(route('kasir.dashboard'));
            }
            return redirect('/'); // fallback
        }
        return $next($request);
    }
}
