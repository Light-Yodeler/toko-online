<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards ?: [null] as $guard) {
            if (Auth::guard($guard)->check()) {
                $u = Auth::guard($guard)->user();

                if (method_exists($u, 'isAdmin') && $u->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }

                if (method_exists($u, 'isKasir') && $u->isKasir()) {
                    return redirect()->route('kasir.dashboard');
                }

                return redirect()->intended('/'); // fallback umum
            }
        }

        return $next($request);
    }
}
