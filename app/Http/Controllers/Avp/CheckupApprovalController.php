<?php

namespace App\Http\Controllers\Avp;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Checkup\CheckupDocument;
use App\Models\Checkup\CheckupItem;
use App\Models\Checkup\CheckupResult;
use App\Models\Checkup\CheckupPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckupApprovalController extends Controller
{
    public function show($id)
    {
        $document = CheckupDocument::with(['photos', 'approver', 'verifier', 'creator', 'rejecter'])
            ->whereIn('workflow_status', ['verified', 'approved', 'rejected'])
            ->findOrFail($id);

        /*
        Load checklist template
        */
        $items = CheckupItem::where('is_active', 1)
            ->orderBy('item_number')
            ->get();

        /*
        Load results only once
        */
        $results = CheckupResult::where('checkup_document_id', $document->id)
            ->get()
            ->keyBy('checkup_item_id');

        $activities = ActivityLog::with('user')
            ->where('module', 'checkup')
            ->where('description', 'LIKE', "%(ID: {$document->id})%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('avp.checkup.show', [
            'document' => $document,
            'items' => $items,
            'results' => $results,
            'activities' => $activities
        ]);
    }

    public function approve($id)
    {
        $document = CheckupDocument::findOrFail($id);

        if ($document->workflow_status !== 'verified') {
            abort(403);
        }

        $document->update([
            'workflow_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        ActivityLog::log('exam_approved', 'checkup', "AVP Approved Checklist for {$document->nama_pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $document = CheckupDocument::findOrFail($id);

        if ($document->workflow_status !== 'verified') {
            abort(403);
        }

        $request->validate([
            'rejected_reason' => 'required|string|max:500'
        ]);

        $document->update([
            'workflow_status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'rejected_reason' => $request->rejected_reason,
        ]);

        ActivityLog::log('exam_rejected', 'checkup', "AVP Rejected Checklist for {$document->nama_pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen ditolak.');
    }

    public function destroyPhoto($id)
    {
        $photo = CheckupPhoto::findOrFail($id);
        
        if (Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
