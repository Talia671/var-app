<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckupPdfController extends Controller
{
    public function preview($id)
    {
        $document = CheckupDocument::with(['results.item','photos','creator','approver'])
            ->where('id',$id)
            ->where('workflow_status','approved')
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.checkup.pdf', compact('document'))
            ->setPaper('a4','portrait');

        return $pdf->stream('checkup-preview.pdf');
    }

    public function download($id)
    {
        $document = CheckupDocument::with(['results.item','photos','creator','approver'])
            ->where('id',$id)
            ->where('workflow_status','approved')
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.checkup.pdf', compact('document'))
            ->setPaper('a4','portrait');

        return $pdf->download('CHECKUP-'.$document->no_pol.'.pdf');
    }
}