<?php

namespace App\Services;

use App\Models\Ujsimp\UjsimpTest;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class UjsimpApprovalService
{
    /**
     * Submit UJSIMP Test for verification.
     */
    public function submit(UjsimpTest $test, int $userId): void
    {
        if ($test->workflow_status !== 'draft' && $test->workflow_status !== 'rejected') {
            abort(403, 'Document cannot be submitted in current status.');
        }

        DB::transaction(function () use ($test, $userId) {
            $test->update([
                'workflow_status' => 'submitted',
                'submitted_by' => $userId,
                'submitted_at' => now(),
                // Reset rejection data if re-submitting
                'rejected_by' => null,
                'rejected_at' => null,
                'rejected_reason' => null,
            ]);

            ActivityLog::log('submit', 'ujsimp', "Submitted UJSIMP Test ID: {$test->id}", $userId);
        });
    }

    /**
     * Verify UJSIMP Test (Checker).
     */
    public function verify(UjsimpTest $test, int $userId): void
    {
        if ($test->workflow_status !== 'submitted') {
            abort(403, 'Document is not ready for verification.');
        }

        DB::transaction(function () use ($test, $userId) {
            $test->update([
                'workflow_status' => 'verified',
                'verified_by' => $userId,
                'verified_at' => now(),
            ]);

            ActivityLog::log('verify', 'ujsimp', "Verified UJSIMP Test ID: {$test->id}", $userId);
        });
    }

    /**
     * Approve UJSIMP Test (AVP).
     */
    public function approve(UjsimpTest $test, int $userId): void
    {
        if ($test->workflow_status !== 'verified') {
            abort(403, 'Document is not ready for approval.');
        }

        DB::transaction(function () use ($test, $userId) {
            $test->update([
                'workflow_status' => 'approved',
                'approved_by' => $userId,
                'approved_at' => now(),
                'is_locked' => true,
            ]);

            ActivityLog::log('approve', 'ujsimp', "Approved UJSIMP Test ID: {$test->id}", $userId);
        });
    }

    /**
     * Reject UJSIMP Test (AVP).
     */
    public function reject(UjsimpTest $test, int $userId, string $reason): void
    {
        // AVP can reject from 'verified' status.
        // Checker might reject from 'submitted' status (if applicable, adjust logic).
        // For now, assume rejection happens at approval stage or verification stage.
        
        if (!in_array($test->workflow_status, ['submitted', 'verified'])) {
            abort(403, 'Document cannot be rejected in current status.');
        }

        DB::transaction(function () use ($test, $userId, $reason) {
            $test->update([
                'workflow_status' => 'rejected',
                'rejected_by' => $userId,
                'rejected_at' => now(),
                'rejected_reason' => $reason,
                'is_locked' => false, // Unlock for editing
            ]);

            ActivityLog::log('reject', 'ujsimp', "Rejected UJSIMP Test ID: {$test->id}. Reason: {$reason}", $userId);
        });
    }
}
