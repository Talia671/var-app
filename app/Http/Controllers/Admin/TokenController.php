<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokens = RegistrationToken::with(['creator', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.tokens.index', compact('tokens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Generate Token
        $tokenString = strtoupper(Str::random(32));

        $token = RegistrationToken::create([
            'token' => $tokenString,
            'created_by' => Auth::id(),
            'status' => 'active',
            'used_by' => null,
            'used_at' => null,
            'used_by_security_code' => null,
        ]);

        return redirect()->route('admin.tokens.index')
            ->with('success', 'Token generated successfully.')
            ->with('new_token', $token->token);
    }
}
