<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ranmor\RanmorDocument;
use Barryvdh\DomPDF\Facade\Pdf;

class RanmorPdfController extends Controller
{
    public function preview($id)
    {
        $document = RanmorDocument::with(['findings','creator','approver'])
            ->where('id',$id)
            ->where('workflow_status','approved')
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.ranmor.pdf', compact('document'))
            ->setPaper('a4','portrait');

        return $pdf->stream('RANMOR-'.$document->no_pol.'.pdf');
    }

    public function download($id)
    {
        $document = RanmorDocument::with(['findings','creator','approver'])
            ->where('id',$id)
            ->where('workflow_status','approved')
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.ranmor', compact('document'))
            ->setPaper('a4','portrait');

        return $pdf->download('RANMOR-'.$document->no_pol.'.pdf');
    }
}