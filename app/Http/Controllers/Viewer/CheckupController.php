<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CheckupController extends Controller
{
    private function applySecurityFilter($query)
    {
        $user = Auth::user();
        return $query->where(function ($q) use ($user) {
            if ($user->security_code) {
                $q->where('security_code', $user->security_code);
            }
            $q->orWhere(function ($sub) use ($user) {
                $sub->whereNull('security_code')
                    ->where('nama_pengemudi', $user->name);
            });
        });
    }

    public function preview($id)
    {
        $document = $this->applySecurityFilter(CheckupDocument::with(['results.item', 'photos', 'creator', 'approver']))
            ->where('id', $id)
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.checkup.pdf', compact('document'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('checkup-preview.pdf');
    }

    public function index()
    {
        $documents = $this->applySecurityFilter(CheckupDocument::query())
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->latest()
            ->paginate(15);

        return view('viewer.checkup.index', compact('documents'));
    }

    public function show($id)
    {
        $document = $this->applySecurityFilter(CheckupDocument::with(['photos', 'approver', 'verifier', 'creator']))
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->findOrFail($id);

        $items = \App\Models\Checkup\CheckupItem::where('is_active', 1)
            ->orderBy('item_number')
            ->get();

        $results = \App\Models\Checkup\CheckupResult::where('checkup_document_id', $document->id)
            ->get()
            ->keyBy('checkup_item_id');

        return view('viewer.checkup.show', [
            'document' => $document,
            'items' => $items,
            'results' => $results
        ]);
    }
}
