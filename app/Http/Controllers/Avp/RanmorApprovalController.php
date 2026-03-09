<?php

namespace App\Http\Controllers\Avp;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ranmor\RanmorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RanmorApprovalController extends Controller
{
    public function show($id)
    {
        $document = RanmorDocument::with(['findings', 'approver', 'creator', 'verifier', 'rejecter'])
            ->whereIn('workflow_status', ['verified', 'approved', 'rejected'])
            ->findOrFail($id);

        $activities = ActivityLog::with('user')
            ->where('module', 'ranmor')
            ->where('description', 'LIKE', "%(ID: {$document->id})%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('avp.ranmor.show', compact('document', 'activities'));
    }

    public function approve($id)
    {
        $document = RanmorDocument::findOrFail($id);

        if ($document->workflow_status !== 'verified') {
            abort(403);
        }

        $document->update([
            'workflow_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        ActivityLog::log('exam_approved', 'ranmor', "AVP Approved Ranmor for {$document->pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $document = RanmorDocument::findOrFail($id);

        if ($document->workflow_status !== 'verified') {
            abort(403);
        }

        $document->update([
            'workflow_status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'rejected_reason' => $request->input('rejected_reason'),
        ]);

        ActivityLog::log('exam_rejected', 'ranmor', "AVP Rejected Ranmor for {$document->pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen ditolak.');
    }
}
