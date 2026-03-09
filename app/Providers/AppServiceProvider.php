<?php

namespace App\Providers;

use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.sidebar', function ($view) {
            if (! auth()->check()) {
                return;
            }

            $role = auth()->user()->role;
            if (! in_array($role, ['admin', 'admin_perijinan'], true)) {
                return;
            }

            $view->with('pendingVerificationCounts', [
                'simper' => SimperDocument::where('workflow_status', 'submitted')->count(),
                'ujsimp' => UjsimpTest::where('workflow_status', 'submitted')->count(),
                'checkup' => CheckupDocument::where('workflow_status', 'submitted')->count(),
                'ranmor' => RanmorDocument::where('workflow_status', 'submitted')->count(),
            ]);
        });
    }
}
