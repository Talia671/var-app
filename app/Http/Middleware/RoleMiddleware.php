<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $userRole = Auth::user()->role;

        // Bypass for super_admin
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        // Mapping roles to allow access to standard routes
        $roleMapping = [
            'admin' => ['admin', 'admin_perijinan'],
            'petugas' => ['petugas', 'checker_lapangan'],
            'viewer' => ['viewer', 'user'],
        ];

        if (isset($roleMapping[$role])) {
            if (in_array($userRole, $roleMapping[$role])) {
                return $next($request);
            }
        }

        if ($userRole !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
