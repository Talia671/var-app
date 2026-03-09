<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ------------------------------------------------
        // USER STATISTICS
        // ------------------------------------------------
        
        $internalRoles = ['admin_perijinan', 'checker_lapangan', 'avp'];

        // Assuming active/inactive based on email_verified_at or just placeholders if columns missing
        // Since User model doesn't have last_login explicitly in fillable, 
        // I will use email_verified_at as a proxy for "Active" (verified) vs "Inactive" (unverified)
        // This is safer than assuming a column that might not exist.
        
        $internalUsers = User::whereIn('role', $internalRoles)->count();
        $externalUsers = User::where('role', 'user')->count();
        $activeUsers = User::whereNotNull('email_verified_at')->count();
        $inactiveUsers = User::whereNull('email_verified_at')->count();

        $userStats = [
            'internal_users' => $internalUsers,
            'external_users' => $externalUsers,
            'active_users' => $activeUsers,
            'inactive_users' => $inactiveUsers,
        ];

        // ------------------------------------------------
        // EXAM STATISTICS
        // ------------------------------------------------

        $examStats = [
            'submitted' => 0,
            'verified' => 0,
            'approved' => 0,
            'rejected' => 0,
        ];

        $models = [
            UjsimpTest::class,
            CheckupDocument::class,
            SimperDocument::class,
            RanmorDocument::class,
        ];

        foreach ($models as $model) {
            $examStats['submitted'] += $model::where('workflow_status', 'submitted')->count();
            $examStats['verified'] += $model::where('workflow_status', 'verified')->count();
            $examStats['approved'] += $model::where('workflow_status', 'approved')->count();
            $examStats['rejected'] += $model::where('workflow_status', 'rejected')->count();
        }

        return view('super_admin.dashboard', compact('userStats', 'examStats'));
    }
}
