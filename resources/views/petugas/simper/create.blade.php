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
        grid-template-columns: repeat(3, 1fr);
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
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(13, 71, 161, 0.1);
    }

    .zona-wrapper {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .zona-wrapper label {
        font-weight: 500;
        font-size: 14px;
    }

    .section-divider {
        margin: 35px 0 20px;
        font-weight: 600;
        color: var(--primary-blue);
        border-left: 4px solid var(--accent-yellow);
        padding-left: 10px;
    }

    .note-row {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .btn-add-note {
        background: transparent;
        color: var(--primary-blue);
        border: none;
        font-size: 14px;
        cursor: pointer;
    }

    .btn-add-note:hover {
        text-decoration: underline;
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
            Form Pengajuan SIMPER
        </div>

        <form method="POST" action="{{ route('petugas.simper.store') }}">
            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label>Lokasi Kerja (Zonasi)</label>
                    <div class="zona-wrapper">
                        <label>
                            <input type="radio" name="zona" value="zona_1" required> Zona 1
                        </label>
                        <label>
                            <input type="radio" name="zona" value="zona_2"> Zona 2
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>NPK</label>
                    <input type="text" name="npk" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Perusahaan / Dept</label>
                    <input type="text" name="perusahaan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kendaraan / Alat</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nomor SIM / SIO</label>
                    <input type="text" name="nomor_sim" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis SIM / SIO</label>
                    <input type="text" name="jenis_sim" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis SIMPER</label>
                    <select name="jenis_simper" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Uji</label>
                    <input type="date" name="tanggal_uji" class="form-control" required>
                </div>

            </div>

            <div class="section-divider">
                Yang Perlu Dilatih / Diperbaiki
            </div>

            <div id="notes-container">
                <div class="note-row">
                    <input type="text" name="notes[]" class="form-control" placeholder="Uraian catatan">
                </div>
            </div>

            <button type="button" class="btn-add-note" onclick="addNote()">
                + Tambah Catatan
            </button>

            <div class="form-actions">
                <a href="{{ route('petugas.simper.index') }}" class="btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn-submit">
                    Kirim Pengajuan
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    function addNote() {
        const container = document.getElementById('notes-container');

        const div = document.createElement('div');
        div.classList.add('note-row');

        div.innerHTML = `
            <input type="text" name="notes[]" class="form-control" placeholder="Uraian catatan">
        `;

        container.appendChild(div);
    }
</script>

@endsection