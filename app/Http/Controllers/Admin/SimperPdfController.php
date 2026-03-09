<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use Barryvdh\DomPDF\Facade\Pdf;

class SimperPdfController extends Controller
{
    public function print($id)
    {
        $assessment = SimperDocument::findOrFail($id);

        if (! $assessment->isApproved()) {
            abort(403, 'Dokumen belum disetujui.');
        }

        $data = $assessment; // Assessment model has accessors

        $pdf = Pdf::loadView('pdf.simper', compact('data'));

        return $pdf->stream('simper-'.$assessment->npk.'.pdf');
    }
}
