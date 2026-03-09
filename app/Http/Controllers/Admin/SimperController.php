<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimperController extends Controller
{
    public function index(Request $request)
    {
        $query = SimperDocument::query()
            ->where('workflow_status', 'submitted')
            ->with('checker');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%")
                    ->orWhere('zona', 'like', "%{$search}%")
                    ->orWhereHas('checker', function ($qc) use ($search) {
                        $qc->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('zona')) {
            $zona = $request->zona;
            if ($zona === 'zona1') {
                $query->where('zona', 'like', '%1%');
            } elseif ($zona === 'zona2') {
                $query->where('zona', 'like', '%2%');
            } else {
                $query->where('zona', $zona);
            }
        }

        $sort = $request->input('sort', 'terbaru');
        $sort = in_array($sort, ['terbaru', 'terlama'], true) ? $sort : 'terbaru';
        $query->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc');

        $assessments = $query->paginate(15)->withQueryString();

        return view('admin.simper.index', compact('assessments', 'sort'));
    }

    public function show($id)
    {
        $assessment = SimperDocument::with('notes')
            ->whereIn('workflow_status', ['submitted', 'verified', 'rejected'])
            ->findOrFail($id);

        return view('admin.simper.show', compact('assessment'));
    }

    public function approve($id)
    {
        $assessment = SimperDocument::findOrFail($id);
        if ($assessment->workflow_status !== 'submitted') {
            abort(403);
        }

        $assessment->workflow_status = 'verified';
        $assessment->verified_by = Auth::id();
        $assessment->verified_at = now();
        $assessment->save();

        \App\Models\ActivityLog::log('exam_verified', 'simper', "Admin Verified SIMPER for {$assessment->nama} (ID: {$assessment->id})");

        return redirect()
            ->route('admin.simper.index')
            ->with('success', 'Dokumen berhasil diverifikasi.');
    }

    public function reject(Request $request, $id)
    {
        $assessment = SimperDocument::findOrFail($id);
        if ($assessment->workflow_status !== 'submitted') {
            abort(403);
        }

        $assessment->workflow_status = 'rejected';
        $assessment->rejected_by = Auth::id();
        $assessment->rejected_at = now();
        $assessment->rejected_reason = $request->input('rejected_reason');
        $assessment->save();

        \App\Models\ActivityLog::log('exam_rejected', 'simper', "Admin Rejected SIMPER for {$assessment->nama} (ID: {$assessment->id})");

        return redirect()
            ->route('admin.simper.index')
            ->with('success', 'Dokumen ditolak.');
    }

    public function exportPdf($id)
    {
        $assessment = SimperDocument::with('notes')->findOrFail($id);

        $pdf = Pdf::loadView('admin.simper.pdf', compact('assessment'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('SIMPER-'.$assessment->npk.'.pdf');
    }

    public function previewPdf(Request $request, $id)
    {
        $assessment = SimperDocument::with('notes')->findOrFail($id);

        $showWatermark = $request->input('wm') == 1;
        $showHeader = $request->input('header') == 1;
        $showFooter = $request->input('footer') == 1;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'admin.simper.pdf',
            compact(
                'assessment',
                'showWatermark',
                'showHeader',
                'showFooter'
            )
        )->setPaper('a4', 'portrait');

        return $pdf->stream('SIMPER-'.$assessment->npk.'.pdf');
    }
}
