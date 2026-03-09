<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\RegistrationToken;
use App\Models\TokenViewLog;
use App\Models\User;
use App\Services\Security\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function index()
    {
        // Get all tokens
        $tokens = RegistrationToken::with(['creator', 'user'])
            ->latest()
            ->paginate(15);

        return view('super_admin.tokens.index', compact('tokens'));
    }

    public function generate(Request $request)
    {
        // Use TokenService to generate secure token
        $result = $this->tokenService->generateToken(Auth::id());
        $token = $result['model'];
        $plainToken = $result['token'];

        ActivityLog::log('create', 'token', 'Super Admin Generated secure token (ID: '.$token->id.')');

        // Return the PLAIN token only once here for the modal
        return response()->json([
            'success' => true,
            'token' => $plainToken,
            'message' => 'Secure Token generated successfully'
        ]);
    }

    public function reveal(Request $request, $tokenId)
    {
        // 6. TOKEN REVEAL SECURITY - Superadmin only
        if (Auth::user()->role !== 'super_admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        // 7. PASSWORD RE-AUTHENTICATION
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Password verification failed.'], 403);
        }

        $token = RegistrationToken::findOrFail($tokenId);

        try {
            $plainToken = Crypt::decryptString($token->token_encrypted);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Could not decrypt token.'], 500);
        }

        // 10. TOKEN VIEW AUDIT LOG
        TokenViewLog::create([
            'token_id' => $token->id,
            'viewed_by' => Auth::id(),
            'ip_address' => $request->ip(),
            'viewed_at' => now(),
        ]);

        ActivityLog::log('view', 'token', 'Super Admin revealed token ID: '.$token->id);

        return response()->json([
            'success' => true,
            'token' => $plainToken,
        ]);
    }
}
