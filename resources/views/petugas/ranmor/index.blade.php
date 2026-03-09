@extends('layouts.petugas')

@section('content')

<div class="container-page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Data RANMOR</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola data pemeriksaan fisik kendaraan bermotor</p>
        </div>
        
        <div class="mt-4 md:mt-0">
            <a href="{{ route('petugas.ranmor.create') }}" class="btn-ui btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Dokumen Baru
            </a>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="card-ui mb-6">
        <form action="{{ route('petugas.ranmor.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari No Pol / Pengemudi / NPK..." 
                       class="form-control">
            </div>
            <div>
                <select name="zona" class="form-control">
                    <option value="">Semua Zona</option>
                    <option value="zona1" {{ request('zona') == 'zona1' ? 'selected' : '' }}>Zona 1</option>
                    <option value="zona2" {{ request('zona') == 'zona2' ? 'selected' : '' }}>Zona 2</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-ui btn-secondary flex-1">
                    Filter
                </button>
                <a href="{{ route('petugas.ranmor.index') }}" class="btn-ui btn-outline flex-1 text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- MAIN CARD -->
    <div class="card-ui overflow-hidden">
        
        <!-- TABLE SECTION -->
        <div class="overflow-x-auto">
            <table class="table-ui">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Polisi</th>
                        <th>Pengemudi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td>
                            {{ ($documents->currentPage()-1) * $documents->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <span class="badge-secondary">
                                {{ $doc->no_pol }}
                            </span>
                        </td>
                        <td class="font-medium text-gray-900 dark:text-white">
                            {{ $doc->pengemudi }}
                        </td>
                        <td>
                            {{ $doc->tanggal_periksa ? $doc->tanggal_periksa->format('d M Y') : '-' }}
                        </td>
                        <td>
                            @if($doc->workflow_status == 'draft')
                                <span class="badge-secondary">Draft</span>
                            @elseif($doc->workflow_status == 'submitted')
                                <span class="badge-warning">Submitted</span>
                            @elseif($doc->workflow_status == 'approved')
                                <span class="badge-success">Approved</span>
                            @elseif($doc->workflow_status == 'rejected')
                                <span class="badge-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('petugas.ranmor.show', $doc->id) }}" class="btn-ui btn-primary text-xs px-3 py-2">
                                    Detail
                                </a>

                                @if($doc->workflow_status == 'draft' || $doc->workflow_status == 'rejected')
                                    <a href="{{ route('petugas.ranmor.edit', $doc->id) }}" class="btn-ui btn-warning text-xs px-3 py-2">
                                        Edit
                                    </a>
                                @endif

                                @if($doc->workflow_status == 'draft')
                                <form method="POST" action="{{ route('petugas.ranmor.submit', $doc->id) }}" class="inline-block">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin mengirim data ini?')"
                                            class="btn-ui btn-success text-xs px-3 py-2">
                                        Submit
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10">
                            <div class="flex flex-col items-center justify-center text-gray-500">
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
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $documents->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

@endsection