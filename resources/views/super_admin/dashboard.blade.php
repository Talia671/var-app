@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Super Admin Dashboard</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">System Overview & Statistics</p>
        </div>

        <!-- STATISTICS GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- USER STATISTICS CARD -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        User Statistics
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Internal Users</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $userStats['internal_users'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Admin, Petugas, AVP</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-green-500 uppercase tracking-wider">External Users</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $userStats['external_users'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Registered Viewers</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-purple-500 uppercase tracking-wider">Active Users</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $userStats['active_users'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Email Verified</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Inactive Users</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $userStats['inactive_users'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Unverified</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EXAM STATISTICS CARD -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Exam Statistics
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider">Submitted</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $examStats['submitted'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Pending Review</p>
                        </div>
                        <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Verified</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $examStats['verified'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Ready for Approval</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Approved</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $examStats['approved'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Completed</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg text-center">
                            <p class="text-xs font-bold text-red-600 uppercase tracking-wider">Rejected</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $examStats['rejected'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Failed/Returned</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
