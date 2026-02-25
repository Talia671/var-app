@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Approval RANMOR</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Daftar pemeriksaan kendaraan bermotor</p>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white dark:bg-night-card p-4 rounded-xl shadow border border-gray-100 dark:border-night-border mb-6">
        <form action="{{ route('admin.ranmor.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari No Pol / Pengemudi / NPK..." 
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-secondary focus:border-secondary">
            </div>
            <div>
                <select name="zona" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-secondary focus:border-secondary">
                    <option value="">Semua Zona</option>
                    <option value="zona1" {{ request('zona') == 'zona1' ? 'selected' : '' }}>Zona 1</option>
                    <option value="zona2" {{ request('zona') == 'zona2' ? 'selected' : '' }}>Zona 2</option>
                </select>
            </div>
            <div>
                <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-secondary focus:border-secondary">
                    <option value="">Semua Status</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 dark:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-900 dark:hover:bg-gray-500 transition">
                    Filter
                </button>
                <a href="{{ route('admin.ranmor.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 px-4 py-2 rounded-lg text-sm text-center hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-night-card rounded-xl shadow-lg border border-gray-100 dark:border-night-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. Polisi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. Lambung</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Kendaraan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Pemeriksaan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-night-card divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($documents as $doc)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ ($documents->currentPage()-1) * $documents->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                            {{ $doc->no_pol }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                            {{ $doc->no_lambung ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                            {{ $doc->perusahaan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                            {{ $doc->jenis_kendaraan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                            {{ $doc->tanggal_periksa ? $doc->tanggal_periksa->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($doc->workflow_status == 'submitted')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">Submitted</span>
                            @elseif($doc->workflow_status == 'approved')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">Approved</span>
                            @elseif($doc->workflow_status == 'rejected')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">Rejected</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">{{ ucfirst($doc->workflow_status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('admin.ranmor.show',$doc->id) }}"
                               class="text-white bg-violet-600 hover:bg-violet-700 focus:ring-4 focus:ring-violet-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-violet-500 dark:hover:bg-violet-600 focus:outline-none dark:focus:ring-violet-800 transition-colors shadow-sm hover:shadow-md">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="text-base font-medium">Tidak ada data ranmor</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $documents->links() }}
    </div>
</div>

@endsection
