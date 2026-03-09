@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="container-page">
        {{-- HIDDEN DATA CONTAINER FOR CHARTS --}}
        <div id="dashboard-chart-data" 
             data-submitted="{{ json_encode($chartSubmitted) }}"
             data-pending="{{ json_encode($chartPending) }}"
             data-verification="{{ json_encode($chartVerificationResult) }}"
             class="hidden">
        </div>

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
            <div>
                <h2 class="page-title">Dashboard Admin Perijinan</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Statistik form dan verifikasi</p>
            </div>

            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <select name="range" onchange="this.form.submit()"
                        class="form-select block w-full sm:w-44 pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white cursor-pointer">
                    <option value="today" {{ $range === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ $range === 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ $range === 'month' ? 'selected' : '' }}>This Month</option>
                </select>

                <select name="category" onchange="this.form.submit()"
                        class="form-select block w-full sm:w-44 pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white cursor-pointer">
                    <option value="all" {{ $category === 'all' ? 'selected' : '' }}>All Form</option>
                    <option value="simper" {{ $category === 'simper' ? 'selected' : '' }}>Simper</option>
                    <option value="ujsimp" {{ $category === 'ujsimp' ? 'selected' : '' }}>UJSIMP</option>
                    <option value="checkup" {{ $category === 'checkup' ? 'selected' : '' }}>Checklist</option>
                    <option value="ranmor" {{ $category === 'ranmor' ? 'selected' : '' }}>Ranmor</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <div class="card-ui">
                <div class="mb-4">
                    <h3 class="card-header text-gray-800 dark:text-white">Form Submitted by Checker</h3>
                    <p class="card-body text-xs text-gray-500 dark:text-gray-400 mt-1">Jumlah form dibuat (group by module)</p>
                </div>
                <div class="relative h-80 w-full">
                    <canvas id="chartSubmitted"></canvas>
                </div>
            </div>

            <div class="card-ui">
                <div class="mb-4">
                    <h3 class="card-header text-gray-800 dark:text-white">Form Pending Verification</h3>
                    <p class="card-body text-xs text-gray-500 dark:text-gray-400 mt-1">Pending = workflow_status submitted</p>
                </div>
                <div class="relative h-80 w-full">
                    <canvas id="chartPending"></canvas>
                </div>
            </div>

            <div class="card-ui">
                <div class="mb-4">
                    <h3 class="card-header text-gray-800 dark:text-white">Verification Result</h3>
                    <p class="card-body text-xs text-gray-500 dark:text-gray-400 mt-1">Verified vs Rejected (all modules)</p>
                </div>
                <div class="relative h-72 w-full">
                    <canvas id="chartVerificationResult"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Chart === 'undefined') return;

        const isDarkMode = document.documentElement.classList.contains('dark');
        const gridColor = isDarkMode ? 'rgba(55, 65, 81, 0.3)' : 'rgba(229, 231, 235, 0.8)';
        const tickColor = isDarkMode ? '#9ca3af' : '#6b7280';
        const legendColor = isDarkMode ? '#e5e7eb' : '#4b5563';

        // Read data from DOM attributes to avoid linter errors with Blade syntax
        const dataContainer = document.getElementById('dashboard-chart-data');
        if (!dataContainer) return;

        const chartSubmitted = JSON.parse(dataContainer.dataset.submitted || '{}');
        const chartPending = JSON.parse(dataContainer.dataset.pending || '{}');
        const chartVerificationResult = JSON.parse(dataContainer.dataset.verification || '{}');

        const buildLineDatasets = (datasets) => datasets.map((d) => ({
            label: d.label,
            data: d.data,
            borderColor: d.color,
            backgroundColor: d.color,
            borderWidth: 2,
            tension: 0,
            pointBackgroundColor: '#fff',
            pointBorderColor: d.color,
            pointHoverBackgroundColor: d.color,
            pointHoverBorderColor: '#fff',
            pointRadius: 3,
            pointHoverRadius: 5,
            fill: false,
        }));

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { size: 12, family: "'Inter', sans-serif", weight: '600' },
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        color: legendColor,
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: isDarkMode ? 'rgba(17, 24, 39, 0.9)' : 'rgba(255, 255, 255, 0.9)',
                    titleColor: isDarkMode ? '#f9fafb' : '#111827',
                    bodyColor: isDarkMode ? '#e5e7eb' : '#4b5563',
                    borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    boxPadding: 6,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: tickColor, font: { size: 11 } },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: tickColor, precision: 0, font: { size: 11 } },
                }
            },
            interaction: { mode: 'nearest', axis: 'x', intersect: false },
        };

        const submittedCtx = document.getElementById('chartSubmitted');
        if (submittedCtx) {
            new Chart(submittedCtx, {
                type: 'line',
                data: {
                    labels: chartSubmitted.labels,
                    datasets: buildLineDatasets(chartSubmitted.datasets),
                },
                options: commonOptions,
            });
        }

        const pendingCtx = document.getElementById('chartPending');
        if (pendingCtx) {
            new Chart(pendingCtx, {
                type: 'line',
                data: {
                    labels: chartPending.labels,
                    datasets: buildLineDatasets(chartPending.datasets),
                },
                options: commonOptions,
            });
        }

        const resultCtx = document.getElementById('chartVerificationResult');
        if (resultCtx) {
            new Chart(resultCtx, {
                type: 'bar',
                data: {
                    labels: chartVerificationResult.labels,
                    datasets: [{
                        label: 'Total',
                        data: chartVerificationResult.data,
                        backgroundColor: ['#10B981', '#EF4444'],
                        borderRadius: 8,
                    }],
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        legend: { display: false },
                        tooltip: commonOptions.plugins.tooltip,
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: tickColor, font: { size: 12, weight: '600' } },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: { color: tickColor, precision: 0, font: { size: 11 } },
                        }
                    }
                },
            });
        }
    });
</script>
@endpush
