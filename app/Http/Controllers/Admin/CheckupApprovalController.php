<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use Illuminate\Support\Facades\Auth;

class CheckupApprovalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX (LIST APPROVAL)
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $documents = CheckupDocument::whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->latest()
            ->paginate(10);

        return view('admin.checkup.index', compact('documents'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW DETAIL
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $document = CheckupDocument::with(['results.item','photos'])
            ->where('id', $id)
            ->whereIn('workflow_status',['submitted','approved','rejected'])
            ->firstOrFail();

        return view('admin.checkup.show', compact('document'));
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $document = CheckupDocument::where('id',$id)
            ->where('workflow_status','submitted')
            ->firstOrFail();

        if ($document->is_locked) {
            return back()->with('error','Dokumen sudah terkunci.');
        }

        $document->update([
            'workflow_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'is_locked' => true,
        ]);

        return back()->with('success','Dokumen berhasil disetujui.');
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject($id)
    {
        $document = CheckupDocument::where('id',$id)
            ->where('workflow_status','submitted')
            ->firstOrFail();

        if ($document->is_locked) {
            return back()->with('error','Dokumen sudah terkunci.');
        }

        $document->update([
            'workflow_status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
        ]);

        return back()->with('success','Dokumen ditolak.');
    }
}