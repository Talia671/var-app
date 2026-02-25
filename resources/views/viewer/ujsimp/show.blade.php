@extends('layouts.secure-viewer')

@section('content')

<style>
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

.category-row {
    background-color: #e5e7eb;
    font-weight: bold;
}

.category-num {
    text-align: center;
    width: 30px;
}

.item-num {
    text-align: center;
    width: 30px;
}

.score-col {
    width: 20px;
    text-align: center;
    font-size: 10px;
}

.nilai-header {
    width: 100px;
}

/* Results Section */
.results-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

.results-table td {
    border: 1px solid #000;
    padding: 4px;
}

.results-label {
    font-weight: bold;
    text-align: center;
    background-color: #f2f2f2;
}

.status-box {
    text-align: center;
    width: 120px;
}

.status-checked {
    background-color: #d1d5db;
    font-weight: bold;
}

/* Notes */
.notes-section {
    margin-bottom: 15px;
}

.notes-title {
    font-weight: bold;
    margin-bottom: 5px;
}

.notes-box {
    border: 1px solid #000;
    min-height: 40px;
    padding: 5px;
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
</style>

<div class="outer-border">

    <!-- Header Logos -->
    <table class="header-table">
        <tr>
            <td width="33%">
                <img src="{{ asset('assets/images/logo-pkt.svg') }}" height="50">
            </td>
            <td width="34%" align="center">
                <img src="{{ asset('assets/images/logo-satpam.svg') }}" height="50">
            </td>
            <td width="33%" align="right">
                <img src="{{ asset('assets/images/logo-k3.svg') }}" height="50">
            </td>
        </tr>
    </table>

    <div class="doc-title">
        UJIAN PRAKTEK SURAT IZIN MENGEMUDI PERUSAHAAN
    </div>

    <!-- Identity Section -->
    <table class="identity-table">
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td class="identity-label">NAMA</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ strtoupper($test->nama) }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">NPK / NOMOR BADGE</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $test->npk }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">PERUSAHAAN / DEPT</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $test->perusahaan }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">JENIS KENDARAAN</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $test->jenis_kendaraan }}</td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table>
                    <tr>
                        <td class="identity-label">TANGGAL UJIAN</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ \Carbon\Carbon::parse($test->tanggal_ujian)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">NOMOR SIM</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $test->nomor_sim }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">JENIS SIM</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $test->jenis_sim }}</td>
                    </tr>
                    <tr>
                        <td class="identity-label">JENIS SIMPER</td>
                        <td class="identity-colon">:</td>
                        <td class="identity-value">{{ $test->jenis_simper }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">URAIAN UJI KETRAMPILAN</th>
                <th colspan="5">NILAI</th>
            </tr>
            <tr>
                <th class="score-col">B</th>
                <th class="score-col">S</th>
                <th class="score-col">K</th>
                <th class="score-col">HURUF</th>
                <th class="score-col">ANGKA</th>
            </tr>
        </thead>
        <tbody>
            @php
                $itemsConfig = config('ujsimp.items');
                $scoresMap = $test->scores->keyBy('ujsimp_item_id');
                $romans = ['I', 'II'];
            @endphp

            @foreach($itemsConfig as $catIdx => $category)
                <tr class="category-row">
                    <td class="category-num">{{ $romans[$catIdx] ?? ($catIdx + 1) }}</td>
                    <td colspan="6">{{ strtoupper(str_replace('_', ' ', $category['kategori'])) }}</td>
                </tr>

                @foreach($category['data'] as $id => $uraian)
                    @php $score = $scoresMap->get($id); @endphp
                    <tr>
                        <td class="item-num">{{ $id }}</td>
                        <td>{{ $uraian }}</td>
                        <td class="score-col">{{ optional($score)->nilai_huruf == 'B' ? 'X' : '' }}</td>
                        <td class="score-col">{{ optional($score)->nilai_huruf == 'S' ? 'X' : '' }}</td>
                        <td class="score-col">{{ optional($score)->nilai_huruf == 'K' ? 'X' : '' }}</td>
                        <td class="score-col">{{ optional($score)->nilai_huruf }}</td>
                        <td class="score-col">{{ optional($score)->nilai_angka }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <!-- Results Section -->
    <table class="results-table">
        <tr>
            <td class="results-label" rowspan="2">HASIL</td>
            <td class="results-label" rowspan="2">DINYATAKAN *</td>
            <td class="status-box {{ $test->status == 'lulus' ? 'status-checked' : '' }}">LULUS</td>
            <td class="results-label" rowspan="2">DENGAN NILAI</td>
            <td class="results-label">ANGKA</td>
            <td class="results-label">RATA-RATA</td>
        </tr>
        <tr>
            <td class="status-box {{ $test->status == 'belum_lulus' ? 'status-checked' : '' }}">BELUM LULUS</td>
            <td style="text-align:center;">{{ number_format($test->nilai_total, 0) }}</td>
            <td style="text-align:center;">{{ number_format($test->nilai_rata_rata, 2) }}</td>
        </tr>
    </table>

    <!-- Notes -->
    <div class="notes-section">
        <div class="notes-title">CATATAN PENGUJI:</div>
        <div class="notes-box">
            {{ $test->catatan_penguji ?? '-' }}
        </div>
    </div>

    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td>Aprover</td>
            <td>Penguji</td>
            <td>User</td>
        </tr>
        <tr>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
        </tr>
        <tr>
            <td>
                <div class="signature-name">{{ $test->approver->name ?? 'Nur Hidayat' }}</div>
                <div>AVP Perijinan & Adm</div>
            </td>
            <td>
                <div class="signature-name">....................................</div>
                <div>NPK:</div>
            </td>
            <td>
                <div class="signature-name">{{ strtoupper($test->nama) }}</div>
                <div>NPK: {{ $test->npk }}</div>
            </td>
        </tr>
    </table>

</div>

@endsection