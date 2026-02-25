@php
    $layout = 'layouts.app';
    if (Auth::user()->role === 'admin') $layout = 'layouts.admin';
    elseif (Auth::user()->role === 'petugas') $layout = 'layouts.petugas';
    elseif (Auth::user()->role === 'viewer') $layout = 'layouts.viewer';
@endphp

@extends($layout)

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
