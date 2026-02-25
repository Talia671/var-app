@extends('layouts.admin')

@section('content')
<div x-data="{ viewMode: 'cards' }">
    <!-- Header & Controls -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Admin</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Ringkasan statistik pengajuan dokumen</p>
        </div>
        
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <!-- View Switch -->
            <div class="bg-gray-200 dark:bg-gray-700 p-1 rounded-lg flex items-center">
                <button @click="viewMode = 'cards'" 
                        :class="viewMode === 'cards' ? 'bg-white dark:bg-gray-600 text-secondary dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                        class="px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Cards
                </button>
                <button @click="viewMode = 'chart'" 
                        :class="viewMode === 'chart' ? 'bg-white dark:bg-gray-600 text-secondary dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                        class="px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Chart
                </button>
            </div>

            <!-- Time Filter -->
            <form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}">
                <select name="filter" onchange="document.getElementById('filterForm').submit()"
                        class="form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white cursor-pointer">
                    <option value="1_day" {{ $filter == '1_day' ? 'selected' : '' }}>1 Hari Terakhir</option>
                    <option value="3_days" {{ $filter == '3_days' ? 'selected' : '' }}>3 Hari Terakhir</option>
                    <option value="1_week" {{ $filter == '1_week' ? 'selected' : '' }}>1 Minggu Terakhir</option>
                    <option value="1_month" {{ $filter == '1_month' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                </select>
            </form>
        </div>
    </div>

    <!-- CARDS VIEW -->
    <div x-show="viewMode === 'cards'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- SIMPER Card -->
        <div class="bg-white dark:bg-night-card rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 dark:border-night-border group relative">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">SIMPER</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $simperStats['approved'] }}</h3>
                        <p class="text-xs text-green-500 font-semibold mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Approved
                        </p>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-secondary dark:text-blue-400 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-xs">
                    <span class="text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-md font-medium">{{ $simperStats['pending'] }} Pending</span>
                    <a href="{{ route('admin.simper.index') }}" class="text-secondary dark:text-blue-400 hover:text-blue-600 font-semibold flex items-center transition-colors">
                        View Details 
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            <!-- Bottom Accent -->
            <div class="absolute bottom-0 left-0 w-full h-1 bg-secondary"></div>
        </div>

        <!-- UJSIMP Card -->
        <div class="bg-white dark:bg-night-card rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 dark:border-night-border group relative">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">UJSIMP</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $ujsimpStats['approved'] }}</h3>
                        <p class="text-xs text-green-500 font-semibold mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Approved
                        </p>
                    </div>
                    <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-xl text-primary dark:text-orange-400 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-xs">
                    <span class="text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-md font-medium">{{ $ujsimpStats['pending'] }} Pending</span>
                    <a href="{{ route('admin.ujsimp.index') }}" class="text-primary dark:text-orange-400 hover:text-orange-600 font-semibold flex items-center transition-colors">
                        View Details 
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-primary"></div>
        </div>

        <!-- CHECKUP Card -->
        <div class="bg-white dark:bg-night-card rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 dark:border-night-border group relative">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">CHECKUP</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $checkupStats['approved'] }}</h3>
                        <p class="text-xs text-green-500 font-semibold mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Approved
                        </p>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-xs">
                    <span class="text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-md font-medium">{{ $checkupStats['pending'] }} Pending</span>
                    <a href="{{ route('admin.checkup.index') }}" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 font-semibold flex items-center transition-colors">
                        View Details 
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500"></div>
        </div>

        <!-- RANMOR Card -->
        <div class="bg-white dark:bg-night-card rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 dark:border-night-border group relative">
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">RANMOR</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $ranmorStats['approved'] }}</h3>
                        <p class="text-xs text-green-500 font-semibold mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Approved
                        </p>
                    </div>
                    <div class="p-3 bg-violet-50 dark:bg-violet-900/20 rounded-xl text-violet-600 dark:text-violet-400 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-xs">
                    <span class="text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-md font-medium">{{ $ranmorStats['pending'] }} Pending</span>
                    <a href="{{ route('admin.ranmor.index') }}" class="text-violet-600 dark:text-violet-400 hover:text-violet-700 font-semibold flex items-center transition-colors">
                        View Details 
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-violet-500"></div>
        </div>
    </div>

    <!-- CHART VIEW -->
    <div x-show="viewMode === 'chart'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white dark:bg-night-card rounded-xl shadow-lg p-6 border border-gray-100 dark:border-night-border"
         style="display: none;"> <!-- Hidden by default, Alpine handles visibility -->
        
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Trend Pengajuan Dokumen</h3>
        </div>

        <div class="relative h-96 w-full">
            <canvas id="approvalChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Chart
        const ctx = document.getElementById('approvalChart').getContext('2d');
        // Gunakan JSON.parse dengan single quotes untuk menghindari error syntax highlighter/linter
        const chartData = JSON.parse('{!! json_encode($chartData, JSON_HEX_APOS) !!}');
        
        // Dark Mode Detection for Chart Theme
        const isDarkMode = document.documentElement.classList.contains('dark');
        
        // Colors
        const colors = {
            simper: '#1268B3',
            ujsimp: '#F47920',
            checkup: '#10B981',
            ranmor: '#8B5CF6'
        };

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'SIMPER',
                        data: chartData.simper,
                        borderColor: colors.simper,
                        backgroundColor: colors.simper,
                        borderWidth: 2,
                        tension: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: colors.simper,
                        pointHoverBackgroundColor: colors.simper,
                        pointHoverBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: false
                    },
                    {
                        label: 'UJSIMP',
                        data: chartData.ujsimp,
                        borderColor: colors.ujsimp,
                        backgroundColor: colors.ujsimp,
                        borderWidth: 2,
                        tension: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: colors.ujsimp,
                        pointHoverBackgroundColor: colors.ujsimp,
                        pointHoverBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: false
                    },
                    {
                        label: 'CheckUp',
                        data: chartData.checkup,
                        borderColor: colors.checkup,
                        backgroundColor: colors.checkup,
                        borderWidth: 2,
                        tension: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: colors.checkup,
                        pointHoverBackgroundColor: colors.checkup,
                        pointHoverBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: false
                    },
                    {
                        label: 'RANMOR',
                        data: chartData.ranmor,
                        borderColor: colors.ranmor,
                        backgroundColor: colors.ranmor,
                        borderWidth: 2,
                        tension: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: colors.ranmor,
                        pointHoverBackgroundColor: colors.ranmor,
                        pointHoverBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            color: isDarkMode ? '#94a3b8' : '#64748b'
                        }
                    },
                    tooltip: {
                        backgroundColor: isDarkMode ? 'rgba(30, 41, 59, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                        titleColor: isDarkMode ? '#f8fafc' : '#1e293b',
                        bodyColor: isDarkMode ? '#f8fafc' : '#334155',
                        borderColor: isDarkMode ? '#334155' : '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + ' Pengajuan';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pengajuan',
                            color: isDarkMode ? '#94a3b8' : '#64748b'
                        },
                        grid: {
                            color: isDarkMode ? '#334155' : '#e2e8f0',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: isDarkMode ? '#94a3b8' : '#64748b',
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: isDarkMode ? '#94a3b8' : '#64748b',
                            maxTicksLimit: 10
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
