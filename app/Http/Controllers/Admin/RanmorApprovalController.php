<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ranmor\RanmorDocument;

class RanmorApprovalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX - List Approval
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = RanmorDocument::whereIn('workflow_status', ['submitted', 'approved', 'rejected']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pol', 'like', "%{$search}%")
                  ->orWhere('pengemudi', 'like', "%{$search}%")
                  ->orWhere('npk', 'like', "%{$search}%");
            });
        }

        // Filter Zona
        if ($request->filled('zona')) {
            $query->where('zona', $request->zona);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('workflow_status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $documents = $query->paginate(10)->withQueryString();

        return view('admin.ranmor.index', compact('documents'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW - Detail Dokumen
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $document = RanmorDocument::with(['findings','creator'])
            ->where('id', $id)
            ->whereIn('workflow_status', ['submitted','approved','rejected'])
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
        $document = RanmorDocument::where('id', $id)
            ->where('workflow_status', 'submitted')
            ->firstOrFail();

        if ($document->is_locked) {
            return back()->with('error', 'Dokumen sudah terkunci.');
        }

        $document->update([
            'workflow_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'is_locked' => true,
        ]);

        return back()->with('success', 'Dokumen berhasil disetujui.');
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */
    public function reject($id)
    {
        $document = RanmorDocument::where('id', $id)
            ->where('workflow_status', 'submitted')
            ->firstOrFail();

        if ($document->is_locked) {
            return back()->with('error', 'Dokumen sudah terkunci.');
        }

        $document->update([
            'workflow_status' => 'rejected',
        ]);

        return back()->with('success', 'Dokumen berhasil ditolak.');
    }
}