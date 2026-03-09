<?php

namespace App\Http\Controllers\Avp;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->input('range', 'month');
        $range = in_array($range, ['today', 'week', 'month'], true) ? $range : 'month';

        [$startAt, $endAt, $bucket, $labelKeys, $labels] = $this->resolveRange($range);

        $datasets = [
            'pending' => $this->statusSeries('verified', 'COALESCE(verified_at, updated_at, created_at)', $startAt, $endAt, $bucket, $labelKeys),
            'approved' => $this->statusSeries('approved', 'approved_at', $startAt, $endAt, $bucket, $labelKeys),
            'rejected' => $this->statusSeries('rejected', 'rejected_at', $startAt, $endAt, $bucket, $labelKeys),
        ];

        return view('avp.dashboard', [
            'range' => $range,
            'labels' => $labels,
            'datasets' => $datasets,
        ]);
    }

    private function resolveRange(string $range): array
    {
        $now = Carbon::now();

        if ($range === 'today') {
            $startAt = $now->copy()->startOfDay();
            $endAt = $now->copy()->endOfDay();
            $labelKeys = range(0, 23);
            $labels = array_map(fn ($h) => str_pad((string) $h, 2, '0', STR_PAD_LEFT).':00', $labelKeys);

            return [$startAt, $endAt, 'hour', $labelKeys, $labels];
        }

        $endAt = $now->copy();
        $startAt = $range === 'week' ? $endAt->copy()->startOfWeek() : $endAt->copy()->startOfMonth();

        $period = CarbonPeriod::create($startAt->copy()->startOfDay(), $endAt->copy()->startOfDay());
        $labelKeys = [];
        $labels = [];
        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $labelKeys[] = $key;
            $labels[] = $key;
        }

        return [$startAt, $endAt, 'day', $labelKeys, $labels];
    }

    private function statusSeries(
        string $workflowStatus,
        string $timestampExpression,
        Carbon $startAt,
        Carbon $endAt,
        string $bucket,
        array $labelKeys
    ): array {
        $tables = ['simper_documents', 'ujsimp_tests', 'checkup_documents', 'ranmor_documents'];
        $bucketExpr = $bucket === 'hour'
            ? "HOUR($timestampExpression) as bucket"
            : "DATE($timestampExpression) as bucket";

        $unionQuery = null;
        foreach ($tables as $table) {
            $select = DB::table($table)
                ->where('workflow_status', $workflowStatus)
                ->whereRaw("$timestampExpression BETWEEN ? AND ?", [$startAt, $endAt])
                ->selectRaw($bucketExpr);

            $unionQuery = $unionQuery ? $unionQuery->unionAll($select) : $select;
        }

        $raw = DB::query()
            ->fromSub($unionQuery, 't')
            ->selectRaw('bucket, count(*) as total')
            ->groupBy('bucket')
            ->pluck('total', 'bucket')
            ->toArray();

        $result = [];
        foreach ($labelKeys as $key) {
            $result[] = (int) ($raw[$key] ?? $raw[(string) $key] ?? 0);
        }

        return $result;
    }
}
