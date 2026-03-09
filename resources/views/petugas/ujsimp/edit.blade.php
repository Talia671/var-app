@extends('layouts.petugas')

@section('content')

<style>
    :root {
        --primary-blue: #0d47a1;
        --soft-blue: #e3f2fd;
        --accent-yellow: #ffc107;
        --soft-bg: #f4f6f9;
        --text-dark: #1e293b;
    }

    body {
        background: var(--soft-bg);
    }

    .form-wrapper {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .form-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 40px;
        border-top: 5px solid var(--primary-blue);
    }

    .form-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 30px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-dark);
    }

    .form-control {
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 14px;
        transition: 0.2s ease;
        width: 100%;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(13, 71, 161, 0.1);
    }

    .section-divider {
        margin: 35px 0 20px;
        font-weight: 600;
        color: var(--primary-blue);
        border-left: 4px solid var(--accent-yellow);
        padding-left: 10px;
    }

    .form-actions {
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-submit {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 14px;
        transition: 0.2s ease;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #08306b;
    }

    .btn-back {
        background: #e5e7eb;
        padding: 8px 20px;
        border-radius: 25px;
        text-decoration: none;
        color: #333;
        font-size: 13px;
    }

    .btn-back:hover {
        background: #d1d5db;
    }

    /* Table Styles for UJSIMP */
    .table-container {
        overflow-x: auto;
        margin-top: 15px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .custom-table th {
        background-color: #f8fafc;
        color: var(--text-dark);
        font-weight: 600;
        padding: 12px;
        border-bottom: 2px solid #e2e8f0;
        text-align: center;
    }

    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .category-header {
        background-color: #f1f5f9;
        font-weight: 700;
        color: var(--primary-blue);
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    .radio-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .radio-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    @media(max-width: 992px){
        .form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width: 600px){
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-wrapper">

    <div class="form-card">

        <div class="form-title">
            Edit Ujian UJSIMP
        </div>

        <form method="POST" action="{{ route('petugas.ujsimp.update', $test->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required class="form-control"
                           value="{{ $test->nama }}">
                </div>

                <div class="form-group">
                    <label>NPK / Nomor Badge</label>
                    <input type="text" name="npk" required class="form-control"
                           value="{{ $test->npk }}">
                </div>

                <div class="form-group">
                    <label>Perusahaan / Dept</label>
                    <input type="text" name="perusahaan" required class="form-control"
                           value="{{ $test->perusahaan }}">
                </div>

                <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" required class="form-control"
                           value="{{ $test->jenis_kendaraan }}">
                </div>

                <div class="form-group">
                    <label>Tanggal Ujian</label>
                    <input type="date" name="tanggal_ujian" required class="form-control"
                           value="{{ $test->tanggal_ujian }}">
                </div>

                <div class="form-group">
                    <label>Nomor SIM</label>
                    <input type="text" name="nomor_sim" required class="form-control"
                           value="{{ $test->nomor_sim }}">
                </div>

                <div class="form-group">
                    <label>Jenis SIM</label>
                    <input type="text" name="jenis_sim" required class="form-control"
                           value="{{ $test->jenis_sim }}">
                </div>

                <div class="form-group">
                    <label>Jenis SIMPER</label>
                    <input type="text" name="jenis_simper" required class="form-control"
                           value="{{ $test->jenis_simper }}">
                </div>

            </div>

            <div class="section-divider">
                Catatan Penguji
            </div>

            <div class="form-group">
                <textarea name="catatan_penguji" rows="3" class="form-control" placeholder="Masukkan catatan tambahan...">{{ $test->catatan_penguji }}</textarea>
            </div>

            <div class="section-divider">
                Uraian Uji Keterampilan
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width:50px;">NO</th>
                            <th rowspan="2" style="text-align: left;">URAIAN UJI KETERAMPILAN</th>
                            <th colspan="4" style="text-align:center;">NILAI</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;">B</th>
                            <th style="text-align:center;">S</th>
                            <th style="text-align:center;">K</th>
                            <th style="text-align:center;width:80px;">ANGKA</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $item)
                        @php
                            $score = $test->scores->firstWhere('ujsimp_item_id', $item->id);
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $item->urutan }}</td>
                            <td>{{ $item->uraian }}</td>

                            <td style="text-align:center;">
                                <div class="radio-group">
                                    <input type="radio"
                                           name="nilai[{{ $item->id }}][huruf]"
                                           value="B"
                                           class="radio-input"
                                           @if($score && $score->nilai_huruf === 'B') checked @endif>
                                </div>
                            </td>

                            <td style="text-align:center;">
                                <div class="radio-group">
                                    <input type="radio"
                                           name="nilai[{{ $item->id }}][huruf]"
                                           value="S"
                                           class="radio-input"
                                           @if($score && $score->nilai_huruf === 'S') checked @endif>
                                </div>
                            </td>

                            <td style="text-align:center;">
                                <div class="radio-group">
                                    <input type="radio"
                                           name="nilai[{{ $item->id }}][huruf]"
                                           value="K"
                                           class="radio-input"
                                           @if($score && $score->nilai_huruf === 'K') checked @endif>
                                </div>
                            </td>

                            <td style="text-align:center;">
                                <input type="number"
                                       name="nilai[{{ $item->id }}][angka]"
                                       min="0"
                                       max="100"
                                       class="form-control"
                                       style="padding: 5px; text-align: center;"
                                       value="{{ $score ? $score->nilai_angka : '' }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-actions">
                <a href="{{ route('petugas.ujsimp.index') }}" class="btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn-submit">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
