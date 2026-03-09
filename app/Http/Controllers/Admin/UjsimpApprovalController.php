<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ujsimp\UjsimpTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjsimpApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = UjsimpTest::query()
            ->where('workflow_status', 'submitted')
            ->with('checker');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%")
                    ->orWhere('jenis_kendaraan', 'like', "%{$search}%")
                    ->orWhereHas('checker', function ($qc) use ($search) {
                        $qc->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $sort = $request->input('sort', 'terbaru');
        $sort = in_array($sort, ['terbaru', 'terlama'], true) ? $sort : 'terbaru';
        $query->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc');

        $tests = $query->paginate(15)->withQueryString();

        return view('admin.ujsimp.index', compact('tests', 'sort'));
    }

    public function show($id)
    {
        $test = UjsimpTest::with('scores')
            ->whereIn('workflow_status', ['submitted', 'verified', 'rejected', 'approved'])
            ->findOrFail($id);

        $dbItems = \App\Models\Ujsimp\UjsimpItem::orderBy('urutan')->get();
        
        $itemsConfig = $dbItems->groupBy('kategori')->map(function ($group, $kategori) {
            return [
                'kategori' => $kategori,
                'data' => $group->pluck('uraian', 'id')->toArray()
            ];
        })->values()->toArray();

        return view('admin.ujsimp.show', compact('test', 'itemsConfig'));
    }

    public function verify($id)
    {
        $test = UjsimpTest::findOrFail($id);

        if ($test->workflow_status !== 'submitted') {
            abort(403);
        }

        $test->update([
            'workflow_status' => 'verified',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        \App\Models\ActivityLog::log('exam_verified', 'ujsimp', "Admin Verified UJSIMP Test for {$test->nama} (ID: {$test->id})");

        return redirect()
            ->route('admin.ujsimp.index')
            ->with('success', 'Dokumen berhasil diverifikasi.');
    }

    public function reject($id)
    {
        $test = UjsimpTest::findOrFail($id);

        if ($test->workflow_status !== 'submitted') {
            abort(403);
        }

        $test->update([
            'workflow_status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
        ]);

        \App\Models\ActivityLog::log('exam_rejected', 'ujsimp', "Admin Rejected UJSIMP Test for {$test->nama} (ID: {$test->id})");

        return redirect()
            ->route('admin.ujsimp.index')
            ->with('success', 'Dokumen ditolak.');
    }
}
