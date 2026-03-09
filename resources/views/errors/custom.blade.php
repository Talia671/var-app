@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="bg-white dark:bg-night-card p-8 rounded-xl shadow-lg border border-gray-100 dark:border-night-border max-w-md w-full text-center">
        <div class="mb-6">
            <div class="bg-red-100 dark:bg-red-900/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto text-red-600 dark:text-red-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Ops! Terjadi Kesalahan</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-8">{{ $message ?? 'Maaf, terjadi kesalahan sistem.' }}</p>
        <div class="space-y-3">
            <a href="{{ url()->previous() }}" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Kembali
            </a>
            <a href="{{ route('dashboard') }}" class="block w-full px-4 py-2 bg-secondary text-white rounded-lg hover:bg-blue-600 transition-colors">
                Ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
