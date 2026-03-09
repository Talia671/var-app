@extends('layouts.secure-viewer')

@section('content')

<div class="document-wrapper card-ui p-8">
    <!-- Header -->
    <table class="w-full mb-6">
        <tr>
            <td width="20%">
                <img src="{{ asset('assets/images/logo-pkt.svg') }}" alt="Logo PKT" style="height: 50px;">
            </td>
            <td width="60%" class="text-center">
                <h1 class="document-title">FORMULIR PERMOHONAN SIMPER</h1>
                <p class="text-sm text-gray-500">PT PUPUK KALIMANTAN TIMUR</p>
            </td>
            <td width="20%" class="text-right">
                <img src="{{ asset('assets/images/logo-k3.svg') }}" alt="Logo K3" style="height: 50px;">
            </td>
        </tr>
    </table>

    <!-- Identity -->
    <div class="document-section">
        <table class="w-full text-sm">
            <tr>
                <td width="150" class="py-1 font-semibold">Nama</td>
                <td width="10" class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->nama }}</td>
                <td width="20"></td>
                <td width="150" class="py-1 font-semibold">Jenis Kendaraan</td>
                <td width="10" class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->jenis_kendaraan }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">NPK</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->npk }}</td>
                <td></td>
                <td class="py-1 font-semibold">Nomor SIM/SIO</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->nomor_sim }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Perusahaan/Dept</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->perusahaan }}</td>
                <td></td>
                <td class="py-1 font-semibold">Jenis SIM/SIO</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->jenis_sim }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Lokasi Kerja</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">
                    @if($document->zona == 'zona_1')
                        Zona 1 (Restricted Area)
                    @else
                        Zona 2 (Non-Restricted Area)
                    @endif
                </td>
                <td></td>
                <td class="py-1 font-semibold">Jenis SIMPER</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300 font-bold">{{ $document->jenis_simper }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Tanggal Uji</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ \Carbon\Carbon::parse($document->tanggal_uji)->format('d F Y') }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <!-- Notes Table -->
    @if(count($document->notes) > 0)
    <div class="document-section">
        <h3 class="font-semibold text-gray-700 mb-2">Yang Perlu Dilatih / Diperbaiki:</h3>
        <table class="table-ui">
            <thead>
                <tr>
                    <th class="w-10 text-center">No</th>
                    <th>Uraian Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($document->notes as $index => $note)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $note }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Signatures -->
    <div class="signature-grid">
        <div>
            <p class="text-sm mb-8">Penguji (Checker)</p>
            <div class="signature-space">
                @if($document->checker)
                    <div class="text-green-600 text-xs mb-1">Digitally Signed</div>
                    <div class="font-bold">{{ $document->checker->name }}</div>
                    <div class="text-xs text-gray-500">{{ $document->created_at->format('d M Y H:i') }}</div>
                @else
                    <br><br>
                @endif
            </div>
            <div class="signature-name border-t border-gray-300 pt-2">{{ $document->checker->name ?? '....................' }}</div>
        </div>

        <div>
            <p class="text-sm mb-8">Diverifikasi Admin</p>
            <div class="signature-space">
                @if($document->admin_approval_status === 'approved')
                    <div class="text-green-600 text-xs mb-1">Digitally Verified</div>
                    <div class="font-bold">{{ $document->admin_approver->name ?? 'Admin' }}</div>
                    <div class="text-xs text-gray-500">{{ $document->admin_approval_date ? \Carbon\Carbon::parse($document->admin_approval_date)->format('d M Y H:i') : '' }}</div>
                @else
                    <br><br>
                @endif
            </div>
            <div class="signature-name border-t border-gray-300 pt-2">Admin Perizinan</div>
        </div>

        <div>
            <p class="text-sm mb-8">Disetujui AVP</p>
            <div class="signature-space">
                @if($document->avp_approval_status === 'approved')
                    <div class="text-green-600 text-xs mb-1">Digitally Approved</div>
                    <div class="font-bold">{{ $document->avp_approver->name ?? 'AVP' }}</div>
                    <div class="text-xs text-gray-500">{{ $document->avp_approval_date ? \Carbon\Carbon::parse($document->avp_approval_date)->format('d M Y H:i') : '' }}</div>
                @else
                    <br><br>
                @endif
            </div>
            <div class="signature-name border-t border-gray-300 pt-2">AVP K3</div>
        </div>
    </div>
