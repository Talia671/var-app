<?php

namespace App\Services\Security;

use App\Models\RegistrationToken;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TokenService
{
    /**
     * Generate a new secure registration token.
     * 
     * @param int $userId The ID of the user creating the token.
     * @param int $expiryHours Token expiration time in hours (default: 24).
     * @return array Contains the 'token' string and the 'model' RegistrationToken instance.
     */
    public function generateToken(int $userId, int $expiryHours = 24): array
    {
        // 1. Generate random token: INV-XXXXXX
        $randomString = strtoupper(Str::random(6));
        $formattedToken = 'INV-' . $randomString;
        
        // 2. Compute values
        $lookupHash = hash('sha256', $formattedToken);
        
        // Ensure uniqueness
        while (RegistrationToken::where('token_lookup', $lookupHash)->exists()) {
            $randomString = strtoupper(Str::random(6));
            $formattedToken = 'INV-' . $randomString;
            $lookupHash = hash('sha256', $formattedToken);
        }

        // 3. Save to database
        $tokenModel = RegistrationToken::create([
            'token_lookup' => $lookupHash,
            'token_hash' => Hash::make($formattedToken),
            'token_encrypted' => Crypt::encryptString($formattedToken),
            'created_by' => $userId,
            'status' => 'active',
            'expires_at' => now()->addHours($expiryHours),
        ]);

        return [
            'token' => $formattedToken,
            'model' => $tokenModel
        ];
    }
}
