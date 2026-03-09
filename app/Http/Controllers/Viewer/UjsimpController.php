<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Ujsimp\UjsimpTest;
use Illuminate\Support\Facades\Auth;

class UjsimpController extends Controller
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
        $documents = $this->applySecurityFilter(UjsimpTest::query())
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->latest()
            ->paginate(15);

        return view('viewer.ujsimp.index', compact('documents'));
    }

    public function show($id)
    {
        $test = $this->applySecurityFilter(UjsimpTest::with('scores'))
            ->whereIn('workflow_status', ['approved', 'rejected'])
            ->findOrFail($id);

        return view('viewer.ujsimp.show', compact('test'));
    }
}
