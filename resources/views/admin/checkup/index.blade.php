@extends('layouts.admin')

@section('content')

<div class="container-page">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h2 class="page-title">Verifikasi Checklist (Checkup)</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Daftar dokumen submitted untuk diverifikasi</p>
        </div>
    </div>

    <div class="card-ui mb-6">
        <form action="{{ route('admin.checkup.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari Nama Checker / Nama User / NPK / Jenis Kendaraan..."
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-secondary focus:border-secondary">
            </div>
            <div>
                <select name="sort" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-secondary focus:border-secondary">
                    <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 btn-ui btn-primary">
                    Filter
                </button>
                <a href="{{ route('admin.checkup.index') }}" class="flex-1 btn-ui btn-secondary text-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card-ui overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table-ui">
                <thead>
                    <tr>
                        <th>Tanggal Created</th>
                        <th>Jam Created</th>
                        <th>Nama Checker</th>
                        <th>NPK Checker</th>
                        <th>Nama User</th>
                        <th>Jenis Kendaraan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td>
                            {{ optional($doc->created_at)->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ optional($doc->created_at)->format('H:i') }}
                        </td>
                        <td class="font-medium">
                            {{ $doc->creator?->name ?? '-' }}
                        </td>
                        <td>
                            {{ $doc->creator?->npk ?? '-' }}
                        </td>
                        <td class="font-semibold">
                            {{ $doc->nama_pengemudi ?? '-' }}
                        </td>
                        <td>
                            {{ $doc->jenis_kendaraan ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.checkup.show', $doc->id) }}"
                               class="btn-ui btn-primary text-xs py-2">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-base font-medium">Tidak ada dokumen untuk diverifikasi</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
        <div class="bg-white dark:bg-night-card px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $documents->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
