<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SystemMonitoringController extends Controller
{
    public function index()
    {
        $stats = [
            'login' => ActivityLog::where('action', 'login')->count(),
            'register' => ActivityLog::where('action', 'register')->count(),
            'exam' => [
                'created' => ActivityLog::where('action', 'exam_created')->count(),
                'submitted' => ActivityLog::where('action', 'exam_submitted')->count(),
                'verified' => ActivityLog::where('action', 'exam_verified')->count(),
                'approved' => ActivityLog::where('action', 'exam_approved')->count(),
                'rejected' => ActivityLog::where('action', 'exam_rejected')->count(),
            ]
        ];

        return view('super_admin.system_monitoring.index', compact('stats'));
    }

    public function loginLogs()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'login')
            ->latest()
            ->paginate(15);
        
        return view('super_admin.system_monitoring.login_logs', compact('logs'));
    }

    public function registerLogs()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'register')
            ->latest()
            ->paginate(15);
        
        return view('super_admin.system_monitoring.register_logs', compact('logs'));
    }

    public function examCreated()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'exam_created')
            ->latest()
            ->paginate(15);
        
        return view('super_admin.system_monitoring.exam_created', compact('logs'));
    }

    public function examSubmitted()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'exam_submitted')
            ->latest()
            ->paginate(15);
        
        return view('super_admin.system_monitoring.exam_submitted', compact('logs'));
    }

    public function examVerified()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'exam_verified')
            ->latest()
            ->paginate(15);
        
        return view('super_admin.system_monitoring.exam_verified', compact('logs'));
    }

    public function examApproved()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'exam_approved')
            ->latest()
            ->paginate(15);
        
        return view('super_admin.system_monitoring.exam_approved', compact('logs'));
    }

    public function examRejected()
    {
        $logs = ActivityLog::with('user')
            ->where('action', 'exam_rejected')
            ->latest()
            ->paginate(15);
        
        return view('super_admin.system_monitoring.exam_rejected', compact('logs'));
    }
}
