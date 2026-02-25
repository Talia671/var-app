<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simper\SimperDocument;
use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Ujsimp\UjsimpTest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. FILTER LOGIC
        $filter = $request->input('filter', '1_month');
        $endDate = now();
        $startDate = match($filter) {
            '1_day' => now()->subDay(),
            '3_days' => now()->subDays(3),
            '1_week' => now()->subWeek(),
            default => now()->subMonth(),
        };

        // 2. EXISTING STATS (Overall Counts - Not affected by filter usually, but maybe they should be? 
        // The prompt says "berikan design informasi terkait statistik... yang dimana design nya mengikuti mode pagi/malam. menggunakan 2 tampilan... box card berisi jumlah approval 4 document tersebut, terdapat menu dropdown yang digunakan untuk menampilkan filter 1 hari..."
        // This implies the Box Cards ALSO depend on the filter.
        // So I should apply filters to the stats too.

        // SIMPER (Assessment)
        $simperStats = $this->getStats(SimperDocument::class, 'status', $startDate, $endDate);
        
        // UJSIMP
        $ujsimpStats = $this->getStats(UjsimpTest::class, 'workflow_status', $startDate, $endDate);

        // CHECKUP
        $checkupStats = $this->getStats(CheckupDocument::class, 'workflow_status', $startDate, $endDate);

        // RANMOR
        $ranmorStats = $this->getStats(RanmorDocument::class, 'workflow_status', $startDate, $endDate);

        // 3. CHART DATA (Daily Approved Counts)
        $chartData = $this->getChartData($startDate, $endDate);

        return view('admin.dashboard', compact(
            'simperStats',
            'ujsimpStats',
            'checkupStats',
            'ranmorStats',
            'chartData',
            'filter'
        ));
    }

    private function getStats($model, $statusColumn, $startDate, $endDate)
    {
        // We need counts for Pending, Approved, Rejected within the timeframe?
        // Or just total approvals?
        // The prompt says "berisi jumlah approval 4 document tersebut".
        // And "terdapat menu dropdown yang digunakan untuk menampilkan filter".
        // It seems the box cards show the "Approval Count" based on the filter.
        
        // Let's get counts for all statuses just in case, filtered by created_at or approved_at?
        // Usually stats are based on when they were created or when they were acted upon.
        // For "Approval Count", it should be based on `approved_at`.
        
        return [
            'approved' => $model::where($statusColumn, 'approved')
                ->whereBetween('approved_at', [$startDate, $endDate])
                ->count(),
            'pending' => $model::whereIn($statusColumn, ['pending', 'submitted'])
                // For pending, we might want to show ALL pending, not just those created recently.
                // But if the filter implies "Performance in the last week", maybe just approved?
                // The prompt says "jumlah approval 4 document tersebut".
                // So specifically Approval Count.
                // But usually dashboards show Pending tasks too.
                // Let's count Pending (Total) and Approved (Filtered).
                ->count(),
            'rejected' => $model::where($statusColumn, 'rejected')
                ->whereBetween('updated_at', [$startDate, $endDate]) // Rejected at?
                ->count(),
        ];
    }

    private function getChartData($startDate, $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        // Helper query: Count submitted documents based on created_at
        $query = function($model) use ($startDate, $endDate) {
            $data = $model::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw("DATE(created_at) as date, count(*) as count")
                ->groupBy('date')
                ->pluck('count', 'date')
                ->toArray();
            return $data;
        };

        $simperData = $query(SimperDocument::class);
        $ujsimpData = $query(UjsimpTest::class);
        $checkupData = $query(CheckupDocument::class);
        $ranmorData = $query(RanmorDocument::class);

        return [
            'labels' => $dates,
            'simper' => $this->fillDates($dates, $simperData),
            'ujsimp' => $this->fillDates($dates, $ujsimpData),
            'checkup' => $this->fillDates($dates, $checkupData),
            'ranmor' => $this->fillDates($dates, $ranmorData),
        ];
    }

    private function fillDates($dates, $data)
    {
        $result = [];
        foreach ($dates as $date) {
            $result[] = $data[$date] ?? 0;
        }
        return $result;
    }
}