</div>
@endsection
    .footer-doc {
        margin-top: 15px;
        font-size: 10px;
        text-align: right;
    }
</style>

<div class="outer-border">

<table class="header-table">
<tr>
<td width="33%">
    <img src="{{ asset('assets/images/logo-pkt.svg') }}" height="60">
</td>

<td width="34%" align="center">
    <img src="{{ asset('assets/images/logo-satpam.svg') }}" height="60">
</td>

<td width="33%" align="right">
    <img src="{{ asset('assets/images/logo-k3.svg') }}" height="60"><br>
    <span class="label-right">TES PRAKTEK</span>
</td>
</tr>
</table>

<div class="title">
HASIL UJIAN PRAKTEK SIMPER / SIOPER
</div>

<table class="form-table">
<tr>
<td>LOKASI KERJA (ZONASI)</td>
<td>
    ZONA 1
    <span style="font-size:18px;font-weight:bold;">
        {{ $assessment->zona == 1 ? '✔' : '' }}
    </span>
</td>

<td>
    ZONA 2
    <span style="font-size:18px;font-weight:bold;">
        {{ $assessment->zona == 2 ? '✔' : '' }}
    </span>
</td>
</tr>

<tr>
<td>NAMA</td>
<td>: {{ strtoupper($assessment->name) }}</td>
</tr>

<tr>
<td>NPK / NOMOR BADGE</td>
<td>: {{ $assessment->npk }}</td>
</tr>

<tr>
<td>PERUSAHAAN / DEPT</td>
<td>: {{ $assessment->perusahaan }}</td>
</tr>

<tr>
<td>JENIS KENDARAAN / ALBET</td>
<td>: {{ $assessment->jenis_kendaraan }}</td>
</tr>

<tr>
<td>NOMOR SIM / SIO</td>
<td>: {{ $assessment->nomor_sim }}</td>
</tr>

<tr>
<td>JENIS SIM / SIO</td>
<td>: {{ $assessment->jenis_sim }}</td>
</tr>

<tr>
<td>JENIS SIMPER / SIOPER</td>
<td>: {{ $assessment->jenis_simper }}</td>
</tr>

<tr>
<td>TANGGAL DIUJI</td>
<td>: {{ \Carbon\Carbon::parse($assessment->tanggal_uji)->format('d F Y') }}</td>
</tr>
</table>

<div class="notes-title">
YANG PERLU DILATIH ATAU DIPERBAIKI
</div>

<table class="notes-table">
<tr>
<th width="10%">NO URT</th>
<th width="90%">URAIAN</th>
</tr>

@foreach($assessment->notes as $i => $note)
<tr>
<td align="center">{{ $i+1 }}</td>
<td>{{ $note->description }}</td>
</tr>
@endforeach

@for($i = count($assessment->notes); $i < 5; $i++)
<tr>
<td>&nbsp;</td>
<td></td>
</tr>
@endfor
</table>

<table class="signature-table">
<tr>
<td>Approver</td>
<td>Penguji</td>
<td>User</td>
</tr>

<tr>
<td style="padding-top:60px;">
(___________________)<br>
AVP Adm & Perijinan
</td>

<td style="padding-top:60px;">
(___________________)<br>
NPK:
</td>

<td style="padding-top:60px;">
( {{ strtoupper($assessment->name) }} )<br>
NPK: {{ $assessment->npk }}
</td>
</tr>
</table>

<div class="footer-doc">
No. Dokumen:
SIMPER/PKT/{{ date('Y') }}/{{ str_pad($assessment->id,4,'0',STR_PAD_LEFT) }}
</div>

</div>
@endsection