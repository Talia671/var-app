@extends('layouts.admin')

@section('content')

<!-- TOP NAVIGATION -->
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.simper.index') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>

    <a href="{{ route('admin.simper.preview', $assessment->id) }}" target="_blank"
       class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Print PDF
    </a>
</div>

<!-- DOCUMENT PREVIEW (MIMIC PDF) -->
<div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 mb-8 max-w-4xl mx-auto">
    <div class="p-8 md:p-12">
        
        <!-- HEADER LOGOS -->
        <div class="flex justify-between items-center mb-8 border-b-2 border-gray-800 pb-4">
            <div class="w-1/3">
                <img src="{{ asset('assets/images/logo-pkt.svg') }}" alt="Logo PKT" class="h-16">
            </div>
            <div class="w-1/3 flex justify-center">
                <!-- Assuming logo-satpam exists, otherwise placeholder -->
                <div class="text-center font-bold text-gray-800 dark:text-white">SATUAN PENGAMANAN</div>
            </div>
            <div class="w-1/3 flex flex-col items-end">
                <img src="{{ asset('assets/images/logo-k3.svg') }}" alt="Logo K3" class="h-16 mb-1">
                <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-1 border border-gray-400">TES PRAKTEK</span>
            </div>
        </div>

        <!-- TITLE -->
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white uppercase decoration-2 underline underline-offset-4">HASIL UJIAN PRAKTEK SIMPER / SIOPER</h1>
        </div>

        <!-- FORM DATA -->
        <div class="grid grid-cols-1 gap-y-4 text-sm text-gray-800 dark:text-gray-200 mb-8">
            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">LOKASI KERJA (ZONASI)</div>
                <div class="col-span-2 flex items-center gap-8">
                    <label class="flex items-center space-x-2">
                        <span class="w-4 h-4 border border-gray-400 flex items-center justify-center">
                            {{ str_contains($assessment->zona, '1') ? '✓' : '' }}
                        </span>
                        <span>ZONA 1</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <span class="w-4 h-4 border border-gray-400 flex items-center justify-center">
                            {{ str_contains($assessment->zona, '2') ? '✓' : '' }}
                        </span>
                        <span>ZONA 2</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">NAMA</div>
                <div class="col-span-2 uppercase">: {{ $assessment->nama }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">NPK / NOMOR BADGE</div>
                <div class="col-span-2 uppercase">: {{ $assessment->npk }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">PERUSAHAAN / DEPT</div>
                <div class="col-span-2 uppercase">: {{ $assessment->perusahaan }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">JENIS KENDARAAN / ALBET</div>
                <div class="col-span-2 uppercase">: {{ $assessment->jenis_kendaraan }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">NOMOR SIM / SIO</div>
                <div class="col-span-2 uppercase">: {{ $assessment->nomor_sim }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">JENIS SIM / SIO</div>
                <div class="col-span-2 uppercase">: {{ $assessment->jenis_sim }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">JENIS SIMPER / SIOPER</div>
                <div class="col-span-2 uppercase">: {{ $assessment->jenis_simper }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                <div class="font-bold">TANGGAL DIUJI</div>
                <div class="col-span-2 uppercase">: {{ $assessment->tanggal_uji ? \Carbon\Carbon::parse($assessment->tanggal_uji)->format('d F Y') : '-' }}</div>
            </div>
        </div>

        <!-- NOTES SECTION -->
        <div class="mb-8">
            <div class="bg-gray-100 dark:bg-gray-700 text-center font-bold py-2 mb-4 text-sm uppercase text-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-600">
                YANG PERLU DILATIH ATAU DIPERBAIKI
            </div>
            
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600 text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="border border-gray-300 dark:border-gray-600 p-2 w-12 text-center text-gray-800 dark:text-gray-200">NO</th>
                        <th class="border border-gray-300 dark:border-gray-600 p-2 text-left text-gray-800 dark:text-gray-200">URAIAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assessment->notes as $i => $note)
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2 text-center text-gray-700 dark:text-gray-300">{{ $i+1 }}</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2 text-gray-700 dark:text-gray-300">{{ $note->description }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2 text-center text-gray-700 dark:text-gray-300">-</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2 text-gray-700 dark:text-gray-300 italic text-center">Tidak ada catatan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- SIGNATURE SECTION (MODIFIED) -->
        <div class="grid grid-cols-2 gap-8 mt-12 text-center">
            <!-- Penguji -->
            <div>
                <div class="font-bold text-gray-800 dark:text-gray-200 mb-16">PENGUJI</div>
                <div class="text-sm">
                    <div class="font-bold text-gray-900 dark:text-white uppercase underline">{{ $assessment->penguji_nama ?? '(.......................)' }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-1">NPK: {{ $assessment->penguji_npk ?? '..........' }}</div>
                </div>
            </div>

            <!-- User -->
            <div>
                <div class="font-bold text-gray-800 dark:text-gray-200 mb-16">USER / PEMOHON</div>
                <div class="text-sm">
                    <div class="font-bold text-gray-900 dark:text-white uppercase underline">{{ $assessment->nama }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-1">Badge No: {{ $assessment->npk }}</div>
                </div>
            </div>
        </div>

        <!-- FOOTER INFO -->
        <div class="mt-12 text-right text-xs text-gray-500">
            No. Dokumen: SIMPER/PKT/{{ date('Y') }}/{{ str_pad($assessment->id,4,'0',STR_PAD_LEFT) }}
        </div>
    </div>
</div>

<!-- ACTION BUTTONS -->
@if($assessment->status == 'pending')
<div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
    <!-- APPROVE FORM -->
    <form action="{{ route('admin.simper.approve', $assessment->id) }}" method="POST" class="w-full">
        @csrf
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <h4 class="text-lg font-bold text-green-700 dark:text-green-400 mb-2">Setujui Pengajuan</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pastikan data sudah benar sebelum menyetujui.</p>
            <button type="submit" class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow transition-transform transform hover:scale-[1.02]">
                ✓ Approve Document
            </button>
        </div>
    </form>

    <!-- REJECT FORM -->
    <form action="{{ route('admin.simper.reject', $assessment->id) }}" method="POST" class="w-full">
        @csrf
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <h4 class="text-lg font-bold text-red-700 dark:text-red-400 mb-2">Tolak Pengajuan</h4>
            <input type="text" 
                   name="rejected_reason" 
                   placeholder="Masukkan alasan penolakan..."
                   required
                   class="w-full mb-4 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
            <button type="submit" class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition-transform transform hover:scale-[1.02]">
                ✕ Reject Document
            </button>
        </div>
    </form>
</div>
@endif

@endsection
