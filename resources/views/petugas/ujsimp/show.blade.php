@extends('layouts.petugas')

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

    .checkup-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        padding: 50px 20px;
    }

    .checkup-container {
        width: 100%;
        max-width: 950px;
        background: white;
        padding: 50px 60px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border-top: 6px solid var(--primary-blue);
    }

    .checkup-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 2px solid var(--primary-blue);
    }

    .checkup-header div {
        display: flex;
        justify-content: center;
    }

    .checkup-header img {
        height: 70px;
        width: 70px;
        object-fit: contain;
    }

    .checkup-title {
        text-align: center;
        font-weight: 700;
        font-size: 22px;
        margin: 30px 0 35px 0;
        color: var(--primary-blue);
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: underline;
    }

    .checkup-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        font-size: 14px;
    }

    .checkup-table td {
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        font-size: 14px;
    }

    .checkup-table .label {
        width: 40%;
        font-weight: 600;
        color: #4a5568;
    }

    .section-title {
        margin-top: 35px;
        font-weight: 600;
        color: var(--primary-blue);
        border-left: 4px solid var(--accent-yellow);
        padding-left: 10px;
        margin-bottom: 15px;
        text-transform: uppercase;
        font-size: 14px;
    }

    .checklist-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .checklist-table th {
        background: var(--primary-blue);
        color: white;
        padding: 10px;
        font-weight: 600;
        text-align: center;
        border: 1px solid #0a3680;
    }

    .checklist-table td {
        border: 1px solid #dee2e6;
        padding: 8px 12px;
    }

    .status-badge {
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-baik {
        color: #059669;
    }

    .status-rusak {
        color: #dc2626;
    }

    .recommendation-box {
        margin-top: 20px;
        padding: 15px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    .recommendation-text {
        font-size: 15px;
        font-weight: 700;
    }

    .signature-section {
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
        text-align: center;
        font-size: 13px;
        color: #555;
    }

    .signature-section div {
        width: 30%;
    }

    .signature-section strong {
        color: var(--primary-blue);
        display: block;
        margin-bottom: 60px;
    }

    .btn-modern-back {
        background: var(--primary-blue);
        color: white;
        padding: 10px 24px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s ease;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        border: none;
        cursor: pointer;
        display: inline-block;
    }

    .btn-modern-back:hover {
        background: #08306b;
        color: white;
    }
</style>

<div class="checkup-wrapper">
    <div class="checkup-container">

        <!-- WORKFLOW STATUS BADGE -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: -20px;">
            @if($document->workflow_status == 'draft')
                <span style="background: #f3f4f6; color: #374151; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #d1d5db; text-transform: uppercase;">Draft Mode</span>
            @elseif($document->workflow_status == 'submitted')
                <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fcd34d; text-transform: uppercase;">Submitted</span>
            @elseif($document->workflow_status == 'verified')
                <span style="background: #e0f2fe; color: #0369a1; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #bae6fd; text-transform: uppercase;">Verified</span>
            @elseif($document->workflow_status == 'approved')
                <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #6ee7b7; text-transform: uppercase;">Approved</span>
            @elseif($document->workflow_status == 'rejected')
                <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fca5a5; text-transform: uppercase;">Rejected</span>
            @endif
        </div>

        <!-- HEADER LOGOS -->
        <div class="checkup-header">
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

        <div class="checkup-title">
            HASIL UJIAN PRAKTEK SIMPER / SIOPER
        </div>

        <!-- INFO TABLE -->
        <table class="checkup-table">
            <tr>
                <td class="label">Nama Candidate</td>
                <td>{{ $document->nama }}</td>
                <td class="label">Tanggal Ujian</td>
                <td>{{ \Carbon\Carbon::parse($document->tanggal_ujian)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">NPK / Badge</td>
                <td>{{ $document->npk }}</td>
                <td class="label">Nomor SIM</td>
                <td>{{ $document->nomor_sim }}</td>
            </tr>
            <tr>
                <td class="label">Perusahaan / Dept</td>
                <td>{{ $document->perusahaan }}</td>
                <td class="label">Jenis SIM</td>
                <td>{{ $document->jenis_sim }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kendaraan</td>
                <td>{{ $document->jenis_kendaraan }}</td>
                <td class="label">Jenis SIMPER</td>
                <td>{{ $document->jenis_simper }}</td>
            </tr>
        </table>

        <!-- RESULT SUMMARY -->
        <div class="recommendation-box text-center">
            <span class="text-gray-600 font-semibold">STATUS KELULUSAN:</span>
            <br>
            @php
                $statusColor = $document->status == 'lulus' ? '#059669' : '#dc2626';
            @endphp
            <span style="font-size: 20px; font-weight: 800; color: <?php echo $statusColor; ?>">
                {{ strtoupper(str_replace('_',' ',$document->status)) }}
            </span>
            <div class="mt-2 text-sm text-gray-500">
                Nilai Rata-rata: {{ number_format($document->nilai_rata_rata ?? 0, 2) }}
            </div>
        </div>

        <!-- CHECKLIST ITEMS -->
        <div class="section-title">DAFTAR NILAI UJIAN</div>
        
        <table class="checklist-table">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="60%" style="text-align: left;">Uraian Ujian</th>
                    <th width="15%">Huruf</th>
                    <th width="15%">Angka</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                @php
                $result = $results[$item->id] ?? null;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $item->item_number }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td style="text-align: center;">{{ $result->nilai_huruf ?? '-' }}</td>
                    <td style="text-align: center;">{{ $result->nilai_angka ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- NOTES -->
        <div class="section-title">CATATAN PENGUJI</div>
        <div class="recommendation-box">
            <div style="font-style: italic; color: #334155;">
                "{{ $document->catatan_penguji ?? 'Tidak ada catatan khusus.' }}"
            </div>
        </div>

        <!-- SIGNATURES -->
        <div class="signature-section">
            <div>
                <strong>Admin Perizinan</strong>
                <span style="text-decoration: underline; font-weight: 600;">{{ $document->verifier->name ?? '..........................' }}</span>
            </div>

            <div>
                <strong>AVP</strong>
                <span style="text-decoration: underline; font-weight: 600;">{{ $document->approver->name ?? '..........................' }}</span>
            </div>

            <div>
                <strong>Checker (Penguji)</strong>
                <span style="text-decoration: underline; font-weight: 600;">{{ $document->examiner->name ?? '..........................' }}</span>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="btn-action-area" style="margin-top: 50px; text-align: center; display: flex; justify-content: center; gap: 15px;">
            <a href="{{ route('petugas.ujsimp.index') }}" class="btn-modern-back" style="background: #64748b;">
                ← Kembali
            </a>

            @if($document->workflow_status == 'draft' || $document->workflow_status == 'rejected')
                <a href="{{ route('petugas.ujsimp.edit', $document->id) }}" class="btn-modern-back" style="background: #f59e0b;">
                    Edit Nilai
                </a>

                <form action="{{ route('petugas.ujsimp.submit', $document->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="btn-modern-back" 
                            style="background: #059669;"
                            onclick="return confirm('Apakah Anda yakin ingin mensubmit data ini? Data tidak dapat diubah setelah disubmit.')">
                        Submit Data
                    </button>
                </form>
            @endif
        </div>

    </div>
</div>

@endsection