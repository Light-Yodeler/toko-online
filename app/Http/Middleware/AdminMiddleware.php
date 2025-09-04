<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {

    //     if (!Auth::check()) {
    //         return redirect()->route('login');
    //     }

    //     $user = Auth::user();

    //     if ($user->role === User::ROLE_ADMIN) {
    //         return $next($request);
    //     }

    //     return redirect('/')->with('error', 'Akses admin ditolak.');
    // }
    // app/Http/Middleware/AdminMiddleware.php
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        return redirect('/home')->with('error', 'Akses admin ditolak.');
        // abort_if(!$user?->isAdmin(), 403);
    }
}
