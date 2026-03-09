@extends('layouts.admin')

@section('title', 'AVP Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">AVP Dashboard</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Analitik beban kerja approval</p>
            </div>

            <form method="GET" action="{{ route('avp.dashboard') }}" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <select name="range" onchange="this.form.submit()"
                        class="form-select block w-full sm:w-44 pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white cursor-pointer">
                    <option value="today" {{ $range === 'today' ? 'selected' : '' }}>Hari ini</option>
                    <option value="week" {{ $range === 'week' ? 'selected' : '' }}>Minggu ini</option>
                    <option value="month" {{ $range === 'month' ? 'selected' : '' }}>Bulan ini</option>
                </select>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Approval Workload</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pending Approval (Verified) vs Approved vs Rejected (semua modul)</p>
            </div>
            <div class="p-6">
                <div class="relative h-96 w-full">
                    <canvas id="chartApprovalWorkload"></canvas>
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

        const labels = {!! json_encode($labels) !!};
        const datasets = {!! json_encode($datasets) !!};

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

        const ctx = document.getElementById('chartApprovalWorkload');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pending Approval',
                        data: datasets.pending,
                        borderColor: '#F59E0B',
                        backgroundColor: '#F59E0B',
                        borderWidth: 2,
                        tension: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#F59E0B',
                        pointHoverBackgroundColor: '#F59E0B',
                        pointHoverBorderColor: '#fff',
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        fill: false,
                    },
                    {
                        label: 'Approved',
                        data: datasets.approved,
                        borderColor: '#10B981',
                        backgroundColor: '#10B981',
                        borderWidth: 2,
                        tension: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10B981',
                        pointHoverBackgroundColor: '#10B981',
                        pointHoverBorderColor: '#fff',
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        fill: false,
                    },
                    {
                        label: 'Rejected',
                        data: datasets.rejected,
                        borderColor: '#EF4444',
                        backgroundColor: '#EF4444',
                        borderWidth: 2,
                        tension: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#EF4444',
                        pointHoverBackgroundColor: '#EF4444',
                        pointHoverBorderColor: '#fff',
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        fill: false,
                    }
                ],
            },
            options: commonOptions,
        });
    });
</script>
@endpush
