@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">User Details</h2>
            <a href="{{ route('super-admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                &larr; Back to List
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            
            <!-- User Info Header -->
            <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex items-center space-x-6">
                <div class="h-20 w-20 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-2xl font-bold text-blue-600 dark:text-blue-400">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($user->role === 'super_admin') bg-purple-100 text-purple-800 
                        @elseif($user->role === 'admin_perijinan') bg-blue-100 text-blue-800 
                        @elseif($user->role === 'avp') bg-orange-100 text-orange-800 
                        @elseif($user->role === 'checker_lapangan') bg-green-100 text-green-800 
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
            </div>

            <!-- Details List -->
            <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Personal Info -->
                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Personal Information</h4>
                    
                    <div class="border-b border-gray-100 dark:border-gray-700 pb-2">
                        <label class="block text-xs text-gray-400">NPK</label>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                            {{-- Assuming NPK is not in User model, checking related documents or fallback --}}
                            {{ $ujsimp->npk ?? ($checkup->npk ?? '-') }}
                        </p>
                    </div>

                    <div class="border-b border-gray-100 dark:border-gray-700 pb-2">
                        <label class="block text-xs text-gray-400">Department</label>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                             {{-- Assuming Department is linked to Company or Perusahaan --}}
                             {{ $ujsimp->perusahaan ?? ($checkup->perusahaan ?? '-') }}
                        </p>
                    </div>

                    <div class="border-b border-gray-100 dark:border-gray-700 pb-2">
                        <label class="block text-xs text-gray-400">Token Code</label>
                        <p class="text-sm font-mono text-gray-800 dark:text-white bg-gray-50 dark:bg-gray-700 p-1 rounded inline-block">
                            {{ $token->token ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Status & Compliance -->
                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Compliance Status</h4>

                    <!-- UJSIMP Status -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">UJSIMP Status</span>
                            @if($ujsimp)
                                @if($ujsimp->status === 'lulus')
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">LULUS</span>
                                @elseif($ujsimp->status === 'belum_lulus')
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-800">BELUM LULUS</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-800">{{ strtoupper($ujsimp->status) }}</span>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">Not Found</span>
                            @endif
                        </div>
                        
                        @if($ujsimp && $ujsimp->status === 'belum_lulus')
                            <div class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                <strong>Pending</strong><br>
                                Cooldown: 3 days until re-test allowed.
                            </div>
                        @endif
                    </div>

                    <!-- Checkup Status -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Checkup Status</span>
                            @if($checkup)
                                @if($checkup->rekomendasi === 'layak')
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">LAYAK</span>
                                @elseif($checkup->rekomendasi === 'tidak_layak')
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-800">TIDAK LAYAK</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-800">{{ strtoupper($checkup->rekomendasi) }}</span>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">Not Found</span>
                            @endif
                        </div>

                        @if($checkup && $checkup->rekomendasi === 'tidak_layak')
                            <div class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                <strong>Pending</strong><br>
                                Cooldown: 3 days until re-check allowed.
                            </div>
                        @endif
                    </div>

                </div>

            </div>

            <!-- Actions Footer -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700 flex justify-end space-x-3">
                <a href="{{ route('super-admin.users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit User
                </a>
                
                @if($user->id !== auth()->id())
                <form action="{{ route('super-admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Delete User
                    </button>
                </form>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
