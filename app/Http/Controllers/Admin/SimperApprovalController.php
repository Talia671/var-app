<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use Illuminate\Support\Facades\Auth;

class SimperApprovalController extends Controller
{
    public function index()
    {
        $data = SimperDocument::where('workflow_status', 'submitted')
            ->latest()
            ->paginate(15);

        return view('admin.simper.index', compact('data'));
    }

    public function show($id)
    {
        $data = SimperDocument::where('workflow_status', 'submitted')
            ->findOrFail($id);

        return view('admin.simper.show', compact('data'));
    }

    public function approve($id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if ($assessment->workflow_status !== 'submitted') {
            abort(403);
        }

        $assessment->workflow_status = 'verified';
        $assessment->verified_by = Auth::id();
        $assessment->verified_at = now();
        $assessment->save();

        \App\Models\ActivityLog::log('exam_verified', 'simper', "Admin Verified SIMPER for {$assessment->nama} (ID: {$assessment->id})");

        return redirect()
            ->route('admin.simper.index')
            ->with('success', 'Dokumen berhasil diverifikasi.');
    }

    public function reject($id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if ($assessment->workflow_status !== 'submitted') {
            abort(403);
        }

        $assessment->workflow_status = 'rejected';
        $assessment->status = 'rejected';
        $assessment->rejected_by = Auth::id();
        $assessment->rejected_at = now();
        $assessment->rejected_reason = request('reason');
        $assessment->save();

        \App\Models\ActivityLog::log('exam_rejected', 'simper', "Admin Rejected SIMPER for {$assessment->nama} (ID: {$assessment->id})");

        return redirect()
            ->route('admin.simper.index')
            ->with('success', 'Dokumen berhasil ditolak.');
    }
}
