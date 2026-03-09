@extends('layouts.admin')

@section('content')

<!-- TOP NAVIGATION -->
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.ujsimp.index') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>

    @if($test->isApproved())
    <a href="{{ route('admin.ujsimp.preview', $test->id) }}" target="_blank"
       class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Print PDF
    </a>
    @endif
</div>

@if($test->workflow_status === 'submitted')
<div class="flex justify-end gap-3 mb-6">
    <form action="{{ route('admin.ujsimp.verify', $test->id) }}" method="POST">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-secondary hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">
            Verify
        </button>
    </form>

    <form action="{{ route('admin.ujsimp.reject', $test->id) }}" method="POST">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">
            Reject
        </button>
    </form>
</div>
@elseif($test->workflow_status === 'verified')
<div class="flex justify-end mb-6">
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
        Verified
    </span>
</div>
@elseif($test->workflow_status === 'rejected')
<div class="flex justify-end mb-6">
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200">
        Rejected
    </span>
</div>
@endif

<!-- DOCUMENT PREVIEW -->
<div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 mb-8 max-w-5xl mx-auto">
    <div class="p-8 md:p-12">
        
        <!-- HEADER LOGOS -->
        <div class="flex justify-between items-center mb-8 border-b-2 border-gray-800 pb-4">
            <div class="w-1/3">
                <img src="{{ asset('assets/images/logo-pkt.svg') }}" alt="Logo PKT" class="h-16">
            </div>
            <div class="w-1/3 flex justify-center">
                <img src="{{ asset('assets/images/logo-satpam.svg') }}" alt="Logo Satpam" class="h-16">
            </div>
            <div class="w-1/3 flex justify-end">
                <img src="{{ asset('assets/images/logo-k3.svg') }}" alt="Logo K3" class="h-16">
            </div>
        </div>

        <!-- TITLE -->
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white uppercase decoration-2 underline underline-offset-4">UJIAN PRAKTEK SURAT IZIN MENGEMUDI PERUSAHAAN</h1>
        </div>

        <!-- IDENTITY -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm text-gray-800 dark:text-gray-200 mb-8">
            <div class="space-y-2">
                <div class="grid grid-cols-3">
                    <div class="font-bold">NAMA</div>
                    <div class="col-span-2 uppercase">: {{ $test->nama }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">NPK / BADGE</div>
                    <div class="col-span-2 uppercase">: {{ $test->npk }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">PERUSAHAAN</div>
                    <div class="col-span-2 uppercase">: {{ $test->perusahaan }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">JENIS KENDARAAN</div>
                    <div class="col-span-2 uppercase">: {{ $test->jenis_kendaraan }}</div>
                </div>
            </div>
            <div class="space-y-2">
                <div class="grid grid-cols-3">
                    <div class="font-bold">TANGGAL UJIAN</div>
                    <div class="col-span-2 uppercase">: {{ $test->tanggal_ujian ? \Carbon\Carbon::parse($test->tanggal_ujian)->format('d F Y') : '-' }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">NOMOR SIM</div>
                    <div class="col-span-2 uppercase">: {{ $test->nomor_sim }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">JENIS SIM</div>
                    <div class="col-span-2 uppercase">: {{ $test->jenis_sim }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">JENIS SIMPER</div>
                    <div class="col-span-2 uppercase">: {{ $test->jenis_simper }}</div>
                </div>
            </div>
        </div>

        <!-- SCORES TABLE -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full border-collapse border border-gray-400 dark:border-gray-600 text-sm">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <th rowspan="2" class="border border-gray-400 dark:border-gray-600 p-2 w-10">NO</th>
                        <th rowspan="2" class="border border-gray-400 dark:border-gray-600 p-2 text-left">URAIAN UJI KETRAMPILAN</th>
                        <th colspan="5" class="border border-gray-400 dark:border-gray-600 p-2 text-center">NILAI</th>
                    </tr>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-xs">
                        <th class="border border-gray-400 dark:border-gray-600 p-1 w-8 text-center">B</th>
                        <th class="border border-gray-400 dark:border-gray-600 p-1 w-8 text-center">S</th>
                        <th class="border border-gray-400 dark:border-gray-600 p-1 w-8 text-center">K</th>
                        <th class="border border-gray-400 dark:border-gray-600 p-1 w-12 text-center">HURUF</th>
                        <th class="border border-gray-400 dark:border-gray-600 p-1 w-12 text-center">ANGKA</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                    @php
                        $scoresMap = $test->scores->keyBy('ujsimp_item_id');
                        $romans = ['I', 'II', 'III', 'IV'];
                    @endphp

                    @foreach($itemsConfig as $catIdx => $category)
                        <tr class="bg-gray-50 dark:bg-gray-800 font-bold">
                            <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $romans[$catIdx] ?? ($catIdx + 1) }}</td>
                            <td colspan="6" class="border border-gray-400 dark:border-gray-600 p-2 uppercase">
                                {{ str_replace('_', ' ', $category['kategori']) }}
                            </td>
                        </tr>
                        @foreach($category['data'] as $itemId => $itemDesc)
                            @php
                                $score = $scoresMap[$itemId] ?? null;
                            @endphp
                            <tr>
                                <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-gray-400 dark:border-gray-600 p-2">{{ $itemDesc }}</td>
                                <td class="border border-gray-400 dark:border-gray-600 p-1 text-center font-bold">
                                    {{ ($score && $score->nilai_huruf == 'B') ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-400 dark:border-gray-600 p-1 text-center font-bold">
                                    {{ ($score && $score->nilai_huruf == 'S') ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-400 dark:border-gray-600 p-1 text-center font-bold">
                                    {{ ($score && $score->nilai_huruf == 'K') ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-400 dark:border-gray-600 p-1 text-center font-bold">
                                    {{ $score->nilai_huruf ?? '-' }}
                                </td>
                                <td class="border border-gray-400 dark:border-gray-600 p-1 text-center font-bold">
                                    {{ $score->nilai_angka ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    <!-- TOTAL & AVERAGE -->
                    <tr class="font-bold bg-gray-50 dark:bg-gray-800">
                        <td colspan="6" class="border border-gray-400 dark:border-gray-600 p-2 text-right">JUMLAH NILAI</td>
                        <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $test->nilai_total }}</td>
                    </tr>
                    <tr class="font-bold bg-gray-50 dark:bg-gray-800">
                        <td colspan="6" class="border border-gray-400 dark:border-gray-600 p-2 text-right">RATA-RATA</td>
                        <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ number_format($test->nilai_rata_rata, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- RESULT -->
        <div class="flex justify-end mb-8">
            <div class="border-2 border-gray-800 dark:border-gray-200 p-4 rounded-lg inline-block text-center">
                <div class="text-sm font-bold uppercase mb-2">KESIMPULAN</div>
                <div class="text-2xl font-black {{ $test->status == 'lulus' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $test->status == 'lulus' ? 'LULUS' : 'TIDAK LULUS' }}
                </div>
            </div>
        </div>

        <!-- SIGNATURES -->
        <div class="grid grid-cols-2 gap-8 mt-12 text-center">
            <!-- Penguji -->
            <div>
                <div class="font-bold text-gray-800 dark:text-gray-200 mb-16">PENGUJI</div>
                <div class="text-sm">
                    <!-- Assuming approved_by is the tester/admin -->
                    <div class="font-bold text-gray-900 dark:text-white uppercase underline">
                         {{ $test->approver->name ?? '(.......................)' }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 mt-1">NPK: {{ $test->approver->npk ?? '..........' }}</div>
                </div>
            </div>

            <!-- User -->
            <div>
                <div class="font-bold text-gray-800 dark:text-gray-200 mb-16">PESERTA UJI</div>
                <div class="text-sm">
                    <div class="font-bold text-gray-900 dark:text-white uppercase underline">{{ $test->nama }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-1">Badge No: {{ $test->npk }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
