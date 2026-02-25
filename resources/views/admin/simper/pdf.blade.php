<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
@page {
    margin: 25px 25px;
}

body {
    font-family: "Times New Roman", serif;
    font-size: 12px;
    position: relative;
}

.watermark {
    position: fixed;
    top: 40%;
    left: 25%;
    opacity: 0.05;
    font-size: 80px;
    transform: rotate(-30deg);
    z-index: -1;
}

.outer-border {
    border: 2px solid black;
    padding: 10px;
}

.header-table {
    width: 100%;
}

.header-table td {
    vertical-align: middle;
}

.title {
    text-align: center;
    font-weight: bold;
    font-size: 14px;
    margin: 10px 0 5px 0;
}

.label-right {
    text-align: right;
    font-weight: bold;
    background: #f5f5f5;
    padding: 4px 8px;
    border: 1px solid black;
    display: inline-block;
}

.form-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
}

.form-table td {
    padding: 4px;
}

.form-table tr td:first-child {
    width: 45%;
}

.checkbox-box {
    display: inline-block;
    width: 12px;
    height: 12px;
    border: 1px solid black;
    text-align: center;
    font-size: 10px;
    line-height: 12px;
}

.notes-title {
    text-align: center;
    font-weight: bold;
    margin: 10px 0 5px 0;
}

.notes-table {
    width: 100%;
    border-collapse: collapse;
}

.notes-table th,
.notes-table td {
    border: 1px solid black;
    padding: 5px;
}

.notes-table th {
    background: #efefef;
}

.signature-table {
    width: 100%;
    margin-top: 30px;
    text-align: center;
}

.signature-table td {
    width: 33%;
    vertical-align: bottom;
}

.footer-doc {
    margin-top: 15px;
    font-size: 10px;
    text-align: right;
}
</style>

<style>
@page {
    margin: 40px;
}

.pageNumber:after {
    content: counter(page);
}
</style>

</head>

@if(!empty($showHeader))
<div style="display:flex;justify-content:space-between;
            font-size:12px;margin-bottom:15px;">
    <div>
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
    <div style="font-weight:600;">
        HASIL UJIAN PRAKTEK SIMPER / SIOPER
    </div>
</div>
@endif

@if(!empty($showFooter))
<div style="
    position:fixed;
    bottom:15px;
    right:20px;
    font-size:12px;">
    Page <span class="pageNumber"></span>
</div>
@endif

<body style="position:relative; font-family:Arial, sans-serif;">

@if(isset($showWatermark) && $showWatermark)
<div style="
    position:fixed;
    top:45%;
    left:50%;
    transform:translate(-50%, -50%) rotate(-30deg);
    font-size:42px;
    color:rgba(0,0,0,0.07);
    font-weight:700;
    white-space:nowrap;
    z-index:0;">
    Departemen KAMTIB PT. Pupuk Kaltim
</div>
@endif

<div class="outer-border">

<table class="header-table">
<tr>
<td width="33%">
    <img src="{{ public_path('assets/images/logo-pkt.svg') }}" height="60">
</td>

<td width="34%" align="center">
    <img src="{{ public_path('assets/images/logo-satpam.svg') }}" height="60">
</td>

<td width="33%" align="right">
    <img src="{{ public_path('assets/images/logo-k3.svg') }}" height="60"><br>
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

</body>
</html>