<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>HASIL PEMERIKSAAN RANMOR - {{ $document->no_pol }}</title>

<style>
@page {
    margin: 40px;
}

body {
    font-family: "Times New Roman", serif;
    font-size: 12px;
    position: relative;
}

.pageNumber:after {
    content: counter(page);
}

.watermark {
    position: fixed;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-30deg);
    font-size: 42px;
    color: rgba(0,0,0,0.07);
    font-weight: 700;
    white-space: nowrap;
    z-index: 0;
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
    text-transform: uppercase;
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
    vertical-align: top;
}

.form-table tr td:first-child {
    width: 45%;
    font-weight: normal;
    text-transform: uppercase;
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
    text-transform: uppercase;
    font-size: 11px;
}

.notes-table {
    width: 100%;
    border-collapse: collapse;
}

.notes-table th,
.notes-table td {
    border: 1px solid black;
    padding: 5px;
    font-size: 11px;
}

.notes-table th {
    background: #efefef;
    text-align: center;
    font-weight: bold;
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

.signature-name {
    font-weight: bold;
    text-decoration: underline;
}

.footer-doc {
    margin-top: 15px;
    font-size: 10px;
    text-align: right;
}
</style>

</head>

@if(!empty($showHeader) || true)
<div style="display:flex;justify-content:space-between;
            font-size:12px;margin-bottom:15px;">
    <div>
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
    <div style="font-weight:600;">
        HASIL PEMERIKSAAN RANMOR/ALAT BERAT
    </div>
</div>
@endif

@if(!empty($showFooter) || true)
<div style="
    position:fixed;
    bottom:15px;
    right:20px;
    font-size:12px;">
    Page <span class="pageNumber"></span>
</div>
@endif

<body style="position:relative; font-family:Arial, sans-serif;">

@if((isset($showWatermark) && $showWatermark) || true)
<div class="watermark">
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
    <span class="label-right">CEK FISIK</span>
</td>
</tr>
</table>

<div class="title">
    HASIL PEMERIKSAAN RANMOR/ALAT BERAT
</div>

<table class="form-table">
<tr>
<td>LOKASI KERJA (ZONASI)</td>
<td>
    : ZONA 1
    <span style="font-size:14px;font-weight:bold;">
        {{ $document->zona == 'zona1' ? '✔' : '☐' }}
    </span>
    &nbsp;&nbsp;
    ZONA 2
    <span style="font-size:14px;font-weight:bold;">
        {{ $document->zona == 'zona2' ? '✔' : '☐' }}
    </span>
</td>
</tr>
<tr>
<td>NOMOR POLISI / SERTIFIKAT</td>
<td>: {{ $document->no_pol }}</td>
</tr>
<tr>
<td>NOMOR LAMBUNG</td>
<td>: {{ $document->no_lambung }}</td>
</tr>
<tr>
<td>TAHUN PEMBUATAN / WARNA</td>
<td>: {{ $document->tahun_pembuatan ?? '-' }} / {{ $document->warna ?? '-' }}</td>
</tr>
<tr>
<td>PERUSAHAAN / DEPARTEMEN</td>
<td>: {{ $document->perusahaan ?? '-' }}</td>
</tr>
<tr>
<td>MERK KENDARAAN</td>
<td>: {{ $document->merk_kendaraan ?? '-' }}</td>
</tr>
<tr>
<td>JENIS KENDARAAN</td>
<td>: {{ $document->jenis_kendaraan ?? '-' }}</td>
</tr>
<tr>
<td>PENGEMUDI / OPERATOR</td>
<td>: {{ $document->pengemudi }}</td>
</tr>
<tr>
<td>NOMOR SIM / SIO</td>
<td>: {{ $document->nomor_sim ?? '-' }}</td>
</tr>
<tr>
<td>NOMOR SIMPER / SIOPER</td>
<td>: {{ $document->nomor_simper ?? '-' }}</td>
</tr>
<tr>
<td>MASA BERLAKU SIMPER / SIOPER</td>
<td>: {{ $document->masa_berlaku ?? '-' }}</td>
</tr>
<tr>
<td>TANGGAL PERIKSA</td>
<td>: {{ $document->tanggal_periksa ? $document->tanggal_periksa->format('d F Y') : '-' }}</td>
</tr>
</table>

<div class="notes-title">
    YANG PERLU DILENGKAPI
</div>

<table class="notes-table">
<thead>
    <tr>
        <th width="10%">NO URT</th>
        <th>URAIAN</th>
    </tr>
</thead>
<tbody>
    @php
        $findings = $document->findings;
        $rowCount = max(5, count($findings)); // Minimal 5 baris kosong jika tidak ada temuan
    @endphp

    @for($i = 0; $i < $rowCount; $i++)
    <tr>
        <td style="text-align:center;">{{ $i + 1 }}</td>
        <td>{{ isset($findings[$i]) ? $findings[$i]->uraian : '' }}</td>
    </tr>
    @endfor
</tbody>
</table>

<table class="signature-table">
<tr>
    <td>
        Approver<br><br><br><br>
        <span class="signature-name">{{ $document->approver->name ?? '( ....................... )' }}</span><br>
        AVP Adm & Perijinan
    </td>
    <td>
        Pemeriksa<br><br><br><br>
        <span class="signature-name">{{ $document->creator->name ?? '( ....................... )' }}</span><br>
        Petugas 1
    </td>
    <td>
        User<br><br><br><br>
        <span class="signature-name">{{ $document->pengemudi }}</span><br>
        NPK: {{ $document->npk ?? '.......................' }}
    </td>
</tr>
</table>

<div class="footer-doc">
    No. Dokumen: RANMOR/PKT/{{ $document->created_at->format('Y') }}/{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }}
</div>

</div>

</body>
</html>
