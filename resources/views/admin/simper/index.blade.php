@extends('layouts.admin')

@section('content')

<!-- PAGE HEADER -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Approval SIMPER</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Daftar pengajuan berdasarkan status</p>
    </div>
    
    <!-- Filter Status -->
    <div class="mt-4 md:mt-0">
        <form method="GET" action="{{ route('admin.simper.index') }}">
            <select name="status"
                    onchange="this.form.submit()"
                    class="form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white cursor-pointer shadow-sm">
                <option value="all" {{ $currentStatus == 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="approved" {{ $currentStatus == 'approved' ? 'selected' : '' }}>✓ Approved</option>
                <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>✕ Rejected</option>
            </select>
        </form>
    </div>
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
                @forelse($assessments as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $loop->iteration + ($assessments->currentPage() - 1) * $assessments->perPage() }}
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
                        @if($item->status == 'pending')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                ⏳ Pending
                            </span>
                        @elseif($item->status == 'approved')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                ✓ Approved
                            </span>
                        @elseif($item->status == 'rejected')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                ✕ Rejected
                            </span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                {{ ucfirst($item->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $item->tanggal_uji ? \Carbon\Carbon::parse($item->tanggal_uji)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.simper.show', $item->id) }}" 
                           class="text-white bg-secondary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors shadow-sm hover:shadow-md">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-base font-medium">Tidak ada data pengajuan</span>
                            <span class="text-sm mt-1">Belum ada pengajuan dengan status ini</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($assessments->hasPages())
    <div class="bg-white dark:bg-night-card px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
        {{ $assessments->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection
