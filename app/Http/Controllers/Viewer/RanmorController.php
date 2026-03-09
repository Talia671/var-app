<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Ranmor\RanmorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RanmorController extends Controller
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
                    ->where('pengemudi', $user->name);
            });
        });
    }

    public function index(Request $request)
    {
        $query = $this->applySecurityFilter(RanmorDocument::query())
            ->whereIn('workflow_status', ['approved', 'rejected']);

        // Filter Zona
        if ($request->filled('zona')) {
            $query->where('zona', $request->zona);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('workflow_status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $documents = $query->paginate(15)->withQueryString();

        return view('viewer.ranmor.index', compact('documents'));
    }

    public function show($id)
    {
        $document = $this->applySecurityFilter(RanmorDocument::with('findings'))
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->findOrFail($id);

        return view('viewer.ranmor.show', compact('document'));
    }
}
