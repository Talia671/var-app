<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
@page {
    margin: 20px 30px;
}

body {
    font-family: "Arial", sans-serif;
    font-size: 11px;
    line-height: 1.2;
    color: #000;
}

.outer-border {
    border: 1px solid #000;
    padding: 10px;
    min-height: 1000px;
}

/* Header Logos */
.header-table {
    width: 100%;
    margin-bottom: 5px;
}

.header-table td {
    vertical-align: middle;
}

/* Title */
.doc-title {
    text-align: center;
    font-weight: bold;
    font-size: 13px;
    text-decoration: underline;
    margin-bottom: 10px;
    text-transform: uppercase;
}

/* Identity Section */
.identity-table {
    width: 100%;
    margin-bottom: 10px;
}

.identity-table td {
    padding: 1px 0;
    vertical-align: top;
}

.identity-label {
    width: 130px;
    font-weight: bold;
}

.identity-colon {
    width: 10px;
}

.identity-value {
    border-bottom: 1px solid #000;
    min-width: 150px;
}

/* Main Table */
.main-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

.main-table th, .main-table td {
    border: 1px solid #000;
    padding: 2px 4px;
}

.main-table th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
}

.text-center {
    text-align: center;
}

/* Signatures */
.signature-table {
    width: 100%;
    margin-top: 20px;
}

.signature-table td {
    width: 33.33%;
    text-align: center;
    vertical-align: top;
}

.signature-space {
    height: 60px;
}

.signature-name {
    font-weight: bold;
    text-decoration: underline;
}

.watermark {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-30deg);
    font-size: 60px;
    color: rgba(0,0,0,0.05);
    font-weight: bold;
    white-space: nowrap;
    z-index: -1;
}

/* Checkup specific */
.checkbox-box {
    display: inline-block;
    width: 12px;
    height: 12px;
    border: 1px solid #000;
    text-align: center;
    line-height: 12px;
    font-size: 10px;
    margin-right: 5px;
}

.rekomendasi-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.rekomendasi-table td {
    border: 1px solid #000;
    padding: 5px;
    vertical-align: top;
}
</style>
</head>

<body>

<div class="watermark">
    Departemen KAMTIB PT. Pupuk Kaltim
</div>

<div class="outer-border">

    <!-- Header Logos -->
    <table class="header-table">
        <tr>
            <td width="33%">
                <img src="{{ public_path('assets/images/logo-pkt.svg') }}" height="50">
            </td>
            <td width="34%" align="center">
                <img src="{{ public_path('assets/images/logo-satpam.svg') }}" height="50">
            </td>
            <td width="33%" align="right">
                <img src="{{ public_path('assets/images/logo-k3.svg') }}" height="50">
            </td>
        </tr>
    </table>

    <div class="doc-title">
        CHECK LIST / PEMERIKSAAN KENDARAAN PERUSAHAAN
    </div>

    <!-- Identity Section -->
    <table class="identity-table">
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td class="identity-label">NO. POL KENDARAAN</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ strtoupper($document->no_pol) }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">NO. LAMBUNG</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $document->no_lambung }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">PERUSAHAAN</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $document->perusahaan }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">JENIS KENDARAAN</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $document->jenis_kendaraan }}</td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table>
                    <tr>
                        <td class="identity-label">PENGEMUDI</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ strtoupper($document->nama_pengemudi) }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">NOMOR SIM</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $document->nomor_sim }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">NOMOR SIMPER</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $document->nomor_simper }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">MASA BERLAKU</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $document->masa_berlaku }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="2" width="5%">NO</th>
                <th rowspan="2" width="35%">OBYEK / ITEM PEMERIKSAAN</th>
                <th rowspan="2" width="15%">STANDAR</th>
                <th colspan="2" width="15%">HASIL</th>
                <th rowspan="2" width="30%">TINDAKAN PERBAIKAN</th>
            </tr>
            <tr>
                <th width="7.5%">BAIK</th>
                <th width="7.5%">TDK BAIK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($document->results as $result)
            <tr>
                <td class="text-center">{{ $result->item->urutan }}</td>
                <td>{{ $result->item->uraian }}</td>
                <td class="text-center"></td>
                <td class="text-center">
                    @if($result->hasil == 'Baik') X @endif
                </td>
                <td class="text-center">
                    @if($result->hasil != 'Baik') X @endif
                </td>
                <td>{{ $result->tindakan_perbaikan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Recommendation & Zone -->
    <table class="rekomendasi-table">
        <tr>
            <td width="40%">
                <strong>REKOMENDASI</strong><br><br>
                <div style="margin-bottom: 5px;">
                    <span class="checkbox-box">@if($document->rekomendasi == 'layak') X @endif</span> LAYAK
                </div>
                <div>
                    <span class="checkbox-box">@if($document->rekomendasi == 'tidak_layak') X @endif</span> TIDAK LAYAK
                </div>
            </td>
            <td width="30%" class="text-center" style="vertical-align: middle; font-weight: bold;">
                ZONA 1
                <br><br>
                @if($document->zona == 'zona1' || $document->zona == 'zona_1') X @endif
            </td>
            <td width="30%" class="text-center" style="vertical-align: middle; font-weight: bold;">
                ZONA 2
                <br><br>
                @if($document->zona == 'zona2' || $document->zona == 'zona_2') X @endif
            </td>
        </tr>
    </table>
    
    <div style="margin-top: 10px; font-weight: bold;">
        Tanggal Periksa : {{ $document->tanggal_pemeriksaan->format('d-m-Y') }}
    </div>

    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td>
                Approver<br>
                <div class="signature-space">
                    @if($document->workflow_status == 'approved' && $document->approver)
                        {{-- Optional: Digital Sign Indicator --}}
                        <br>
                        <span style="font-size:9px; color:green;">(DIGITALLY SIGNED)</span>
                    @endif
                </div>
                <span class="signature-name">{{ $document->approver ? $document->approver->name : '..........................' }}</span><br>
                NPK: {{ $document->approver ? $document->approver->npk : '' }}
            </td>
            <td>
                Pemeriksa<br>
                <div class="signature-space"></div>
                <span class="signature-name">{{ $document->creator ? $document->creator->name : '..........................' }}</span><br>
                NPK: {{ $document->creator ? $document->creator->npk : '' }}
            </td>
            <td>
                User<br>
                <div class="signature-space"></div>
                <span class="signature-name">{{ $document->nama_pengemudi }}</span><br>
                NPK: {{ $document->npk }}
            </td>
        </tr>
    </table>

</div>

@if($document->photos->count())
<div style="page-break-before: always;">
    <div class="outer-border">
        <div class="doc-title">LAMPIRAN FOTO PEMERIKSAAN</div>
        <div style="margin-top: 20px; text-align: center;">
            @foreach($document->photos as $photo)
                <div style="margin-bottom: 20px;">
                    <img src="{{ public_path('storage/'.$photo->file_path) }}" style="max-width: 90%; max-height: 400px; border: 1px solid #ccc; padding: 5px;">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

</body>
</html>
