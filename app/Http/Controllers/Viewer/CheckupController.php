<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CheckupController extends Controller
{
    public function preview($id)
    {
        $userName = Auth::user()->name;
        $document = CheckupDocument::with(['results.item', 'photos', 'creator', 'approver'])
            ->where('id', $id)
            ->where('nama_pengemudi', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.checkup.pdf', compact('document'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('checkup-preview.pdf');
    }

    public function index()
    {
        $userName = Auth::user()->name;
        $documents = CheckupDocument::where('nama_pengemudi', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->latest()
            ->get();

        return view('viewer.checkup.index', compact('documents'));
    }

    public function show($id)
    {
        $userName = Auth::user()->name;
        $document = CheckupDocument::with(['results.item', 'photos'])
            ->where('nama_pengemudi', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->findOrFail($id);

        return view('viewer.checkup.show', compact('document'));
    }
}
