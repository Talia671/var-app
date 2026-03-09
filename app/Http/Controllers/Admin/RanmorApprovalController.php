<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ranmor\RanmorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RanmorApprovalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX - List Approval
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = RanmorDocument::query()
            ->where('workflow_status', 'submitted')
            ->with('creator');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pengemudi', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%")
                    ->orWhere('zona', 'like', "%{$search}%")
                    ->orWhereHas('creator', function ($qc) use ($search) {
                        $qc->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter Zona
        if ($request->filled('zona')) {
            $query->where('zona', $request->zona);
        }

        // Sorting
        $sort = $request->input('sort', 'terbaru');
        $sort = in_array($sort, ['terbaru', 'terlama'], true) ? $sort : 'terbaru';
        $query->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc');

        $documents = $query->paginate(15)->withQueryString();

        return view('admin.ranmor.index', compact('documents', 'sort'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW - Detail Dokumen
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $document = RanmorDocument::with(['findings', 'creator'])
            ->where('id', $id)
            ->whereIn('workflow_status', ['submitted', 'verified', 'rejected'])
            ->firstOrFail();

        return view('admin.ranmor.show', compact('document'));
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */
    public function approve($id)
    {
        $document = RanmorDocument::findOrFail($id);
        if ($document->workflow_status !== 'submitted') {
            abort(403);
        }

        if ($document->is_locked) {
            return back()->with('error', 'Dokumen sudah terkunci.');
        }

        $document->workflow_status = 'verified';
        $document->verified_by = Auth::id();
        $document->verified_at = now();
        $document->save();

        \App\Models\ActivityLog::log('exam_verified', 'ranmor', "Admin Verified Ranmor for {$document->pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('admin.ranmor.index')
            ->with('success', 'Dokumen berhasil diverifikasi.');
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */
    public function reject($id)
    {
        $document = RanmorDocument::findOrFail($id);
        if ($document->workflow_status !== 'submitted') {
            abort(403);
        }

        if ($document->is_locked) {
            return back()->with('error', 'Dokumen sudah terkunci.');
        }

        $document->update([
            'workflow_status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
        ]);

        \App\Models\ActivityLog::log('exam_rejected', 'ranmor', "Admin Rejected Ranmor for {$document->pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('admin.ranmor.index')
            ->with('success', 'Dokumen ditolak.');
    }
}
