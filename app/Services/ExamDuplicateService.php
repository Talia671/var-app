<?php

namespace App\Services;

use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;

class ExamDuplicateService
{
    /**
     * Check if a duplicate active exam exists for the given security code and module.
     *
     * A duplicate is defined as any document with the same security_code
     * where workflow_status is NOT 'rejected'.
     *
     * @param ?string $securityCode
     * @param string $module
     * @return bool
     */
    public function checkDuplicate(?string $securityCode, string $module): bool
    {
        if (!$securityCode) {
            return false;
        }

        if (empty($securityCode)) {
            return false;
        }

        $query = null;

        switch (strtolower($module)) {
            case 'simper':
                $query = SimperDocument::query();
                break;
            case 'ujsimp':
                $query = UjsimpTest::query();
                break;
            case 'checkup':
                $query = CheckupDocument::query();
                break;
            case 'ranmor':
                $query = RanmorDocument::query();
                break;
            default:
                return false;
        }

        // Check for any active exam (not rejected)
        return $query->where('security_code', $securityCode)
            ->where('workflow_status', '!=', 'rejected')
            ->exists();
    }
}
