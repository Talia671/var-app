<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SimperApprovalController extends Controller
{
    public function index()
    {
        $data = SimperDocument::whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->latest()
            ->get();

        return view('admin.simper.index', compact('data'));
    }

    public function show($id)
    {
        $data = SimperDocument::whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->findOrFail($id);

        return view('admin.simper.show', compact('data'));
    }

    public function approve($id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if (!$assessment->canBeApproved()) {
            return back()->with('error', 'Dokumen tidak bisa disetujui.');
        }

        $assessment->update([
            'workflow_status' => 'approved',
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'is_locked' => true,
        ]);

        return redirect()
            ->route('admin.simper.index')
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    public function reject($id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if (!$assessment->canBeApproved()) {
            return back()->with('error', 'Dokumen tidak bisa ditolak.');
        }

        $assessment->update([
            'workflow_status' => 'rejected',
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'rejected_reason' => request('reason')
        ]);

        return redirect()
            ->route('admin.simper.index')
            ->with('success', 'Dokumen berhasil ditolak.');
    }
}
