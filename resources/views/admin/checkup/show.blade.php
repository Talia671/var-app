@extends('layouts.admin')

@section('content')

<!-- TOP NAVIGATION -->
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('admin.checkup.index') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>

    @if($document->workflow_status == 'approved')
    <a href="{{ route('admin.checkup.preview', $document->id) }}" target="_blank"
       class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Print PDF
    </a>
    @endif
</div>

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
            <h1 class="text-xl font-bold text-gray-900 dark:text-white uppercase decoration-2 underline underline-offset-4">CHECK LIST / PEMERIKSAAN KENDARAAN PERUSAHAAN</h1>
        </div>

        <!-- IDENTITY -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm text-gray-800 dark:text-gray-200 mb-8">
            <div class="space-y-2">
                <div class="grid grid-cols-3">
                    <div class="font-bold">NO. POL KENDARAAN</div>
                    <div class="col-span-2 uppercase">: {{ $document->no_pol }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">NO. LAMBUNG</div>
                    <div class="col-span-2 uppercase">: {{ $document->no_lambung }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">PERUSAHAAN</div>
                    <div class="col-span-2 uppercase">: {{ $document->perusahaan }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">JENIS KENDARAAN</div>
                    <div class="col-span-2 uppercase">: {{ $document->jenis_kendaraan }}</div>
                </div>
            </div>
            <div class="space-y-2">
                <div class="grid grid-cols-3">
                    <div class="font-bold">PENGEMUDI</div>
                    <div class="col-span-2 uppercase">: {{ $document->nama_pengemudi }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">NOMOR SIM</div>
                    <div class="col-span-2 uppercase">: {{ $document->nomor_sim }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">NOMOR SIMPER</div>
                    <div class="col-span-2 uppercase">: {{ $document->nomor_simper }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-bold">MASA BERLAKU</div>
                    <div class="col-span-2 uppercase">: {{ $document->masa_berlaku }}</div>
                </div>
            </div>
        </div>

        <!-- MAIN TABLE -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full border-collapse border border-gray-400 dark:border-gray-600 text-sm">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <th rowspan="2" class="border border-gray-400 dark:border-gray-600 p-2 w-10 text-center">NO</th>
                        <th rowspan="2" class="border border-gray-400 dark:border-gray-600 p-2 text-left">OBYEK / ITEM PEMERIKSAAN</th>
                        <th rowspan="2" class="border border-gray-400 dark:border-gray-600 p-2 text-center w-24">STANDAR</th>
                        <th colspan="2" class="border border-gray-400 dark:border-gray-600 p-2 text-center">HASIL</th>
                        <th rowspan="2" class="border border-gray-400 dark:border-gray-600 p-2 text-left w-1/3">TINDAKAN PERBAIKAN</th>
                    </tr>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-xs">
                        <th class="border border-gray-400 dark:border-gray-600 p-1 w-16 text-center">BAIK</th>
                        <th class="border border-gray-400 dark:border-gray-600 p-1 w-16 text-center">TDK BAIK</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                    @foreach($document->results as $result)
                    <tr>
                        <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border border-gray-400 dark:border-gray-600 p-2">{{ $result->item->uraian ?? 'Item #'.$result->checkup_item_id }}</td>
                        <td class="border border-gray-400 dark:border-gray-600 p-2 text-center"></td>
                        <td class="border border-gray-400 dark:border-gray-600 p-2 text-center font-bold">
                            {{ $result->hasil == 'Baik' ? '✓' : '' }}
                        </td>
                        <td class="border border-gray-400 dark:border-gray-600 p-2 text-center font-bold">
                            {{ $result->hasil != 'Baik' ? '✓' : '' }}
                        </td>
                        <td class="border border-gray-400 dark:border-gray-600 p-2">{{ $result->tindakan_perbaikan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- RECOMMENDATION & ZONE -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border border-gray-400 dark:border-gray-600 mb-8">
            <div class="p-4 border-r border-gray-400 dark:border-gray-600">
                <div class="font-bold mb-4">REKOMENDASI</div>
                <div class="flex items-center mb-2">
                    <span class="w-4 h-4 border border-gray-800 dark:border-gray-200 mr-2 flex items-center justify-center text-xs">
                        {{ $document->rekomendasi == 'layak' ? '✓' : '' }}
                    </span>
                    <span>LAYAK</span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 border border-gray-800 dark:border-gray-200 mr-2 flex items-center justify-center text-xs">
                        {{ $document->rekomendasi == 'tidak_layak' ? '✓' : '' }}
                    </span>
                    <span>TIDAK LAYAK</span>
                </div>
            </div>
            <div class="p-4 border-r border-gray-400 dark:border-gray-600 text-center flex flex-col justify-center items-center">
                <div class="font-bold mb-2">ZONA 1</div>
                <div class="text-2xl font-bold">{{ ($document->zona == 'zona1' || $document->zona == 'zona_1') ? '✓' : '' }}</div>
            </div>
            <div class="p-4 text-center flex flex-col justify-center items-center">
                <div class="font-bold mb-2">ZONA 2</div>
                <div class="text-2xl font-bold">{{ ($document->zona == 'zona2' || $document->zona == 'zona_2') ? '✓' : '' }}</div>
            </div>
        </div>

        <div class="font-bold mb-8 text-gray-800 dark:text-gray-200">
            Tanggal Periksa : {{ $document->tanggal_pemeriksaan ? $document->tanggal_pemeriksaan->format('d-m-Y') : '-' }}
        </div>

        <!-- SIGNATURES (MODIFIED) -->
        <div class="grid grid-cols-2 gap-8 mt-12 text-center">
            <!-- Pemeriksa -->
            <div>
                <div class="font-bold text-gray-800 dark:text-gray-200 mb-16">PEMERIKSA</div>
                <div class="text-sm">
                    <div class="font-bold text-gray-900 dark:text-white uppercase underline">
                         {{ $document->creator->name ?? '(.......................)' }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 mt-1">NPK: {{ $document->creator->npk ?? '..........' }}</div>
                </div>
            </div>

            <!-- User -->
            <div>
                <div class="font-bold text-gray-800 dark:text-gray-200 mb-16">USER / PENGEMUDI</div>
                <div class="text-sm">
                    <div class="font-bold text-gray-900 dark:text-white uppercase underline">{{ $document->nama_pengemudi }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-1">Badge No: {{ $document->npk }}</div>
                </div>
            </div>
        </div>
        
        <!-- PHOTOS IF ANY -->
        @if($document->photos && $document->photos->count())
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold text-center mb-6 text-gray-800 dark:text-white uppercase underline">LAMPIRAN FOTO PEMERIKSAAN</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($document->photos as $photo)
                    <div class="border p-2 rounded shadow-sm bg-gray-50 dark:bg-gray-700">
                        <img src="{{ asset('storage/'.$photo->file_path) }}" class="w-full h-64 object-cover rounded" alt="Foto Bukti">
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- ACTION BUTTONS -->
@if($document->workflow_status == 'submitted')
<div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
    <!-- APPROVE FORM -->
    <form action="{{ route('admin.checkup.approve', $document->id) }}" method="POST" class="w-full">
        @csrf
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <h4 class="text-lg font-bold text-green-700 dark:text-green-400 mb-2">Setujui Pengajuan</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Pastikan data sudah benar sebelum menyetujui.</p>
            <button type="submit" class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow transition-transform transform hover:scale-[1.02]">
                ✓ Approve Checkup
            </button>
        </div>
    </form>

    <!-- REJECT FORM -->
    <form action="{{ route('admin.checkup.reject', $document->id) }}" method="POST" class="w-full">
        @csrf
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <h4 class="text-lg font-bold text-red-700 dark:text-red-400 mb-2">Tolak Pengajuan</h4>
            <input type="text" 
                   name="rejected_reason" 
                   placeholder="Masukkan alasan penolakan..."
                   required
                   class="w-full mb-4 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
            <button type="submit" class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition-transform transform hover:scale-[1.02]">
                ✕ Reject Checkup
            </button>
        </div>
    </form>
</div>
@endif

@endsection
