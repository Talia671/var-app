<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ujsimp\UjsimpTest;
use Barryvdh\DomPDF\Facade\Pdf;

class UjsimpPdfController extends Controller
{
    public function preview($id)
    {
        $test = UjsimpTest::with('scores.item')->findOrFail($id);

        if (!$test->isApproved()) {
            abort(403, 'Dokumen belum disetujui.');
        }

        $pdf = Pdf::loadView('admin.ujsimp.pdf', compact('test'))
            ->setPaper('A4','portrait');

        return $pdf->stream('UJSIMP-'.$test->npk.'.pdf');
    }

    public function download($id)
    {
        $test = UjsimpTest::with('scores.item')->findOrFail($id);

        if (!$test->isApproved()) {
            abort(403, 'Dokumen belum disetujui.');
        }

        $pdf = Pdf::loadView('admin.ujsimp.pdf', compact('test'))
            ->setPaper('A4','portrait');

        return $pdf->download('UJSIMP-'.$test->npk.'.pdf');
    }
}