<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use Illuminate\Support\Facades\Auth;

class SimperController extends Controller
{
    public function index()
    {
        $userName = Auth::user()->name;
        $documents = SimperDocument::where('nama', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->latest()
            ->get();

        return view('viewer.simper.index', compact('documents'));
    }

    public function show($id)
    {
        $userName = Auth::user()->name;
        $assessment = SimperDocument::with('notes')
            ->where('nama', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->findOrFail($id);

        return view('viewer.simper.show', compact('assessment'));
    }
}
