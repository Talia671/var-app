@extends('layouts.admin')

@section('content')

<style>
    :root {
        --primary-blue: #0d47a1;
        --accent-yellow: #ffc107;
        --soft-bg: #f4f6f9;
    }

    body {
        background: var(--soft-bg);
    }

    .simper-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        padding: 50px 20px;
    }

    .simper-title {
        text-align: center;
        font-weight: 700;
        font-size: 22px;
        margin: 30px 0 35px 0;
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
        font-size: 14px;
    }

    .simper-table .label {
        width: 40%;
    }

    .note-title {
        margin-top: 25px;
        font-weight: 600;
        color: var(--primary-blue);
        border-left: 4px solid var(--accent-yellow);
        padding-left: 10px;
        margin-bottom: 10px;
    }

    .note-table {
        width: 100%;
        border-collapse: collapse;
    }

    .note-table th {
        background: var(--primary-blue);
        color: white;
        padding: 8px;
        font-weight: 500;
        font-size: 14px;
    }

    .note-table td {
        border: 1px solid #dee2e6;
        padding: 8px;
        font-size: 13px;
    }

    .signature-section {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        text-align: center;
        font-size: 13px;
        color: #555;
    }

    .signature-section strong {
        color: var(--primary-blue);
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
        height: 70px;
        width: 70px;
        object-fit: contain;
    }

    .simper-container {
        width: 100%;
        max-width: 950px;
        background: white;
        padding: 50px 60px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border-top: 6px solid var(--primary-blue);
    }

    @media print {
        body {
            background: white;
        }
    }
</style>

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

@if($assessment->workflow_status === 'submitted')
<div class="flex justify-end gap-3 mb-6">
    <form action="{{ route('admin.simper.approve', $assessment->id) }}" method="POST" onsubmit="return confirm('Verifikasi dokumen ini?')">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-secondary hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">
            Verify
        </button>
    </form>

    <form action="{{ route('admin.simper.reject', $assessment->id) }}" method="POST" onsubmit="return confirm('Tolak dokumen ini?')">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">
            Reject
        </button>
    </form>
</div>
@elseif($assessment->workflow_status === 'verified')
<div class="flex justify-end mb-6">
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
        Verified
    </span>
</div>
@elseif($assessment->workflow_status === 'rejected')
<div class="flex justify-end mb-6">
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200">
        Rejected
    </span>
</div>
@endif

<div class="simper-wrapper">
    <div class="simper-container">

    <div style="display: flex; justify-content: flex-end; margin-bottom: -20px;">
        @if($assessment->workflow_status == 'draft')
            <span style="background: #f3f4f6; color: #374151; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #d1d5db; text-transform: uppercase;">Draft Mode</span>
        @elseif($assessment->workflow_status == 'submitted')
            <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fcd34d; text-transform: uppercase;">Submitted for Verification</span>
        @elseif($assessment->workflow_status == 'verified')
            <span style="background: #e0f2fe; color: #0369a1; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #bae6fd; text-transform: uppercase;">Verified</span>
        @elseif($assessment->workflow_status == 'approved')
            <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #6ee7b7; text-transform: uppercase;">Approved</span>
        @elseif($assessment->workflow_status == 'rejected')
            <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fca5a5; text-transform: uppercase;">Rejected / Revision Required</span>
        @endif
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
                @if(str_contains($assessment->zona, '1')) ☑ @else ☐ @endif
                &nbsp;&nbsp;&nbsp;
                Zona 2 
                @if(str_contains($assessment->zona, '2')) ☑ @else ☐ @endif
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
            <td>{{ $assessment->tanggal_uji ? \Carbon\Carbon::parse($assessment->tanggal_uji)->format('d F Y') : '-' }}</td>
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
                    <td>{{ $note->uraian ?? $note->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada catatan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <div>
            <strong>Admin Perizinan</strong><br><br><br>
            {{ optional($assessment->verifier)->name ?? '..........................' }}
        </div>

        <div>
            <strong>AVP</strong><br><br><br>
            {{ optional($assessment->approver)->name ?? '..........................' }}
        </div>

        <div>
            <strong>Checker</strong><br><br><br>
            {{ $assessment->penguji_nama ?? '..........................' }}
        </div>
    </div>

    </div>
</div>

@endsection
