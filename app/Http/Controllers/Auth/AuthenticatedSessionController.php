<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse; // ✅ WAJIB DITAMBAHKAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // 📝 LOGGING
        \App\Models\ActivityLog::log('login', 'auth', "User {$user->name} logged in.", $user->id);

        if ($user->role === 'super_admin') {
            return redirect()->route('super-admin.dashboard');
        }

        if ($user->role === 'admin' || $user->role === 'admin_perijinan') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'petugas' || $user->role === 'checker_lapangan') {
            return redirect()->route('petugas.dashboard');
        }

        if ($user->role === 'viewer' || $user->role === 'user') {
            return redirect()->route('viewer.dashboard');
        }

        if ($user->role === 'avp') {
            return redirect()->route('avp.dashboard');
        }

        abort(403);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
