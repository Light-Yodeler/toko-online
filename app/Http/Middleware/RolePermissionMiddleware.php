<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthenticated.'], 401)
                : redirect()->guest(route('login'));
        }
        $user = Auth::user();
        $userRole = optional($user->role)->name;
        if (in_array($userRole, $roles, true)) {
            return $next($request);
        }
        // jika request AJAX maka akan return json
        return $request->expectsJson()
            ? response()->json(['message' => 'Forbidden.'], 403)
            : abort(403);
    }
}
