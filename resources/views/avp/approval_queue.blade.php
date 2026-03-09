@extends('layouts.admin')

@section('title', 'AVP Approval Queue')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Approval Queue</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Dokumen yang telah diverifikasi dan menunggu persetujuan</p>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 mb-6 border border-gray-100 dark:border-gray-700">
            <form method="GET" action="{{ route('avp.approval-queue') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <!-- SEARCH -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, Verifikator..." 
                           class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-primary focus:border-primary">
                </div>

                <!-- MODULE FILTER -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Modul</label>
                    <select name="module" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-primary focus:border-primary">
                        <option value="all">Semua Modul</option>
                        <option value="simper" {{ request('module') == 'simper' ? 'selected' : '' }}>SIMPER</option>
                        <option value="ujsimp" {{ request('module') == 'ujsimp' ? 'selected' : '' }}>UJSIMP</option>
                        <option value="checkup" {{ request('module') == 'checkup' ? 'selected' : '' }}>Checklist</option>
                        <option value="ranmor" {{ request('module') == 'ranmor' ? 'selected' : '' }}>Ranmor</option>
                    </select>
                </div>

                <!-- TIME RANGE -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Waktu Verifikasi</label>
                    <select name="range" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-primary focus:border-primary">
                        <option value="">Semua Waktu</option>
                        <option value="today" {{ request('range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ request('range') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ request('range') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    </select>
                </div>

                <!-- SORT & SUBMIT -->
                <div class="flex gap-2 items-end">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Urutan</label>
                        <select name="sort" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-primary focus:border-primary">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-2.5 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Verifikasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Verifikator</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User / Pengemudi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Form</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($documents as $doc)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                {{ $doc->verified_at ? \Carbon\Carbon::parse($doc->verified_at)->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $doc->verifier_name ?? '-' }}</div>
                                <div class="text-xs text-gray-400">Verified by Admin</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $doc->user_name }}</div>
                                <div class="text-xs text-gray-400">Checker: {{ $doc->checker_name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $doc->module_type === 'SIMPER' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                    {{ $doc->module_type === 'UJSIMP' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300' : '' }}
                                    {{ $doc->module_type === 'CHECKUP' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                    {{ $doc->module_type === 'RANMOR' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300' : '' }}
                                ">
                                    {{ strtoupper($doc->module_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <x-workflow-badge :status="$doc->workflow_status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    @php
                                        $routePrefix = match(strtoupper($doc->module_type)) {
                                            'SIMPER' => 'avp.simper.show',
                                            'UJSIMP' => 'avp.ujsimp.show',
                                            'CHECKUP' => 'avp.checkup.show',
                                            'RANMOR' => 'avp.ranmor.show',
                                            default => null
                                        };
                                        
                                        $approveRoute = match(strtoupper($doc->module_type)) {
                                            'SIMPER' => 'avp.simper.approve',
                                            'UJSIMP' => 'avp.ujsimp.approve',
                                            'CHECKUP' => 'avp.checkup.approve',
                                            'RANMOR' => 'avp.ranmor.approve',
                                            default => null
                                        };

                                        $rejectRoute = match(strtoupper($doc->module_type)) {
                                            'SIMPER' => 'avp.simper.reject',
                                            'UJSIMP' => 'avp.ujsimp.reject',
                                            'CHECKUP' => 'avp.checkup.reject',
                                            'RANMOR' => 'avp.ranmor.reject',
                                            default => null
                                        };
                                    @endphp

                                    @if($routePrefix)
                                        <a href="{{ route($routePrefix, $doc->document_id) }}" 
                                           class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm text-xs font-bold uppercase">
                                            Detail
                                        </a>

                                        @if($doc->workflow_status === 'verified')
                                            <form method="POST" action="{{ route($approveRoute, $doc->document_id) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        onclick="return confirm('Apakah anda yakin ingin menyetujui dokumen ini?')"
                                                        class="px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm text-xs font-bold uppercase">
                                                    Approve
                                                </button>
                                            </form>
                                            
                                            <!-- Reject must be done via Detail page to provide reason -->
                                        @else
                                            <span class="text-xs text-gray-400 font-medium italic">Document Finalized</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 italic text-xs">Detail belum tersedia</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <p class="mt-2 text-sm font-medium">Tidak ada dokumen menunggu persetujuan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($documents->hasPages())
            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $documents->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
