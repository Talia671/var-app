<?php

namespace App\Services;

use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;
use Carbon\Carbon;

class CooldownService
{
    /**
     * Check if a user is under cooldown for a specific module.
     *
     * @param  int|string  $userId
     * @return Carbon|null Returns the date when retry is available, or null if no cooldown.
     */
    public function checkUserCooldown($userId, string $module): ?Carbon
    {
        $query = null;

        switch (strtolower($module)) {
            case 'simper':
                // Simper uses petugas_id as creator
                $query = SimperDocument::where('petugas_id', $userId);
                break;
            case 'ujsimp':
                // Ujsimp uses petugas_id as creator
                $query = UjsimpTest::where('petugas_id', $userId);
                break;
            case 'checkup':
                // Checkup uses created_by
                $query = CheckupDocument::where('created_by', $userId);
                break;
            case 'ranmor':
                // Ranmor uses created_by
                $query = RanmorDocument::where('created_by', $userId);
                break;
            default:
                return null;
        }

        // Find the latest rejected document
        $latestRejected = $query->where('workflow_status', 'rejected')
            ->latest('rejected_at')
            ->first();

        if (! $latestRejected) {
            return null;
        }

        // Calculate retry date (3 days after rejection)
        // Note: Some models might have retry_available_at column, but to be safe and consistent
        // we calculate it dynamically based on rejected_at + 3 days as per requirement.
        // If the model has retry_available_at and it's set, we could use it,
        // but strict calculation ensures consistency even if DB column is missing.

        $rejectedAt = $latestRejected->rejected_at ? Carbon::parse($latestRejected->rejected_at) : null;

        if (! $rejectedAt) {
            return null;
        }

        $retryAvailableAt = $rejectedAt->copy()->addDays(3);

        if (now()->lessThan($retryAvailableAt)) {
            return $retryAvailableAt;
        }

        return null;
    }

    /**
     * Check if a user with security code is suspended.
     *
     * @param  string  $securityCode
     * @return Carbon|null Returns the date when retry is available, or null if not suspended.
     */
    public function isSuspended($securityCode)
    {
        if (empty($securityCode)) {
            return null;
        }

        $tables = [
            'simper' => \App\Models\Simper\SimperDocument::class,
            'ujsimp' => \App\Models\Ujsimp\UjsimpTest::class,
            'checkup' => \App\Models\Checkup\CheckupDocument::class,
            'ranmor' => \App\Models\Ranmor\RanmorDocument::class,
        ];

        $latestRetryDate = null;

        foreach ($tables as $module => $modelClass) {
            // Check if model has security_code column (it should, based on migration)
            // We assume the column exists as we added it.
            
            // We need to check if the model uses 'rejected_at'
            // Based on CooldownService checkUserCooldown, it uses rejected_at.
            
            $latestRejected = $modelClass::where('security_code', $securityCode)
                ->where('workflow_status', 'rejected')
                ->latest('rejected_at')
                ->first();

            if ($latestRejected && $latestRejected->rejected_at) {
                $rejectedAt = Carbon::parse($latestRejected->rejected_at);
                $retryAvailableAt = $rejectedAt->copy()->addDays(3); // 3 days cooldown

                if (now()->lessThan($retryAvailableAt)) {
                    if ($latestRetryDate === null || $retryAvailableAt->greaterThan($latestRetryDate)) {
                        $latestRetryDate = $retryAvailableAt;
                    }
                }
            }
        }

        return $latestRetryDate;
    }
}
