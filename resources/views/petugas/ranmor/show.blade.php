@extends('layouts.petugas')

@section('content')

<div class="container-page">

    <div class="page-header">
        <h1 class="page-title">
            Detail RANMOR Kendaraan
        </h1>

        <div class="flex gap-2">
            @if($document->canBeEdited())
                <a href="{{ route('petugas.ranmor.edit',$document->id) }}" class="btn-ui btn-warning">
                    Edit
                </a>

                <form action="{{ route('petugas.ranmor.submit',$document->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-ui btn-success">
                        Submit
                    </button>
                </form>
            @endif
            <a href="{{ route('petugas.ranmor.index') }}" class="btn-ui btn-secondary">
                Kembali
            </a>
        </div>
    </div>

    {{-- STATUS BADGE --}}
    <div class="mb-6 flex items-center gap-3">
        <span class="text-sm font-medium text-gray-500">Status Dokumen:</span>
        @if($document->workflow_status == 'draft')
            <span class="badge-secondary">Draft</span>
        @elseif($document->workflow_status == 'submitted')
            <span class="badge-warning">Submitted</span>
        @elseif($document->workflow_status == 'approved')
            <span class="badge-success">Approved</span>
        @elseif($document->workflow_status == 'rejected')
            <span class="badge-danger">Rejected</span>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- SECTION 1 — DATA KENDARAAN --}}
        <div class="md:col-span-2 space-y-6">
            <div class="document-wrapper">
                <div class="document-header">
                    <h2 class="document-title">Informasi Kendaraan & Pengemudi</h2>
                </div>
                
                <div class="document-section">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Nomor Polisi / Sertifikat</span>
                            <span class="font-bold text-gray-900">{{ $document->no_pol }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Nomor Lambung</span>
                            <span class="font-bold text-gray-900">{{ $document->no_lambung }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Tahun / Warna</span>
                            <span class="font-bold text-gray-900">{{ $document->tahun_pembuatan ?? '-' }} / {{ $document->warna ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Merk / Jenis</span>
                            <span class="font-bold text-gray-900">{{ $document->merk_kendaraan ?? '-' }} / {{ $document->jenis_kendaraan ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Nomor Rangka</span>
                            <span class="font-bold text-gray-900">{{ $document->no_rangka ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Nomor Mesin</span>
                            <span class="font-bold text-gray-900">{{ $document->no_mesin ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Status Kepemilikan</span>
                            <span class="font-bold text-gray-900">{{ $document->status_kepemilikan ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Perusahaan / Departemen</span>
                            <span class="font-bold text-gray-900">{{ $document->perusahaan ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1 border-t pt-2 mt-2">
                            <span class="text-gray-500">Pengemudi / Operator</span>
                            <span class="font-bold text-gray-900">{{ $document->pengemudi }}</span>
                        </div>
                        <div class="flex flex-col gap-1 border-t pt-2 mt-2">
                            <span class="text-gray-500">NPK</span>
                            <span class="font-bold text-gray-900">{{ $document->npk }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Nomor SIM / SIO</span>
                            <span class="font-bold text-gray-900">{{ $document->nomor_sim ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Nomor SIMPER / SIOPER</span>
                            <span class="font-bold text-gray-900">{{ $document->nomor_simper ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Masa Berlaku SIMPER</span>
                            <span class="font-bold text-gray-900">{{ $document->masa_berlaku ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Tanggal Periksa</span>
                            <span class="font-bold text-gray-900">{{ $document->tanggal_periksa->format('d F Y') }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500">Lokasi Kerja (Zonasi)</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $document->zona }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2 — YANG PERLU DILENGKAPI --}}
        <div class="space-y-6">
            <div class="document-wrapper">
                <div class="document-header">
                    <h2 class="document-title text-red-600">Yang Perlu Dilengkapi</h2>
                </div>

                <div class="document-section">
                    <div class="space-y-4">
                        @forelse($document->findings as $i => $finding)
                            <div class="flex gap-3 items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-xs font-bold">{{ $i + 1 }}</span>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $finding->uraian }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500 italic text-sm">
                                Tidak ada temuan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- APPROVAL INFO --}}
            @if($document->isApproved())
            <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                <h3 class="font-bold text-green-800 mb-2 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Disetujui Oleh
                </h3>
                <p class="text-xs text-green-700">
                    {{ $document->approver->name ?? 'Admin' }} pada {{ $document->approved_at->format('d M Y H:i') }}
                </p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection