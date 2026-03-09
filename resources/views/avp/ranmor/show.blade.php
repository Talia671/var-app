@extends('layouts.admin')

@section('title', 'Detail Approval Ranmor')

@section('content')
<style>
    .ranmor-container {
        background: #fff;
        padding: 40px 50px;
        max-width: 900px;
        margin: 0 auto;
        border: 2px solid #333;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border-radius: 8px;
        position: relative;
    }

    .ranmor-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px double #333;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    .header-logos {
        display: flex;
        gap: 15px;
    }

    .header-logos img {
        height: 50px;
        width: auto;
    }

    .report-title {
        text-align: center;
        font-size: 20px;
        font-weight: 800;
        text-transform: uppercase;
        color: #1a202c;
        margin-bottom: 30px;
        text-decoration: underline;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
        font-size: 13px;
    }

    .info-item {
        display: flex;
        border-bottom: 1px dotted #ccc;
        padding: 4px 0;
    }

    .info-label {
        width: 140px;
        font-weight: 600;
        color: #4a5568;
    }

    .info-value {
        font-weight: 700;
        color: #1a202c;
    }

    .findings-section {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .findings-title {
        font-weight: 800;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 15px;
        color: #c53030;
        border-left: 4px solid #c53030;
        padding-left: 10px;
    }

    .findings-list {
        background: #fff5f5;
        border: 1px solid #feb2b2;
        padding: 20px;
        border-radius: 4px;
    }

    .finding-item {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #2d3748;
    }

    .finding-num {
        background: #c53030;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .signature-grid {
        margin-top: 50px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        text-align: center;
        font-size: 12px;
    }

    .sig-box {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 110px;
    }

    .sig-name {
        font-weight: 700;
        text-decoration: underline;
    }
</style>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('avp.approval-queue') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Approval Queue
            </a>
        </div>

        <!-- ACTION BUTTONS -->
        @if($document->workflow_status === 'verified')
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Action Approval</h3>
            <div class="flex flex-wrap gap-4" x-data="{ showRejectModal: false }">
                <form action="{{ route('avp.ranmor.approve', $document->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dokumen ini?');">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Approve (Setujui)
                    </button>
                </form>

                <button @click="showRejectModal = true" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Reject (Tolak)
                </button>

                <!-- Reject Modal -->
                <div x-show="showRejectModal" 
                     class="fixed inset-0 z-50 overflow-y-auto" 
                     x-cloak>
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showRejectModal = false">
                            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
                        </div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form action="{{ route('avp.ranmor.reject', $document->id) }}" method="POST">
                                @csrf
                                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white">Alasan Penolakan</h3>
                                            <div class="mt-4">
                                                <textarea name="rejected_reason" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500 shadow-sm" placeholder="Berikan alasan mengapa dokumen ini ditolak..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                        Konfirmasi Tolak
                                    </button>
                                    <button type="button" @click="showRejectModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif(in_array($document->workflow_status, ['approved', 'rejected']))
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 mb-6 border border-gray-200 dark:border-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Document Finalized - No further actions available.</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- LEFT COLUMN: DETAILS (REPORT FORMAT) -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="ranmor-container">
                    <div class="flex justify-between items-start mb-4">
                        <x-workflow-badge :status="$document->workflow_status" />
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Security Code</p>
                            <code class="text-blue-600 font-mono text-sm font-bold">{{ $document->security_code }}</code>
                        </div>
                    </div>

                    <div class="ranmor-header">
                        <div class="header-logos">
                            <img src="{{ asset('assets/images/logo-pkt.svg') }}" alt="Logo PKT">
                            <img src="{{ asset('assets/images/logo-k3.svg') }}" alt="Logo K3">
                        </div>
                        <div class="text-right text-[10px] font-bold text-gray-500">
                            PEMERIKSAAN FISIK KENDARAAN (RANMOR)<br>
                            NO: RANMOR/{{ $document->id }}/{{ date('Y') }}
                        </div>
                    </div>

                    <div class="report-title">
                        HASIL PEMERIKSAAN FISIK KENDARAAN
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">No. Polisi / Sertifikat</span>
                            <span class="info-value">: {{ $document->no_pol }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. Lambung</span>
                            <span class="info-value">: {{ $document->no_lambung ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tahun Pembuatan</span>
                            <span class="info-value">: {{ $document->tahun_pembuatan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Warna Kendaraan</span>
                            <span class="info-value">: {{ $document->warna ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Merk Kendaraan</span>
                            <span class="info-value">: {{ $document->merk_kendaraan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Kendaraan</span>
                            <span class="info-value">: {{ $document->jenis_kendaraan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nomor Rangka</span>
                            <span class="info-value">: {{ $document->no_rangka ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nomor Mesin</span>
                            <span class="info-value">: {{ $document->no_mesin ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status Kepemilikan</span>
                            <span class="info-value">: {{ $document->status_kepemilikan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Perusahaan</span>
                            <span class="info-value">: {{ $document->perusahaan ?? '-' }}</span>
                        </div>
                        <div class="info-item border-t pt-2">
                            <span class="info-label">Nama Pengemudi</span>
                            <span class="info-value">: {{ $document->pengemudi }}</span>
                        </div>
                        <div class="info-item border-t pt-2">
                            <span class="info-label">NPK</span>
                            <span class="info-value">: {{ $document->npk }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. SIM / SIO</span>
                            <span class="info-value">: {{ $document->nomor_sim ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. SIMPER / SIOPER</span>
                            <span class="info-value">: {{ $document->nomor_simper ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Periksa</span>
                            <span class="info-value">: {{ $document->tanggal_periksa->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Zona Kerja</span>
                            <span class="info-value">: {{ strtoupper($document->zona) }}</span>
                        </div>
                    </div>

                    <div class="findings-section">
                        <div class="findings-title">YANG PERLU DILENGKAPI / TEMUAN:</div>
                        <div class="findings-list">
                            @forelse($document->findings as $i => $finding)
                                <div class="finding-item">
                                    <span class="finding-num">{{ $i + 1 }}</span>
                                    <span>{{ $finding->uraian }}</span>
                                </div>
                            @empty
                                <div class="text-center py-4 text-green-600 font-bold italic text-sm">
                                    Kondisi kendaraan baik, tidak ada temuan pemeriksaan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if($document->catatan_petugas)
                        <div style="margin-top: 30px; padding: 20px; background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 4px;">
                            <div style="font-weight: 800; font-size: 11px; text-transform: uppercase; color: #4a5568; margin-bottom: 8px;">Catatan Tambahan Petugas:</div>
                            <div style="font-size: 13px; color: #2d3748; font-style: italic;">
                                "{{ $document->catatan_petugas }}"
                            </div>
                        </div>
                    @endif

                    <div class="signature-grid">
                        <div class="sig-box">
                            <strong>Disetujui Oleh (AVP)</strong>
                            <span class="sig-name">{{ $document->approver->name ?? '..........................' }}</span>
                        </div>
                        <div class="sig-box">
                            <strong>Diperiksa Oleh (Checker)</strong>
                            <span class="sig-name">{{ $document->creator->name ?? '..........................' }}</span>
                        </div>
                        <div class="sig-box">
                            <strong>Pengemudi / Operator</strong>
                            <span class="sig-name">{{ $document->pengemudi }}</span>
                        </div>
                    </div>
                </div>

                <!-- ACTIVITY LOGS -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase mb-6 flex items-center gap-2 tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Recent Activity Log
                    </h3>
                    <div class="space-y-4">
                        @forelse($activities as $log)
                            <div class="flex items-start gap-3 pb-4 border-b border-gray-50 dark:border-gray-900 last:border-0">
                                <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[10px] font-bold text-gray-500 uppercase">
                                    {{ substr($log->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $log->user->name ?? 'System' }}
                                        <span class="font-normal text-gray-500 ml-1 text-xs">{{ $log->description }}</span>
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-0.5 uppercase font-bold">{{ $log->created_at->format('d M Y H:i') }} • {{ $log->ip_address }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-500 italic text-center py-4">No recent activity logs found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: TIMELINE -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase mb-8 tracking-widest">Workflow Timeline</h3>
                    
                    <div class="relative pl-8 space-y-10 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-100 dark:before:bg-gray-700">
                        <!-- STEP 1: SUBMITTED -->
                        <div class="relative">
                            <div class="absolute -left-8 top-1.5 w-6 h-6 rounded-full bg-green-500 border-4 border-white dark:border-gray-800 z-10 flex items-center justify-center shadow-sm">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Submitted</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">By <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $document->creator->name ?? 'Checker' }}</span></p>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold">{{ $document->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- STEP 2: VERIFIED -->
                        <div class="relative">
                            @php $isVerified = $document->verified_at; @endphp
                            <div class="absolute -left-8 top-1.5 w-6 h-6 rounded-full {{ $isVerified ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-700' }} border-4 border-white dark:border-gray-800 z-10 flex items-center justify-center shadow-sm">
                                @if($isVerified)
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            <div class="{{ $isVerified ? '' : 'opacity-50' }}">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Verified</h4>
                                @if($isVerified)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">By <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $document->verifier->name ?? 'Admin' }}</span></p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold">{{ $document->verified_at->format('d M Y H:i') }}</p>
                                @else
                                    <p class="text-xs text-gray-400 mt-1 italic text-[11px]">Waiting for Admin Verification</p>
                                @endif
                            </div>
                        </div>

                        <!-- STEP 3: FINAL STATUS (APPROVED/REJECTED) -->
                        <div class="relative">
                            @php 
                                $isFinalized = in_array($document->workflow_status, ['approved', 'rejected']);
                                $isApproved = $document->workflow_status === 'approved';
                                $isRejected = $document->workflow_status === 'rejected';
                                $finalUser = $isApproved ? $document->approver : ($isRejected ? $document->rejecter : null);
                                $finalAt = $isApproved ? $document->approved_at : ($isRejected ? $document->rejected_at : null);
                            @endphp
                            
                            <div class="absolute -left-8 top-1.5 w-6 h-6 rounded-full {{ $isApproved ? 'bg-green-500' : ($isRejected ? 'bg-red-500' : 'bg-gray-200 dark:bg-gray-700') }} border-4 border-white dark:border-gray-800 z-10 flex items-center justify-center shadow-sm">
                                @if($isFinalized)
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            
                            <div class="{{ $isFinalized ? '' : 'opacity-50' }}">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">
                                    @if($isApproved) Approved
                                    @elseif($isRejected) Rejected
                                    @else Final Approval
                                    @endif
                                </h4>
                                @if($isFinalized)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">By <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $finalUser->name ?? 'AVP' }}</span></p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold">{{ $finalAt ? $finalAt->format('d M Y H:i') : '-' }}</p>
                                    @if($isRejected && $document->rejected_reason)
                                        <div class="mt-2 p-2 bg-red-50 dark:bg-red-900/20 rounded border border-red-100 dark:border-red-800">
                                            <p class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-tighter mb-1">Reason for Rejection:</p>
                                            <p class="text-[11px] text-red-700 dark:text-red-300 italic">"{{ $document->rejected_reason }}"</p>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-xs text-gray-400 mt-1 italic text-[11px]">Waiting for AVP Approval</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg shadow-blue-500/20">
                    <h4 class="text-xs font-bold uppercase mb-2 tracking-widest">Internal Note</h4>
                    <p class="text-[11px] text-blue-100 leading-relaxed">
                        Pastikan seluruh data identitas dan hasil pemeriksaan fisik kendaraan telah sesuai dengan standar operasional sebelum melakukan persetujuan akhir.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
