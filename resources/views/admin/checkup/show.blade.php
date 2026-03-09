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

    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .photo-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        position: relative;
    }

    .photo-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        cursor: zoom-in;
        transition: transform 0.2s;
    }

    .photo-card img:hover {
        transform: scale(1.05);
    }

    .photo-meta {
        padding: 8px;
        font-size: 11px;
        color: #666;
        background: #f9fafb;
        border-top: 1px solid #eee;
        text-align: center;
    }

    @media print {
        body { background: white; }
        .checkup-wrapper { padding: 0; }
        .checkup-container { box-shadow: none; border: none; padding: 0; }
        .btn-action-area { display: none; }
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
            CHECKLIST PEMERIKSAAN KENDARAAN / ALAT
        </div>

        <!-- INFO TABLE -->
        <table class="checkup-table">
            <tr>
                <td class="label">Nama Pengemudi</td>
                <td>{{ $document->nama_pengemudi }}</td>
                <td class="label">NPK</td>
                <td>{{ $document->npk }}</td>
            </tr>
            <tr>
                <td class="label">Perusahaan</td>
                <td>{{ $document->perusahaan }}</td>
                <td class="label">No. Polisi</td>
                <td>{{ $document->no_pol }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kendaraan</td>
                <td>{{ $document->jenis_kendaraan }}</td>
                <td class="label">No. Lambung</td>
                <td>{{ $document->no_lambung ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nomor SIM</td>
                <td>{{ $document->nomor_sim ?? '-' }}</td>
                <td class="label">Nomor SIMPER</td>
                <td>{{ $document->nomor_simper ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Masa Berlaku</td>
                <td>{{ $document->masa_berlaku ?? '-' }}</td>
                <td class="label">Zona Kerja</td>
                <td style="text-transform: uppercase;">{{ $document->zona }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Periksa</td>
                <td colspan="3">{{ $document->tanggal_pemeriksaan->format('d F Y') }}</td>
            </tr>
        </table>

        <!-- CHECKLIST ITEMS -->
        <div class="section-title">HASIL PEMERIKSAAN FISIK</div>
        
        <table class="checklist-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%" style="text-align: left;">Objek Pemeriksaan</th>
                    <th width="30%" style="text-align: left;">Standard</th>
                    <th width="10%">Hasil</th>
                    <th width="25%" style="text-align: left;">Tindakan Perbaikan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                @php
                $result = $results[$item->id] ?? null;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $item->item_number }}</td>
                    <td>
                        {{ $item->item_name }}
                    </td>
                    <td>
                        {{ $item->standard }}
                    </td>
                    <td style="text-align: center;">
                        @if($result && $result->hasil === 'baik')
                        <span class="text-green-600 font-semibold">BAIK</span>
                        @elseif($result)
                        <span class="text-red-600 font-semibold">TIDAK BAIK</span>
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        {{ $result->tindakan_perbaikan ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- RECOMMENDATION & NOTES -->
        <div class="section-title">REKOMENDASI & CATATAN</div>

        <div class="recommendation-box">
            <div style="margin-bottom: 15px;">
                <span style="color: #64748b; font-size: 13px; font-weight: 600;">CATATAN PETUGAS:</span>
                <div style="margin-top: 5px; font-style: italic; color: #334155;">
                    "{{ $document->catatan_petugas ?? 'Tidak ada catatan khusus.' }}"
                </div>
            </div>

            <div style="border-top: 1px dashed #cbd5e1; padding-top: 15px;">
                <span style="color: #64748b; font-size: 13px; font-weight: 600;">HASIL AKHIR:</span>
                <div class="recommendation-text">
                    KENDARAAN DINYATAKAN: 
                    <span class="{{ $document->rekomendasi == 'layak' ? 'status-baik' : 'status-rusak' }}" style="font-size: 18px;">
                        {{ strtoupper($document->rekomendasi == 'layak' ? 'LAYAK OPERASI' : 'TIDAK LAYAK OPERASI') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- PHOTOS -->
        @if($document->photos->count())
            <div class="section-title">DOKUMENTASI FOTO ({{ $document->photos->count() }})</div>
            <div class="photo-grid">
                @foreach($document->photos as $photo)
                    <div class="photo-card group">
                        <img src="{{ asset('storage/'.$photo->file_path) }}" 
                             data-src="{{ asset('storage/'.$photo->file_path) }}"
                             onclick="openModal(this.dataset.src)"
                             loading="lazy"
                             alt="Foto Dokumentasi">
                        <div class="photo-meta">
                            {{ $photo->created_at->format('d/m/Y H:i') }}
                        </div>
                        
                        <!-- Admin Delete Button -->
                         <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <form action="{{ route('admin.checkup.photo.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-1.5 rounded-full shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- SIGNATURES -->
        <div class="signature-section">
            <div>
                <strong>Disetujui Oleh (AVP)</strong>
                <span style="text-decoration: underline; font-weight: 600;">{{ $document->approver->name ?? '..........................' }}</span>
            </div>

            <div>
                <strong>Diverifikasi Oleh (Admin)</strong>
                <span style="text-decoration: underline; font-weight: 600;">{{ $document->verifier->name ?? '..........................' }}</span>
            </div>

            <div>
                <strong>Diperiksa Oleh (Checker)</strong>
                <span style="text-decoration: underline; font-weight: 600;">{{ $document->creator->name ?? '..........................' }}</span>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="btn-action-area" style="margin-top: 50px; text-align: center; display: flex; justify-content: center; gap: 15px;">
            <a href="{{ route('admin.checkup.index') }}" class="btn-modern-back" style="background: #64748b;">
                ← Kembali
            </a>

            @if($document->workflow_status == 'submitted')
                <form action="{{ route('admin.checkup.approve', $document->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="btn-modern-back" 
                            style="background: #059669;"
                            onclick="return confirm('Apakah Anda yakin ingin memverifikasi dokumen ini?')">
                        Verify
                    </button>
                </form>

                <form action="{{ route('admin.checkup.reject', $document->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="btn-modern-back" 
                            style="background: #dc2626;"
                            onclick="return confirm('Apakah Anda yakin ingin menolak dokumen ini?')">
                        Reject
                    </button>
                </form>
            @endif

            @if($document->workflow_status == 'approved')
                <a href="{{ route('admin.checkup.preview', $document->id) }}" target="_blank" class="btn-modern-back" style="background: #3b82f6;">
                    Download PDF
                </a>
            @endif
        </div>

    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-95 flex items-center justify-center p-4" onclick="closeModal()">
    <button class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none" onclick="closeModal()">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    <img id="modalImage" class="max-w-full max-h-screen rounded shadow-2xl object-contain" onclick="event.stopPropagation()">
</div>

<script>
    function openModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if(e.key === "Escape") closeModal();
    });
</script>

@endsection