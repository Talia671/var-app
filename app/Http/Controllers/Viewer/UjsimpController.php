<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Ujsimp\UjsimpTest;
use Illuminate\Support\Facades\Auth;

class UjsimpController extends Controller
{
    public function index()
    {
        $userName = Auth::user()->name;
        $documents = UjsimpTest::where('nama', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->latest()
            ->get();

        return view('viewer.ujsimp.index', compact('documents'));
    }

    public function show($id)
    {
        $userName = Auth::user()->name;
        $test = UjsimpTest::with('scores')
            ->where('nama', $userName)
            ->whereIn('workflow_status', ['submitted', 'approved', 'rejected'])
            ->findOrFail($id);

        return view('viewer.ujsimp.show', compact('test'));
    }
}
