<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use Illuminate\Support\Facades\Auth;

class SimperController extends Controller
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
                    ->where('nama', $user->name);
            });
        });
    }

    public function index()
    {
        $documents = $this->applySecurityFilter(SimperDocument::query())
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->latest()
            ->paginate(15);

        return view('viewer.simper.index', compact('documents'));
    }

    public function show($id)
    {
        $assessment = $this->applySecurityFilter(SimperDocument::with('notes'))
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->findOrFail($id);

        return view('viewer.simper.show', compact('assessment'));
    }
}
