<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\RegistrationToken;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Step 1: Account Credentials View
     */
    public function step1(Request $request): View
    {
        return view('auth.register_step1');
    }

    /**
     * Step 1: Store Account Credentials in Session
     */
    public function storeStep1(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->session()->put('registration.name', $request->name);
        $request->session()->put('registration.email', $request->email);
        $request->session()->put('registration.password', $request->password);

        return redirect()->route('register.token');
    }

    /**
     * Step 2: Token Verification View
     */
    public function step2(Request $request)
    {
        if (!$request->session()->has('registration.email')) {
            return redirect()->route('register');
        }

        return view('auth.register_step2_token');
    }

    /**
     * Step 2: Verify Token
     */
    public function storeStep2(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        // 11. TOKEN USAGE - Lookup by SHA256 hash first
        $inputToken = trim($request->token);
        $lookupHash = hash('sha256', $inputToken);

        $token = RegistrationToken::where('token_lookup', $lookupHash)->first();

        // If not found by lookup, it might be invalid or legacy (if we supported legacy).
        // Since we did a hard reset, we assume all tokens are new.
        if (! $token) {
            throw ValidationException::withMessages([
                'token' => ['Token tidak valid.'],
            ]);
        }

        // Verify using Hash::check as requested
        if (!Hash::check($inputToken, $token->token_hash)) {
             throw ValidationException::withMessages([
                'token' => ['Token tidak valid (verifikasi gagal).'],
            ]);
        }

        // Check Status and Expiration
        if ($token->status !== 'active') {
            throw ValidationException::withMessages([
                'token' => ['Token sudah digunakan atau tidak aktif.'],
            ]);
        }

        if ($token->isExpired()) {
             // Update status to expired if not already
             $token->update(['status' => 'expired']);
             
             throw ValidationException::withMessages([
                'token' => ['Token sudah kadaluarsa.'],
            ]);
        }

        // Store token info in session but DO NOT mark as used yet
        $request->session()->put('registration.token_id', $token->id);
        $request->session()->put('registration.token_code', $inputToken);

        return redirect()->route('register.profile');
    }

    /**
     * Step 3: Profile Completion View
     */
    public function step3(Request $request)
    {
        // Strict Session Guard
        if (!$request->session()->has('registration.name') || !$request->session()->has('registration.email')) {
            return redirect()->route('register');
        }

        if (!$request->session()->has('registration.token_id')) {
            return redirect()->route('register.token');
        }

        return view('auth.register_step3_profile');
    }

    /**
     * Step 3: Finalize Registration
     */
    public function storeStep3(Request $request): RedirectResponse
    {
        $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'npk' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Strict Session Guard
        if (!$request->session()->has('registration.email') || !$request->session()->has('registration.token_id')) {
            return redirect()->route('register');
        }

        DB::transaction(function () use ($request) {
            // Retrieve data from session
            $name = $request->session()->get('registration.name');
            $email = $request->session()->get('registration.email');
            $password = $request->session()->get('registration.password');
            $tokenId = $request->session()->get('registration.token_id');
            $tokenCode = $request->session()->get('registration.token_code');

            // Re-validate Token in transaction to prevent race conditions
            $token = RegistrationToken::where('id', $tokenId)
                ->where('status', 'active')
                ->lockForUpdate()
                ->first();

            if (!$token) {
                 throw ValidationException::withMessages([
                    'token' => ['Token tidak valid, sudah digunakan, atau tidak aktif.'],
                ]);
            }

            // Generate unique security code atomically
            $code = $this->generateSecurityCode();

            // Handle Photo Upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('users', 'public');
            }

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->role = 'viewer'; // Default role
            $user->security_code = $code;
            $user->department = $request->company; 
            $user->npk = $request->npk;
            $user->photo_path = $photoPath;
            $user->save();

            // Mark Token as Used (Final Step)
            $token->update([
                'status' => 'used',
                'used_by' => $user->id,
                'used_by_security_code' => $user->security_code,
                'used_at' => now(),
            ]);

            // Log Activity
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'register',
                'module' => 'auth',
                'description' => 'User registered with token: ' . $tokenCode,
                'ip_address' => $request->ip(),
            ]);

            event(new Registered($user));
        });

        // Clear session after transaction success
        $request->session()->forget('registration');

        return redirect()->route('register.success');
    }

    public function success()
    {
        return view('auth.register_success');
    }

    /**
     * Display the registration view. (Deprecated)
     */
    public function create(): View
    {
        return view('auth.register_step1');
    }

    private function generateSecurityCode()
    {
        do {
            $random = str_pad(random_int(0,999999),6,'0',STR_PAD_LEFT);
            $code = 'S-PKT-'.$random;
        } while (User::where('security_code',$code)->exists());

        return $code;
    }

    /**
     * Handle an incoming registration request. (Deprecated)
     */
    public function store(Request $request): RedirectResponse
    {
        // Redirect to new flow
        return redirect()->route('register');
    }
}
