@extends('layouts.petugas')

@section('content')

<!-- PAGE HEADER -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data RANMOR</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola data pemeriksaan fisik kendaraan bermotor</p>
    </div>
    
    <!-- Action Button -->
    <div class="mt-4 md:mt-0">
        <a href="{{ route('petugas.ranmor.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2 bg-violet-600 text-white text-sm font-medium rounded-lg hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 shadow-md transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Dokumen Baru
        </a>
    </div>
</div>

{{-- Filter & Search --}}
<div class="bg-white dark:bg-night-card p-4 rounded-xl shadow mb-6 border border-gray-100 dark:border-night-border">
    <form action="{{ route('petugas.ranmor.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari No Pol / Pengemudi / NPK..." 
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-violet-500 focus:border-violet-500">
        </div>
        <div>
            <select name="zona" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-violet-500 focus:border-violet-500">
                <option value="">Semua Zona</option>
                <option value="zona1" {{ request('zona') == 'zona1' ? 'selected' : '' }}>Zona 1</option>
                <option value="zona2" {{ request('zona') == 'zona2' ? 'selected' : '' }}>Zona 2</option>
            </select>
        </div>
        <!-- Status Filter Removed as per instruction -->
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-900 dark:hover:bg-gray-500 transition shadow-sm">
                Filter
            </button>
            <a href="{{ route('petugas.ranmor.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm text-center hover:bg-gray-300 dark:hover:bg-gray-600 transition shadow-sm">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- MAIN CARD -->
<div class="bg-white dark:bg-night-card rounded-xl shadow-lg border border-gray-100 dark:border-night-border overflow-hidden">
    
    <!-- TABLE SECTION -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No Polisi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pengemudi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-night-card divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($documents as $doc)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ ($documents->currentPage()-1) * $documents->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            {{ $doc->no_pol }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $doc->pengemudi }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $doc->tanggal_periksa ? $doc->tanggal_periksa->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 flex items-center">
                        <a href="{{ route('petugas.ranmor.show', $doc->id) }}"
                           class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors shadow-sm">
                            Detail
                        </a>

                        @if($doc->workflow_status == 'draft' || $doc->workflow_status == 'rejected')
                            <a href="{{ route('petugas.ranmor.edit', $doc->id) }}"
                               class="text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-2 dark:focus:ring-yellow-900 transition-colors shadow-sm">
                                Edit
                            </a>
                        @endif

                        @if($doc->workflow_status == 'draft')
                        <form method="POST" action="{{ route('petugas.ranmor.submit', $doc->id) }}" class="inline-block">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Apakah Anda yakin ingin mengirim data ini?')"
                                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 transition-colors shadow-sm">
                                Submit
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-base font-medium">Tidak ada data RANMOR</span>
                            <span class="text-sm mt-1">Silakan buat dokumen baru</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- PAGINATION -->
    @if($documents->hasPages())
    <div class="bg-white dark:bg-night-card px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
        {{ $documents->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection