@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">System Monitoring</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Monitor system activity and logs</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- LOGIN LOGS CARD -->
            <a href="{{ route('super-admin.monitoring.login') }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow border border-gray-100 dark:border-gray-700 overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">All User Login</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['login'] }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full text-blue-600 dark:text-blue-400 group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-blue-600 dark:text-blue-400 font-medium flex items-center">
                        View Details 
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            </a>

            <!-- REGISTER LOGS CARD -->
            <a href="{{ route('super-admin.monitoring.register') }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow border border-gray-100 dark:border-gray-700 overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User Register</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['register'] }}</h3>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full text-green-600 dark:text-green-400 group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-green-600 dark:text-green-400 font-medium flex items-center">
                        View Details 
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- EXAM ACTIVITY CARD -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Exam Activity
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    <!-- CREATED -->
                    <a href="{{ route('super-admin.monitoring.exam.created') }}" class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg text-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Created</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['exam']['created'] }}</p>
                        <span class="text-xs text-purple-500 font-medium mt-1 inline-block group-hover:underline">View Logs</span>
                    </a>

                    <!-- SUBMITTED -->
                    <a href="{{ route('super-admin.monitoring.exam.submitted') }}" class="bg-yellow-50 dark:bg-yellow-900/10 p-4 rounded-lg text-center hover:bg-yellow-100 dark:hover:bg-yellow-900/20 transition-colors group">
                        <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider">Submitted</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['exam']['submitted'] }}</p>
                        <span class="text-xs text-yellow-600 font-medium mt-1 inline-block group-hover:underline">View Logs</span>
                    </a>

                    <!-- VERIFIED -->
                    <a href="{{ route('super-admin.monitoring.exam.verified') }}" class="bg-blue-50 dark:bg-blue-900/10 p-4 rounded-lg text-center hover:bg-blue-100 dark:hover:bg-blue-900/20 transition-colors group">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Verified</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['exam']['verified'] }}</p>
                        <span class="text-xs text-blue-600 font-medium mt-1 inline-block group-hover:underline">View Logs</span>
                    </a>

                    <!-- APPROVED -->
                    <a href="{{ route('super-admin.monitoring.exam.approved') }}" class="bg-green-50 dark:bg-green-900/10 p-4 rounded-lg text-center hover:bg-green-100 dark:hover:bg-green-900/20 transition-colors group">
                        <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Approved</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['exam']['approved'] }}</p>
                        <span class="text-xs text-green-600 font-medium mt-1 inline-block group-hover:underline">View Logs</span>
                    </a>

                    <!-- REJECTED -->
                    <a href="{{ route('super-admin.monitoring.exam.rejected') }}" class="bg-red-50 dark:bg-red-900/10 p-4 rounded-lg text-center hover:bg-red-100 dark:hover:bg-red-900/20 transition-colors group">
                        <p class="text-xs font-bold text-red-600 uppercase tracking-wider">Rejected</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['exam']['rejected'] }}</p>
                        <span class="text-xs text-red-600 font-medium mt-1 inline-block group-hover:underline">View Logs</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
