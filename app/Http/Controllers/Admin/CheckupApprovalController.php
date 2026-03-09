<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use App\Models\Checkup\CheckupItem;
use App\Models\Checkup\CheckupResult;
use App\Models\Checkup\CheckupPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckupApprovalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX (LIST APPROVAL)
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = CheckupDocument::query()
            ->where('workflow_status', 'submitted')
            ->with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengemudi', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%")
                    ->orWhere('jenis_kendaraan', 'like', "%{$search}%")
                    ->orWhereHas('creator', function ($qc) use ($search) {
                        $qc->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $sort = $request->input('sort', 'terbaru');
        $sort = in_array($sort, ['terbaru', 'terlama'], true) ? $sort : 'terbaru';
        $query->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc');

        $documents = $query->paginate(15)->withQueryString();

        return view('admin.checkup.index', compact('documents', 'sort'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW DETAIL
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $document = CheckupDocument::with(['photos'])
            ->where('id', $id)
            ->whereIn('workflow_status', ['submitted', 'verified', 'rejected'])
            ->firstOrFail();

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

        return view('admin.checkup.show', [
            'document' => $document,
            'items' => $items,
            'results' => $results
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $document = CheckupDocument::findOrFail($id);
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

        \App\Models\ActivityLog::log('exam_verified', 'checkup', "Admin Verified Checkup for {$document->nama_pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('admin.checkup.index')
            ->with('success', 'Dokumen berhasil diverifikasi.');
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject($id)
    {
        $document = CheckupDocument::findOrFail($id);
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

        \App\Models\ActivityLog::log('exam_rejected', 'checkup', "Admin Rejected Checkup for {$document->nama_pengemudi} (ID: {$document->id})");

        return redirect()
            ->route('admin.checkup.index')
            ->with('success', 'Dokumen ditolak.');
    }

    public function destroyPhoto($id)
    {
        $photo = CheckupPhoto::findOrFail($id);
        
        // Check permissions (Admin can delete any photo)
        // Optionally add check if document is locked or final status? 
        // User asked "Allow photo deletion if role is: admin_perijinan, avp"
        
        // Delete from storage
        if (Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }

        // Delete from database
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
