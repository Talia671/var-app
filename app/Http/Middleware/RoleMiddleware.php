<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $userRole = Auth::user()->role;

        if ($userRole !== $role && $userRole !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}
