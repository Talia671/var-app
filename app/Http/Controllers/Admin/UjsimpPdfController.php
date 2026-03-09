<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ujsimp\UjsimpTest;
use Barryvdh\DomPDF\Facade\Pdf;

class UjsimpPdfController extends Controller
{
    public function preview($id)
    {
        $test = UjsimpTest::with(['scores.item', 'approver'])->findOrFail($id);

        if (! $test->isApproved()) {
            abort(403, 'Dokumen belum disetujui.');
        }

        $dbItems = \App\Models\Ujsimp\UjsimpItem::orderBy('urutan')->get();
        
        $itemsConfig = $dbItems->groupBy('kategori')->map(function ($group, $kategori) {
            return [
                'kategori' => $kategori,
                'data' => $group->pluck('uraian', 'id')->toArray()
            ];
        })->values()->toArray();

        $pdf = Pdf::loadView('admin.ujsimp.pdf', compact('test', 'itemsConfig'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('UJSIMP-'.$test->npk.'.pdf');
    }

    public function download($id)
    {
        $test = UjsimpTest::with(['scores.item', 'approver'])->findOrFail($id);

        if (! $test->isApproved()) {
            abort(403, 'Dokumen belum disetujui.');
        }

        $dbItems = \App\Models\Ujsimp\UjsimpItem::orderBy('urutan')->get();
        
        $itemsConfig = $dbItems->groupBy('kategori')->map(function ($group, $kategori) {
            return [
                'kategori' => $kategori,
                'data' => $group->pluck('uraian', 'id')->toArray()
            ];
        })->values()->toArray();

        $pdf = Pdf::loadView('admin.ujsimp.pdf', compact('test', 'itemsConfig'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('UJSIMP-'.$test->npk.'.pdf');
    }
}
