<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;
use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userName = Auth::user()->name;

        $totalSimper = SimperDocument::where('workflow_status', 'approved')
            ->where('nama', $userName)
            ->count();
            
        $totalUjsimp = UjsimpTest::where('workflow_status', 'approved')
            ->where('nama', $userName)
            ->count();
            
        $totalCheckup = CheckupDocument::where('workflow_status', 'approved')
            ->where('nama_pengemudi', $userName)
            ->count();
            
        $totalRanmor = RanmorDocument::where('workflow_status', 'approved')
            ->where('pengemudi', $userName)
            ->count();

        return view('viewer.dashboard', compact('totalSimper', 'totalUjsimp', 'totalCheckup', 'totalRanmor'));
    }

    public function simper()
    {
        $userName = Auth::user()->name;
        $documents = SimperDocument::where('workflow_status', 'approved')
            ->where('nama', $userName)
            ->latest()
            ->get();
        return view('viewer.simper.index', compact('documents'));
    }

    public function ujsimp()
    {
        $userName = Auth::user()->name;
        $documents = UjsimpTest::where('workflow_status', 'approved')
            ->where('nama', $userName)
            ->latest()
            ->get();
        return view('viewer.ujsimp.index', compact('documents'));
    }

    public function checkup()
    {
        $userName = Auth::user()->name;
        $documents = CheckupDocument::where('workflow_status', 'approved')
            ->where('nama_pengemudi', $userName)
            ->latest()
            ->get();
        return view('viewer.checkup.index', compact('documents'));
    }

    public function ranmor()
    {
        $userName = Auth::user()->name;
        $documents = RanmorDocument::where('workflow_status', 'approved')
            ->where('pengemudi', $userName)
            ->latest()
            ->get();
        return view('viewer.ranmor.index', compact('documents'));
    }
}
