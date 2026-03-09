<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CooldownService;
use App\Services\ExamDuplicateService;
use Illuminate\Http\Request;

class IdentityLookupController extends Controller
{
    protected $cooldownService;
    protected $examDuplicateService;

    public function __construct(CooldownService $cooldownService, ExamDuplicateService $examDuplicateService)
    {
        $this->cooldownService = $cooldownService;
        $this->examDuplicateService = $examDuplicateService;
    }

    /**
     * Look up user identity by security code.
     *
     * @param  string  $code
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $code)
    {
        // 1. Validate security code format (S-PKT-XXXXXX)
        if (!preg_match('/^S-PKT-\d{6}$/', $code)) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Invalid security code format'
            ]);
        }

        // 2. Find user by security_code
        $user = User::where('security_code', $code)->first();

        if (!$user) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'User not found'
            ]);
        }

        // 3. Cooldown Check (Suspension)
        $suspendedUntil = $this->cooldownService->isSuspended($code);
        if ($suspendedUntil) {
            return response()->json([
                'status' => 'suspended',
                'retry_date' => $suspendedUntil->format('Y-m-d'),
                'message' => 'User is currently suspended until ' . $suspendedUntil->format('d M Y')
            ]);
        }

        // 4. Duplicate Exam Check
        if ($request->has('module')) {
            $module = $request->query('module');
            $allowedModules = ['simper', 'ujsimp', 'checkup', 'ranmor'];

            if (in_array(strtolower($module), $allowedModules)) {
                if ($this->examDuplicateService->checkDuplicate($code, $module)) {
                    return response()->json([
                        'status' => 'duplicate',
                        'message' => 'User already has an active ' . strtoupper($module) . ' exam'
                    ]);
                }
            }
        }

        // 5. Success Response
        return response()->json([
            'status' => 'valid',
            'data' => [
                'name' => $user->name,
                'npk' => $user->npk,
                'department' => $user->department,
                'security_code' => $user->security_code
            ]
        ]);
    }
}
