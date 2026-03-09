<?php

namespace App\Http\Controllers\Avp;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Simper\SimperDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimperApprovalController extends Controller
{
    public function show($id)
    {
        $assessment = SimperDocument::with(['notes', 'approver', 'verifier', 'checker'])
            ->whereIn('workflow_status', ['verified', 'approved', 'rejected'])
            ->findOrFail($id);

        $activities = ActivityLog::with('user')
            ->where('module', 'simper')
            ->where('description', 'LIKE', "%(ID: {$assessment->id})%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('avp.simper.show', compact('assessment', 'activities'));
    }

    public function approve($id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if ($assessment->workflow_status !== 'verified') {
            abort(403);
        }

        $assessment->update([
            'workflow_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        ActivityLog::log('exam_approved', 'simper', "AVP Approved SIMPER for {$assessment->nama} (ID: {$assessment->id})");

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if ($assessment->workflow_status !== 'verified') {
            abort(403);
        }

        $assessment->update([
            'workflow_status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'rejected_reason' => $request->input('rejected_reason'),
        ]);

        ActivityLog::log('exam_rejected', 'simper', "AVP Rejected SIMPER for {$assessment->nama} (ID: {$assessment->id})");

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen ditolak.');
    }
}
