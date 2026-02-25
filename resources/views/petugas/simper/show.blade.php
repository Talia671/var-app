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

    .btn-back-bottom {
        margin-top: 35px;
        text-align: center;
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
    }

    .btn-modern-back:hover {
        background: #08306b;
        color: white;
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
        .btn-back-bottom {
            display: none;
        }
    }
</style>

<div class="simper-wrapper">
    <div class="simper-container">

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
            <td>{{ \Carbon\Carbon::parse($assessment->tanggal_uji)->format('d F Y') }}</td>
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
                    <td colspan="2">Tidak ada catatan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <div>
            <strong>Approver</strong><br><br><br>
            {{ optional($assessment->approver)->name ?? '-' }}
        </div>

        <div>
            <strong>Penguji</strong><br><br><br>
            {{ $assessment->penguji_nama }}
        </div>

        <div>
            <strong>User</strong><br><br><br>
            {{ $assessment->nama }}
        </div>
    </div>

    <div class="btn-back-bottom">
        <a href="{{ route('petugas.simper.index') }}" class="btn-modern-back">
            ← Kembali ke Riwayat
        </a>
    </div>
    </div>
</div>

@endsection