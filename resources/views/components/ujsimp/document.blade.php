{{-- ================= UJSIMP DOCUMENT TEMPLATE ================= --}}

<style>
.ujsimp-wrapper {
    background: #fff;
    padding: 40px;
    max-width: 900px;
    margin: 20px auto;
    border: 2px solid #000;
    font-family: Arial, sans-serif;
}

.ujsimp-header {
    text-align: center;
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 25px;
}

.ujsimp-info {
    width: 100%;
    margin-bottom: 20px;
    font-size: 14px;
}

.ujsimp-info td {
    padding: 4px 6px;
}

.ujsimp-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.ujsimp-table th,
.ujsimp-table td {
    border: 1px solid #000;
    padding: 6px;
}

.ujsimp-table th {
    background: #f2f2f2;
}

.section-title {
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 8px;
}

.signature-box {
    margin-top: 40px;
    display: flex;
    justify-content: space-between;
    text-align: center;
}

.status-box {
    padding: 10px 15px;
    border-radius: 6px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}

.status-lulus {
    background: #e6f9f0;
    color: #059669;
}

.status-belum {
    background: #ffe5e5;
    color: #dc2626;
}
</style>

@php
    $statusClass = $test->status === 'lulus'
        ? 'status-lulus'
        : 'status-belum';
@endphp

<div class="ujsimp-wrapper">

    <div class="ujsimp-header">
        HASIL UJIAN PRAKTEK SIMPER / SIOPER
    </div>

    <div class="status-box {{ $statusClass }}">
        Status: {{ strtoupper(str_replace('_',' ',$test->status)) }}
        |
        Rata-rata: {{ number_format($test->nilai_rata_rata ?? 0,2) }}
    </div>

    <table class="ujsimp-info">
        <tr>
            <td width="200"><strong>Nama</strong></td>
            <td>: {{ $test->nama }}</td>
            <td width="200"><strong>Tanggal Ujian</strong></td>
            <td>: {{ \Carbon\Carbon::parse($test->tanggal_ujian)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>NPK / Badge</strong></td>
            <td>: {{ $test->npk }}</td>
            <td><strong>Nomor SIM</strong></td>
            <td>: {{ $test->nomor_sim }}</td>
        </tr>
        <tr>
            <td><strong>Perusahaan / Dept</strong></td>
            <td>: {{ $test->perusahaan }}</td>
            <td><strong>Jenis SIM</strong></td>
            <td>: {{ $test->jenis_sim }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Kendaraan</strong></td>
            <td>: {{ $test->jenis_kendaraan }}</td>
            <td><strong>Jenis SIMPER</strong></td>
            <td>: {{ $test->jenis_simper }}</td>
        </tr>
    </table>

    <div class="section-title">DAFTAR NILAI UJIAN</div>

    <table class="ujsimp-table">
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Uraian Ujian</th>
                <th width="80">Huruf</th>
                <th width="80">Angka</th>
            </tr>
        </thead>
        <tbody>
            @foreach($test->scores as $score)
                <tr>
                    <td>{{ optional($score->item)->urutan }}</td>
                    <td>{{ optional($score->item)->uraian }}</td>
                    <td style="text-align:center">
                        {{ $score->nilai_huruf ?? '-' }}
                    </td>
                    <td style="text-align:center">
                        {{ $score->nilai_angka ?? 0 }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Catatan Penguji</div>
    <div style="border:1px solid #000; min-height:70px; padding:8px;">
        {{ $test->catatan_penguji ?? '-' }}
    </div>

    <div class="signature-box">
        <div>
            Approver<br><br><br>
            ( {{ optional($test->approver)->name ?? '-' }} )
        </div>

        <div>
            Penguji<br><br><br>
            ( ___________________ )
        </div>

        <div>
            User<br><br><br>
            ( {{ $test->nama }} )
        </div>
    </div>

</div>