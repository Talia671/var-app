@extends('layouts.admin')

@section('content')
<div class="py-6" x-data="tokenManager()">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Token Management</h2>
                <p class="text-gray-500 text-sm">Secure enterprise-grade token system</p>
            </div>
            <button @click="openGenerateModal()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition transform hover:scale-105">
                Generate New Token
            </button>
        </div>

        <!-- Active Token List -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Active Token List</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Token Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Used By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($tokens as $token)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-sm font-bold text-gray-800 dark:text-white">
                                <span x-ref="token_{{ $token->id }}">******</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $token->creator->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php $effectiveStatus = $token->effective_status; @endphp
                                @if($effectiveStatus === 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @elseif($effectiveStatus === 'used')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Used
                                    </span>
                                @elseif($effectiveStatus === 'expired')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Expired
                                    </span>
                                @elseif($effectiveStatus === 'revoked')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Revoked
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($effectiveStatus) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($token->status === 'used')
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $token->user->name ?? 'Unknown' }}</span>
                                        <span class="text-xs text-gray-400">{{ $token->used_at ? $token->used_at->format('d M H:i') : '' }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $token->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if(auth()->user()->role === 'super_admin')
                                    <button @click="openRevealModal({{ $token->id }})" 
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold">
                                        Reveal
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $tokens->links() }}
            </div>
        </div>
    </div>

    <!-- GENERATE TOKEN MODAL -->
    <div x-show="showGenerateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showGenerateModal = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75 backdrop-blur-sm"></div>
            </div>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full zoom-in">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Secure Token Generated
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    This token will expire in 24 hours. Copy it now.
                                </p>

                                <!-- Token Display Area -->
                                <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-900 rounded-lg text-center border border-gray-200 dark:border-gray-700 min-h-[80px] flex flex-col justify-center items-center">
                                    <template x-if="!generatedToken">
                                        <span class="text-gray-400 italic">Generating...</span>
                                    </template>
                                    <template x-if="generatedToken">
                                        <div>
                                            <p class="text-2xl font-mono font-bold text-blue-600 dark:text-blue-400 tracking-wider select-all" x-text="generatedToken"></p>
                                            <button @click="copyToClipboard(generatedToken)" class="text-xs text-blue-600 mt-2 font-semibold hover:underline">
                                                Copy to Clipboard
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="closeGenerateModal()"
                            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- REVEAL TOKEN MODAL -->
    <div x-show="showRevealModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showRevealModal = false">
                <div class="absolute inset-0 bg-gray-900 opacity-80 backdrop-blur-sm"></div>
            </div>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full zoom-in">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Security Check
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Please enter your password to reveal this token. This action will be logged.
                                </p>
                                
                                <input type="password" x-model="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       placeholder="Enter your password"
                                       @keydown.enter="revealToken()">
                                
                                <p x-show="revealError" class="text-red-500 text-xs mt-2" x-text="revealError"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="revealToken()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirm & Reveal
                    </button>
                    <button type="button" 
                            @click="showRevealModal = false; password = '';"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function tokenManager() {
        return {
            showGenerateModal: false,
            showRevealModal: false,
            generatedToken: '',
            password: '',
            revealTokenId: null,
            revealError: '',

            openGenerateModal() {
                this.showGenerateModal = true;
                this.generatedToken = '';
                this.fetchNewToken();
            },

            closeGenerateModal() {
                this.showGenerateModal = false;
                setTimeout(() => location.reload(), 500);
            },

            fetchNewToken() {
                fetch('{{ route("super-admin.tokens.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.generatedToken = data.token;
                    }
                })
                .catch(error => console.error('Error:', error));
            },

            openRevealModal(id) {
                this.revealTokenId = id;
                this.password = '';
                this.revealError = '';
                this.showRevealModal = true;
            },

            revealToken() {
                if (!this.password) {
                    this.revealError = 'Password is required';
                    return;
                }

                // Construct URL with token ID
                let url = '{{ route("super-admin.tokens.reveal", ":id") }}';
                url = url.replace(':id', this.revealTokenId);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        password: this.password
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showRevealModal = false;
                        this.password = '';
                        this.showTempToken(this.revealTokenId, data.token);
                    } else {
                        this.revealError = data.message || 'Verification failed';
                    }
                })
                .catch(error => {
                    this.revealError = 'An error occurred';
                    console.error(error);
                });
            },

            showTempToken(id, token) {
                // Find the element
                let el = this.$refs['token_' + id];
                if (el) {
                    let originalText = el.innerText;
                    el.innerText = token;
                    el.classList.add('text-red-600', 'font-bold');

                    // Revert after 10 seconds
                    setTimeout(() => {
                        el.innerText = originalText;
                        el.classList.remove('text-red-600', 'font-bold');
                    }, 10000);
                }
            },

            copyToClipboard(text) {
                navigator.clipboard.writeText(text);
                alert('Token copied to clipboard!');
            }
        }
    }
</script>

<style>
    .zoom-in {
        animation: zoomIn 0.2s ease-out;
    }
    @keyframes zoomIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endsection
