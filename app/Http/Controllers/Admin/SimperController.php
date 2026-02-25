<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SimperController extends Controller
{
    public function index(Request $request)
    {
        $query = SimperDocument::query()->latest();

        // Ambil status dari query string
        $status = $request->input('status', 'all');

        // Filter hanya jika bukan 'all'
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $assessments = $query->paginate(10);

        return view('admin.simper.index', [
            'assessments'   => $assessments,
            'currentStatus' => $status
        ]);
    }

    public function show($id)
    {
        $assessment = SimperDocument::with('notes')->findOrFail($id);

        return view('admin.simper.show', compact('assessment'));
    }

    public function approve($id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if ($assessment->status !== 'pending') {
            return back()->with('error', 'Data sudah diproses.');
        }

        $assessment->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'SIMPER berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejected_reason' => 'required|string'
        ]);

        $assessment = SimperDocument::findOrFail($id);

        if ($assessment->status !== 'pending') {
            return back()->with('error', 'Data sudah diproses.');
        }

        $assessment->update([
            'status' => 'rejected',
            'rejected_by' => Auth::user()->id,
            'rejected_at' => now(),
            'rejected_reason' => $request->rejected_reason
        ]);

        return back()->with('success', 'SIMPER ditolak.');
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