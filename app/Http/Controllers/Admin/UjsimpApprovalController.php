<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ujsimp\UjsimpTest;
use Illuminate\Support\Facades\Auth;

class UjsimpApprovalController extends Controller
{
    public function index()
    {
        $tests = UjsimpTest::whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
                    ->latest()
                    ->paginate(10);
        return view('admin.ujsimp.index', compact('tests'));
    }

    public function show($id)
    {
        $test = UjsimpTest::with('scores')
                    ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
                    ->findOrFail($id);
        return view('admin.ujsimp.show', compact('test'));
    }

    public function approve($id)
    {
        $test = UjsimpTest::findOrFail($id);

        if (!$test->canBeApproved()) {
            return back()->with('error','Dokumen tidak bisa disetujui.');
        }

        $test->update([
            'workflow_status' => 'approved',
            'approved_by'     => Auth::id(),
            'approved_at'     => now(),
            'is_locked'       => true,
        ]);

        return back()->with('success','Dokumen berhasil disetujui.');
    }

    public function reject($id)
    {
        $test = UjsimpTest::findOrFail($id);

        if (!$test->canBeApproved()) {
            return back()->with('error','Dokumen tidak bisa ditolak.');
        }

        $test->update([
            'workflow_status' => 'rejected',
        ]);

        return back()->with('success','Dokumen ditolak.');
    }
}