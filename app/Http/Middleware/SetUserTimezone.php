<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class SetUserTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada cookie user_timezone
        if ($timezone = $request->cookie('user_timezone')) {
            // Validasi timezone
            if (in_array($timezone, timezone_identifiers_list())) {
                // Set timezone aplikasi (Config dan PHP Runtime)
                Config::set('app.timezone', $timezone);
                date_default_timezone_set($timezone);
            }
        }

        return $next($request);
    }
}
