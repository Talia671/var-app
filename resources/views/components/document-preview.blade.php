<div class="document-preview">
    <!-- HEADER -->
    <div class="header-logos" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #0d47a1; padding-bottom: 15px; margin-bottom: 20px;">
        <div><img src="{{ asset('assets/images/logo-pkt.svg') }}" height="60" alt="Logo PKT"></div>
        <div><img src="{{ asset('assets/images/logo-k3.svg') }}" height="60" alt="Logo K3"></div>
        <div><img src="{{ asset('assets/images/logo-satpam.svg') }}" height="60" alt="Logo Satpam"></div>
    </div>

    <div class="document-title" style="text-align: center; font-weight: 700; font-size: 20px; color: #0d47a1; text-decoration: underline; margin-bottom: 30px; text-transform: uppercase;">
        {{ $title ?? 'DOKUMEN PEMERIKSAAN' }}
    </div>

    <!-- INFO TABLE -->
    {{ $slot }}

    <!-- INSPECTION TABLE -->
    <div class="section-title" style="margin-top: 30px; font-weight: 600; color: #0d47a1; border-left: 4px solid #ffc107; padding-left: 10px; margin-bottom: 15px; text-transform: uppercase;">
        HASIL PEMERIKSAAN
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr style="background: #0d47a1; color: white;">
                <th style="padding: 10px; border: 1px solid #0a3680;">NO</th>
                <th style="padding: 10px; border: 1px solid #0a3680; text-align: left;">URAIAN PEMERIKSAAN</th>
                <th style="padding: 10px; border: 1px solid #0a3680;">HASIL</th>
                <th style="padding: 10px; border: 1px solid #0a3680;">NILAI</th>
                <th style="padding: 10px; border: 1px solid #0a3680;">TINDAKAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @php
                    $result = $results[$item->id] ?? null;
                @endphp
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">{{ $item->urutan }}</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->uraian }}</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                        @if($result)
                            {{ $result->nilai_huruf ?? $result->status ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 8px; border: 1px solid #dee2e6; text-align: center;">
                        {{ $result->nilai_angka ?? '-' }}
                    </td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">
                        {{ $result->tindakan ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- SIGNATURES -->
    <div style="margin-top: 50px; display: flex; justify-content: space-between; text-align: center; font-size: 13px; color: #555;">
        <div style="width: 30%;">
            <strong style="color: #0d47a1; display: block; margin-bottom: 60px;">Admin Perizinan</strong>
            <span style="text-decoration: underline; font-weight: 600;">{{ $document->verifier->name ?? '..........................' }}</span>
        </div>
        <div style="width: 30%;">
            <strong style="color: #0d47a1; display: block; margin-bottom: 60px;">AVP</strong>
            <span style="text-decoration: underline; font-weight: 600;">{{ $document->approver->name ?? '..........................' }}</span>
        </div>
        <div style="width: 30%;">
            <strong style="color: #0d47a1; display: block; margin-bottom: 60px;">Checker</strong>
            <span style="text-decoration: underline; font-weight: 600;">{{ $document->examiner->name ?? $document->creator->name ?? '..........................' }}</span>
        </div>
    </div>
</div>
