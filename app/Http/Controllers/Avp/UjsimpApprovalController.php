<?php

namespace App\Http\Controllers\Avp;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ujsimp\UjsimpTest;
use App\Services\UjsimpApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjsimpApprovalController extends Controller
{
    protected $approvalService;

    public function __construct(UjsimpApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function show($id)
    {
        $document = UjsimpTest::with([
            'creator',
            'examiner',
            'verifier',
            'approver',
            'rejecter'
        ])
        ->whereIn('workflow_status', ['verified', 'approved', 'rejected'])
        ->findOrFail($id);

        $items = \App\Models\Ujsimp\UjsimpItem::orderBy('urutan')->get();

        $results = \App\Models\Ujsimp\UjsimpScore::where('ujsimp_test_id', $document->id)
            ->get()
            ->keyBy('ujsimp_item_id');

        $activities = ActivityLog::with('user')
            ->where('module', 'ujsimp')
            ->where('description', 'LIKE', "%ID: {$document->id}%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('avp.ujsimp.show', [
            'document' => $document,
            'test' => $document, // Maintain backward compatibility if view uses $test
            'items' => $items,
            'results' => $results,
            'activities' => $activities
        ]);
    }

    public function approve($id)
    {
        $test = UjsimpTest::findOrFail($id);

        $this->approvalService->approve($test, Auth::id());

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $test = UjsimpTest::findOrFail($id);

        $this->approvalService->reject($test, Auth::id(), $request->reason);

        return redirect()
            ->route('avp.approval-queue')
            ->with('success', 'Dokumen ditolak.');
    }
}
