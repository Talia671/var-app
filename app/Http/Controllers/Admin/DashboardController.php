<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->input('range', 'month');
        $category = $request->input('category', 'all');

        $range = in_array($range, ['today', 'week', 'month'], true) ? $range : 'month';
        $category = in_array($category, ['all', 'simper', 'ujsimp', 'checkup', 'ranmor'], true) ? $category : 'all';

        [$startAt, $endAt, $bucket, $labelKeys, $labels] = $this->resolveRange($range);

        $modules = $this->moduleConfig();
        $selectedModules = $category === 'all' ? $modules : [$category => $modules[$category]];

        $chartSubmitted = $this->buildTimeSeriesChart($selectedModules, $startAt, $endAt, $bucket, $labelKeys, $labels);
        $chartPending = $this->buildTimeSeriesChart(
            $selectedModules,
            $startAt,
            $endAt,
            $bucket,
            $labelKeys,
            $labels,
            fn ($query) => $query->where('workflow_status', 'submitted')
        );

        [$verifiedTotal, $rejectedTotal] = $this->verificationTotals($startAt, $endAt);

        $chartVerificationResult = [
            'labels' => ['Verified', 'Rejected'],
            'data' => [$verifiedTotal, $rejectedTotal],
        ];

        return view('admin.dashboard', [
            'range' => $range,
            'category' => $category,
            'chartSubmitted' => $chartSubmitted,
            'chartPending' => $chartPending,
            'chartVerificationResult' => $chartVerificationResult,
        ]);
    }

    private function moduleConfig(): array
    {
        return [
            'simper' => [
                'label' => 'SIMPER',
                'model' => SimperDocument::class,
                'color' => '#1268B3',
            ],
            'ujsimp' => [
                'label' => 'UJSIMP',
                'model' => UjsimpTest::class,
                'color' => '#F47920',
            ],
            'checkup' => [
                'label' => 'Checklist',
                'model' => CheckupDocument::class,
                'color' => '#10B981',
            ],
            'ranmor' => [
                'label' => 'Ranmor',
                'model' => RanmorDocument::class,
                'color' => '#8B5CF6',
            ],
        ];
    }

    private function resolveRange(string $range): array
    {
        $endAt = Carbon::now();

        if ($range === 'today') {
            $startAt = $endAt->copy()->startOfDay();
            $labelKeys = range(0, 23);
            $labels = array_map(fn ($h) => str_pad((string) $h, 2, '0', STR_PAD_LEFT).':00', $labelKeys);
            return [$startAt, $endAt, 'hour', $labelKeys, $labels];
        }

        if ($range === 'week') {
            $startAt = $endAt->copy()->startOfWeek();
        } else {
            $startAt = $endAt->copy()->startOfMonth();
        }

        $period = CarbonPeriod::create($startAt->copy()->startOfDay(), $endAt->copy()->startOfDay());
        $labelKeys = [];
        $labels = [];
        foreach ($period as $date) {
            $labelKeys[] = $date->format('Y-m-d');
            $labels[] = $date->format('Y-m-d');
        }

        return [$startAt, $endAt, 'day', $labelKeys, $labels];
    }

    private function buildTimeSeriesChart(
        array $modules,
        Carbon $startAt,
        Carbon $endAt,
        string $bucket,
        array $labelKeys,
        array $labels,
        ?callable $applyFilters = null
    ): array {
        $datasets = [];

        foreach ($modules as $moduleKey => $module) {
            $series = $this->timeSeriesForModel($module['model'], $startAt, $endAt, $bucket, $labelKeys, $applyFilters);
            $datasets[] = [
                'key' => $moduleKey,
                'label' => $module['label'],
                'color' => $module['color'],
                'data' => $series,
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    private function timeSeriesForModel(
        string $modelClass,
        Carbon $startAt,
        Carbon $endAt,
        string $bucket,
        array $labelKeys,
        ?callable $applyFilters
    ): array {
        $query = $modelClass::query()->whereBetween('created_at', [$startAt, $endAt]);

        if ($applyFilters) {
            $applyFilters($query);
        }

        if ($bucket === 'hour') {
            $raw = $query
                ->selectRaw('HOUR(created_at) as bucket, count(*) as total')
                ->groupBy('bucket')
                ->pluck('total', 'bucket')
                ->toArray();
        } else {
            $raw = $query
                ->selectRaw('DATE(created_at) as bucket, count(*) as total')
                ->groupBy('bucket')
                ->pluck('total', 'bucket')
                ->toArray();
        }

        $result = [];
        foreach ($labelKeys as $key) {
            $result[] = (int) ($raw[$key] ?? 0);
        }

        return $result;
    }

    private function verificationTotals(Carbon $startAt, Carbon $endAt): array
    {
        $verified = 0;
        $rejected = 0;

        $verified += SimperDocument::where('workflow_status', 'verified')->whereBetween('verified_at', [$startAt, $endAt])->count();
        $verified += UjsimpTest::where('workflow_status', 'verified')->whereBetween('verified_at', [$startAt, $endAt])->count();
        $verified += CheckupDocument::where('workflow_status', 'verified')->whereBetween('verified_at', [$startAt, $endAt])->count();
        $verified += RanmorDocument::where('workflow_status', 'verified')->whereBetween('verified_at', [$startAt, $endAt])->count();

        $rejected += SimperDocument::where('workflow_status', 'rejected')->whereBetween('rejected_at', [$startAt, $endAt])->count();
        $rejected += UjsimpTest::where('workflow_status', 'rejected')->whereBetween('rejected_at', [$startAt, $endAt])->count();
        $rejected += CheckupDocument::where('workflow_status', 'rejected')->whereBetween('rejected_at', [$startAt, $endAt])->count();
        $rejected += RanmorDocument::where('workflow_status', 'rejected')->whereBetween('rejected_at', [$startAt, $endAt])->count();

        return [$verified, $rejected];
    }
}
