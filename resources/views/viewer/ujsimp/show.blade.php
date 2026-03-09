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
                <h1 class="document-title">UJI SIMPER KENDARAAN</h1>
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
                <td class="py-1 font-semibold">Perusahaan</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->perusahaan }}</td>
                <td></td>
                <td class="py-1 font-semibold">Type Unit</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->type_unit }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Unit Kerja</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->unit_kerja }}</td>
                <td></td>
                <td class="py-1 font-semibold">Nomor Polisi</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->nomor_polisi }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Tanggal Uji</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ \Carbon\Carbon::parse($document->tanggal_uji)->format('d F Y') }}</td>
                <td></td>
                <td class="py-1 font-semibold">Hasil Uji</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300 font-bold {{ $document->hasil_uji == 'Lulus' ? 'text-green-600' : 'text-red-600' }}">{{ $document->hasil_uji }}</td>
            </tr>
        </table>
    </div>

    <!-- Main Table (Scores) -->
    <div class="document-section">
        <table class="table-ui">
            <thead>
                <tr>
                    <th class="w-10 text-center">No</th>
                    <th>Item Penilaian</th>
                    <th class="w-20 text-center">Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($document->scores as $index => $score)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $score->item->uraian }}</td>
                    <td class="text-center font-bold">{{ $score->nilai }}</td>
                    <td>{{ $score->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-50">
                    <td colspan="2" class="text-right font-bold p-3">Total Nilai:</td>
                    <td class="text-center font-bold p-3">{{ $document->scores->sum('nilai') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($document->catatan)
    <div class="document-section bg-gray-50 p-4 rounded-lg border border-gray-200">
        <h3 class="font-semibold text-gray-700 mb-2">Catatan Tambahan:</h3>
        <p class="text-sm">{{ $document->catatan }}</p>
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
@endsection    font-size: 10px;
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