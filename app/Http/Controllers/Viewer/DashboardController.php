<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function applySecurityFilter($query, $nameColumn = 'nama')
    {
        $user = Auth::user();
        return $query->where(function ($q) use ($user, $nameColumn) {
            if ($user->security_code) {
                $q->where('security_code', $user->security_code);
            }
            // Fallback for legacy documents
            $q->orWhere(function ($sub) use ($user, $nameColumn) {
                $sub->whereNull('security_code')
                    ->where($nameColumn, $user->name);
            });
        });
    }

    public function index()
    {
        $totalSimper = $this->applySecurityFilter(SimperDocument::where('workflow_status', 'approved'), 'nama')->count();
        $totalUjsimp = $this->applySecurityFilter(UjsimpTest::where('workflow_status', 'approved'), 'nama')->count();
        $totalCheckup = $this->applySecurityFilter(CheckupDocument::where('workflow_status', 'approved'), 'nama_pengemudi')->count();
        $totalRanmor = $this->applySecurityFilter(RanmorDocument::where('workflow_status', 'approved'), 'pengemudi')->count();

        return view('viewer.dashboard', compact('totalSimper', 'totalUjsimp', 'totalCheckup', 'totalRanmor'));
    }

    public function simper()
    {
        $documents = $this->applySecurityFilter(SimperDocument::where('workflow_status', 'approved'), 'nama')
            ->latest()
            ->paginate(15);

        return view('viewer.simper.index', compact('documents'));
    }

    public function ujsimp()
    {
        $documents = $this->applySecurityFilter(UjsimpTest::where('workflow_status', 'approved'), 'nama')
            ->latest()
            ->paginate(15);

        return view('viewer.ujsimp.index', compact('documents'));
    }

    public function checkup()
    {
        $documents = $this->applySecurityFilter(CheckupDocument::where('workflow_status', 'approved'), 'nama_pengemudi')
            ->latest()
            ->paginate(15);

        return view('viewer.checkup.index', compact('documents'));
    }

    public function ranmor()
    {
        $documents = $this->applySecurityFilter(RanmorDocument::where('workflow_status', 'approved'), 'pengemudi')
            ->latest()
            ->paginate(15);

        return view('viewer.ranmor.index', compact('documents'));
    }
}
