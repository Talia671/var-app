<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ranmor\RanmorDocument;
use Illuminate\Support\Facades\Auth;

class RanmorController extends Controller
{
    public function index(Request $request)
    {
        $userName = Auth::user()->name;
        $query = RanmorDocument::where('pengemudi', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected']);

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

        $documents = $query->paginate(10)->withQueryString();

        return view('viewer.ranmor.index', compact('documents'));
    }

    public function show($id)
    {
        $userName = Auth::user()->name;
        $document = RanmorDocument::with('findings')
            ->where('pengemudi', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->findOrFail($id);

        return view('viewer.ranmor.show', compact('document'));
    }
}