@extends('layouts.admin')

@section('title', 'Detail Approval SIMPER')

@section('content')
<style>
    :root {
        --primary-blue: #0d47a1;
        --accent-yellow: #ffc107;
        --soft-bg: #f4f6f9;
    }

    .simper-container {
        width: 100%;
        background: white;
        padding: 40px 50px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border-top: 6px solid var(--primary-blue);
    }

    .simper-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 2px solid var(--primary-blue);
    }

    .simper-header div {
        display: flex;
        justify-content: center;
    }

    .simper-header img {
        height: 60px;
        width: 60px;
        object-fit: contain;
    }

    .simper-title {
        text-align: center;
        font-weight: 700;
        font-size: 20px;
        margin: 20px 0 30px 0;
        color: var(--primary-blue);
        letter-spacing: 1px;
    }

    .simper-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        font-size: 14px;
    }

    .simper-table td {
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        color: #333;
    }

    .simper-table .label {
        width: 35%;
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .note-title {
        margin-top: 25px;
        font-weight: 600;
        color: var(--primary-blue);
        border-left: 4px solid var(--accent-yellow);
        padding-left: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        text-transform: uppercase;
    }

    .note-table {
        width: 100%;
        border-collapse: collapse;
    }

    .note-table th {
        background: var(--primary-blue);
        color: white;
        padding: 10px;
        font-weight: 500;
        font-size: 13px;
        text-align: left;
    }

    .note-table td {
        border: 1px solid #dee2e6;
        padding: 10px;
        font-size: 13px;
        color: #444;
    }

    .signature-section {
        margin-top: 40px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        text-align: center;
        font-size: 13px;
        color: #555;
    }

    .signature-section strong {
        color: var(--primary-blue);
        display: block;
        margin-bottom: 50px;
    }

    .signature-name {
        font-weight: 700;
        border-bottom: 1px solid #ccc;
        display: inline-block;
        min-width: 120px;
        padding-bottom: 2px;
        color: #333;
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
        @if($assessment->workflow_status === 'verified')
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Action Approval</h3>
            <div class="flex flex-wrap gap-4" x-data="{ showRejectModal: false }">
                <form action="{{ route('avp.simper.approve', $assessment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dokumen ini?');">
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
                            <form action="{{ route('avp.simper.reject', $assessment->id) }}" method="POST">
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
        @elseif(in_array($assessment->workflow_status, ['approved', 'rejected']))
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 mb-6 border border-gray-200 dark:border-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">Document Finalized - No further actions available.</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- LEFT COLUMN: DETAILS (REPORT FORMAT) -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="simper-container">
                    <div class="flex justify-between items-start mb-4">
                        <x-workflow-badge :status="$assessment->workflow_status" />
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Security Code</p>
                            <code class="text-blue-600 font-mono text-sm font-bold">{{ $assessment->security_code }}</code>
                        </div>
                    </div>

                    <div class="simper-header">
                        <div class="logo-left">
                            <img src="{{ asset('assets/images/logo-pkt.svg') }}" alt="Logo PKT">
                        </div>
                        <div class="logo-center">
                            <img src="{{ asset('assets/images/logo-k3.svg') }}" alt="Logo K3">
                        </div>
                        <div class="logo-right">
                            <img src="{{ asset('assets/images/logo-satpam.svg') }}" alt="Logo Satpam">
                        </div>
                    </div>

                    <div class="simper-title">
                        HASIL UJIAN PRAKTEK SIMPER / SIOPER
                    </div>

                    <table class="simper-table">
                        <tr>
                            <td class="label">Lokasi Kerja (Zonasi)</td>
                            <td>
                                Zona 1 
                                @if($assessment->zona == 'zona_1') ☑ @else ☐ @endif
                                &nbsp;&nbsp;&nbsp;
                                Zona 2 
                                @if($assessment->zona == 'zona_2') ☑ @else ☐ @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td>{{ $assessment->nama }}</td>
                        </tr>
                        <tr>
                            <td class="label">NPK / Nomor Badge</td>
                            <td>{{ $assessment->npk }}</td>
                        </tr>
                        <tr>
                            <td class="label">Perusahaan / Dept</td>
                            <td>{{ $assessment->perusahaan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Kendaraan / Alat</td>
                            <td>{{ $assessment->jenis_kendaraan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nomor SIM / SIO</td>
                            <td>{{ $assessment->nomor_sim }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jenis SIM / SIO</td>
                            <td>{{ $assessment->jenis_sim }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jenis SIMPER</td>
                            <td>{{ $assessment->jenis_simper }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal Diuji</td>
                            <td>{{ $assessment->tanggal_uji ? $assessment->tanggal_uji->format('d F Y') : '-' }}</td>
                        </tr>
                    </table>

                    <div class="note-title">
                        YANG PERLU DILATIH ATAU DIPERBAIKI
                    </div>

                    <table class="note-table">
                        <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th>Uraian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessment->notes as $note)
                                <tr>
                                    <td>{{ $note->no_urut }}</td>
                                    <td>{{ $note->uraian }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center italic text-gray-400">Tidak ada catatan assessment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($assessment->catatan_umum)
                        <div class="catatan-box" style="margin-top: 20px;">
                            <div style="font-weight: 800; font-size: 11px; text-transform: uppercase; color: #4a5568; margin-bottom: 8px;">Catatan Umum:</div>
                            <div style="font-size: 13px; color: #2d3748; font-style: italic;">
                                "{{ $assessment->catatan_umum }}"
                            </div>
                        </div>
                    @endif

                    <div class="signature-section">
                        <div>
                            <strong>Approver</strong>
                            <span class="signature-name">{{ $assessment->approver->name ?? '-' }}</span>
                        </div>
                        <div>
                            <strong>Penguji</strong>
                            <span class="signature-name">{{ $assessment->penguji_nama ?? '-' }}</span>
                        </div>
                        <div>
                            <strong>User</strong>
                            <span class="signature-name">{{ $assessment->nama }}</span>
                        </div>
                    </div>
                </div>

                <!-- RECENT ACTIVITY LOG -->
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
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">By <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $assessment->checker->name ?? 'Checker' }}</span></p>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold">{{ $assessment->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- STEP 2: VERIFIED -->
                        <div class="relative">
                            @php $isVerified = $assessment->verified_at; @endphp
                            <div class="absolute -left-8 top-1.5 w-6 h-6 rounded-full {{ $isVerified ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-700' }} border-4 border-white dark:border-gray-800 z-10 flex items-center justify-center shadow-sm">
                                @if($isVerified)
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            <div class="{{ $isVerified ? '' : 'opacity-50' }}">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Verified</h4>
                                @if($isVerified)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">By <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $assessment->verifier->name ?? 'Admin' }}</span></p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold">{{ $assessment->verified_at->format('d M Y H:i') }}</p>
                                @else
                                    <p class="text-xs text-gray-400 mt-1 italic text-[11px]">Waiting for Admin Verification</p>
                                @endif
                            </div>
                        </div>

                        <!-- STEP 3: FINAL STATUS (APPROVED/REJECTED) -->
                        <div class="relative">
                            @php 
                                $isFinalized = in_array($assessment->workflow_status, ['approved', 'rejected']);
                                $isApproved = $assessment->workflow_status === 'approved';
                                $isRejected = $assessment->workflow_status === 'rejected';
                                $finalUser = $isApproved ? $assessment->approver : ($isRejected ? $assessment->rejecter : null);
                                $finalAt = $isApproved ? $assessment->approved_at : ($isRejected ? $assessment->rejected_at : null);
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
                                    @if($isRejected && $assessment->rejected_reason)
                                        <div class="mt-2 p-2 bg-red-50 dark:bg-red-900/20 rounded border border-red-100 dark:border-red-800">
                                            <p class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-tighter mb-1">Reason for Rejection:</p>
                                            <p class="text-[11px] text-red-700 dark:text-red-300 italic">"{{ $assessment->rejected_reason }}"</p>
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
                        Pastikan seluruh data identitas dan hasil ujian praktek telah sesuai dengan standar operasional sebelum melakukan persetujuan akhir.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
