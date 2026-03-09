@extends('layouts.admin')

@section('title', 'My Account')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- CARD 1: PROFILE INFORMATION --}}
        <div class="md:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-4 py-5 border-b border-gray-200 sm:px-6 flex flex-col items-center">
                    
                    {{-- AVATAR --}}
                    @if(Auth::user()->photo_path)
                        <img class="h-24 w-24 rounded-full object-cover mb-4" src="{{ asset('storage/' . Auth::user()->photo_path) }}" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="h-24 w-24 rounded-full bg-blue-500 flex items-center justify-center text-white text-3xl font-bold mb-4">
                            {{ substr(Auth::user()->name, 0, 1) . substr(strrchr(Auth::user()->name, ' '), 1, 1) }}
                        </div>
                    @endif

                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">
                        {{ Auth::user()->name }}
                    </h3>
                    
                    {{-- ROLE BADGE --}}
                    @php
                        $roleColors = [
                            'user' => 'bg-blue-100 text-blue-800',
                            'viewer' => 'bg-blue-100 text-blue-800',
                            'checker_lapangan' => 'bg-green-100 text-green-800',
                            'petugas' => 'bg-green-100 text-green-800',
                            'admin_perijinan' => 'bg-orange-100 text-orange-800',
                            'admin' => 'bg-orange-100 text-orange-800',
                            'avp' => 'bg-purple-100 text-purple-800',
                            'super_admin' => 'bg-red-100 text-red-800',
                        ];
                        $roleLabel = ucwords(str_replace('_', ' ', Auth::user()->role));
                        $badgeColor = $roleColors[Auth::user()->role] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }} mt-2">
                        {{ $roleLabel }}
                    </span>
                </div>
                
                <div class="px-4 py-5 sm:p-6 space-y-4">
                    
                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email Address</label>
                        <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</p>
                    </div>

                    {{-- NPK (ALL ROLES) --}}
                    @if(Auth::user()->npk)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">NPK / No Badge</label>
                        <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->npk }}</p>
                    </div>
                    @endif

                    {{-- DEPARTMENT (VIEWER ONLY) --}}
                    @if(in_array(Auth::user()->role, ['viewer', 'user']) && Auth::user()->department)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Department</label>
                        <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->department }}</p>
                    </div>
                    @endif

                    {{-- SECURITY CODE (VIEWER ONLY) --}}
                    @if(in_array(Auth::user()->role, ['viewer', 'user']) && Auth::user()->security_code)
                    <div class="pt-4 border-t border-gray-200">
                        <label class="block text-sm font-medium text-blue-600 mb-2">Security Code Identity</label>
                        <div class="flex items-center gap-2">
                            <code id="security-code" class="block w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm font-mono text-gray-800">
                                {{ Auth::user()->security_code }}
                            </code>
                            <button onclick="copyToClipboard()" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm font-medium transition-colors" title="Copy to Clipboard">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                        <p id="copy-feedback" class="text-xs text-green-600 mt-1 hidden">Copied to clipboard!</p>
                    </div>
                    @endif

                    {{-- ACCOUNT STATUS (VIEWER ONLY) --}}
                    @if(in_array(Auth::user()->role, ['viewer', 'user']))
                    <div class="pt-2">
                        <label class="block text-sm font-medium text-gray-500">Account Status</label>
                        @if($accountStatus === 'Active')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                Suspended until {{ $retryDate }}
                            </span>
                        @endif
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- CARD 2: PASSWORD UPDATE --}}
        <div class="md:col-span-2">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Update Password
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Ensure your account is using a long, random password to stay secure.
                    </p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    @if (session('status') === 'password-updated')
                        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        Password updated successfully.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="post" action="{{ route('account.password') }}" class="space-y-6">
                        @csrf

                        {{-- Current Password --}}
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" id="current_password" autocomplete="current-password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('current_password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" id="password" autocomplete="new-password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('password_confirmation', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const codeElement = document.getElementById('security-code');
        const code = codeElement.innerText.trim();
        
        navigator.clipboard.writeText(code).then(() => {
            const feedback = document.getElementById('copy-feedback');
            feedback.classList.remove('hidden');
            setTimeout(() => {
                feedback.classList.add('hidden');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endsection
