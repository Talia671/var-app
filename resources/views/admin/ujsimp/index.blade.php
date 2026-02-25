@extends('layouts.admin')

@section('content')

<!-- PAGE HEADER -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Approval UJSIMP</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Daftar hasil ujian praktek SIM Perusahaan</p>
    </div>
    
    <!-- No filter mentioned for UJSIMP but good to keep consistency if needed. 
         The controller might not support filtering by status in the index method yet?
         Let's check routes/controller if needed. 
         PetugasUjsimpController has index. AdminUjsimpApprovalController?
         Routes say: Route::get('/', [PetugasUjsimpController::class,'index'])->name('index'); for petugas.
         For admin: Route::resource('ujsimp', AdminUjsimpApprovalController::class); likely.
         I'll assume no filter for now unless I see it in the previous file.
         The previous file had NO filter form. So I'll stick to that.
    -->
</div>

<!-- MAIN CARD -->
<div class="bg-white dark:bg-night-card rounded-xl shadow-lg border border-gray-100 dark:border-night-border overflow-hidden">
    
    <!-- TABLE SECTION -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NPK</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Uji</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-night-card divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($tests as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $loop->iteration + ($tests->currentPage() - 1) * $tests->perPage() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->nama ?? '-' }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->perusahaan ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            {{ $item->npk }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $item->workflow_status == 'approved' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 
                               ($item->workflow_status == 'rejected' ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' : 
                               'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300') }}">
                            @if($item->workflow_status == 'submitted')
                                ⏳ Submitted
                            @elseif($item->workflow_status == 'approved')
                                ✓ Approved
                            @elseif($item->workflow_status == 'rejected')
                                ✕ Rejected
                            @else
                                {{ strtoupper($item->workflow_status) }}
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $item->tanggal_ujian ? \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.ujsimp.show', $item->id) }}"
                           class="text-white bg-primary hover:bg-orange-600 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-orange-500 dark:hover:bg-orange-600 focus:outline-none dark:focus:ring-orange-800 transition-colors shadow-sm hover:shadow-md">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <span class="text-base font-medium">Tidak ada data pengajuan</span>
                            <span class="text-sm mt-1">Belum ada pengajuan UJSIMP</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- PAGINATION -->
    @if($tests->hasPages())
    <div class="bg-white dark:bg-night-card px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
        {{ $tests->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection
