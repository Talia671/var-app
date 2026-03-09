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
                <h1 class="document-title">CHECKLIST PEMERIKSAAN KENDARAAN</h1>
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
                <td width="150" class="py-1 font-semibold">Nama Pengemudi</td>
                <td width="10" class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->nama_pengemudi }}</td>
                <td width="20"></td>
                <td width="150" class="py-1 font-semibold">Nomor Polisi</td>
                <td width="10" class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->nomor_polisi }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Perusahaan</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->perusahaan }}</td>
                <td></td>
                <td class="py-1 font-semibold">Nomor Lambung</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->nomor_lambung }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Departemen</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->departemen }}</td>
                <td></td>
                <td class="py-1 font-semibold">Lokasi</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->lokasi_pemeriksaan }}</td>
            </tr>
            <tr>
                <td class="py-1 font-semibold">Jenis Kendaraan</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ $document->jenis_kendaraan }}</td>
                <td></td>
                <td class="py-1 font-semibold">Tanggal</td>
                <td class="py-1">:</td>
                <td class="py-1 border-b border-gray-300">{{ \Carbon\Carbon::parse($document->tanggal_pemeriksaan)->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Main Table -->
    <div class="document-section">
        <table class="table-ui">
            <thead>
                <tr>
                    <th class="w-10 text-center">No</th>
                    <th>Item Pemeriksaan</th>
                    <th class="w-20 text-center">Kondisi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($document->results as $index => $result)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $result->item->item_name }}</td>
                    <td class="text-center">
                        @if($result->hasil === 'baik')
                            <span class="text-green-600 font-bold">✓</span>
                        @else
                            <span class="text-red-600 font-bold">✗</span>
                        @endif
                    </td>
                    <td>{{ $result->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
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
            <p class="text-sm mb-8">Diperiksa Oleh (Checker)</p>
            <div class="signature-space">
                @if($document->creator)
                    <div class="text-green-600 text-xs mb-1">Digitally Signed</div>
                    <div class="font-bold">{{ $document->creator->name }}</div>
                    <div class="text-xs text-gray-500">{{ $document->created_at->format('d M Y H:i') }}</div>
                @else
                    <br><br>
                @endif
            </div>
            <div class="signature-name border-t border-gray-300 pt-2">{{ $document->creator->name ?? '....................' }}</div>
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
@endsection}

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
                <th width="5%">NO</th>
                <th width="30%">OBYEK / ITEM PEMERIKSAAN</th>
                <th width="20%">STANDAR</th>
                <th width="15%">HASIL</th>
                <th width="30%">TINDAKAN PERBAIKAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            @php
                $result = $results[$item->id] ?? null;
            @endphp
            <tr>
                <td class="text-center">{{ $item->item_number }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->standard }}</td>
                <td class="text-center">
                    @if($result)
                        @if(strtolower($result->hasil) == 'baik')
                            <span style="color: green; font-weight: bold;">BAIK</span>
                        @else
                            <span style="color: red; font-weight: bold;">TIDAK BAIK</span>
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td>{{ $result->tindakan_perbaikan ?? '-' }}</td>
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
                    <span class="checkbox-box">@if($document->rekomendasi == 'layak') ✔ @endif</span> LAYAK
                </div>
                <div>
                    <span class="checkbox-box">@if($document->rekomendasi == 'tidak_layak') ✔ @endif</span> TIDAK LAYAK
                </div>
            </td>
            <td width="30%" class="text-center" style="vertical-align: middle; font-weight: bold;">
                ZONA 1
                <br><br>
                @if($document->zona == 'zona1' || $document->zona == 'zona_1') ✔ @endif
            </td>
            <td width="30%" class="text-center" style="vertical-align: middle; font-weight: bold;">
                ZONA 2
                <br><br>
                @if($document->zona == 'zona2' || $document->zona == 'zona_2') ✔ @endif
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
                Approver (AVP)<br>
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
<div style="page-break-before: always; margin-top: 20px;">
    <div class="outer-border">
        <div class="doc-title">LAMPIRAN FOTO PEMERIKSAAN</div>
        <div style="margin-top: 20px; text-align: center;">
            @foreach($document->photos as $photo)
                <div style="margin-bottom: 20px;">
                    <img src="{{ asset('storage/'.$photo->file_path) }}" style="max-width: 90%; max-height: 400px; border: 1px solid #ccc; padding: 5px;">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection