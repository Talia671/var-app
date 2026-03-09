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

    /* Table Styles */
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
        text-align: left;
    }

    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
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
            Edit CheckUp Kendaraan
        </div>

        <form action="{{ route('petugas.checkup.update', $document->id) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Pengemudi</label>
                    <input type="text" name="nama_pengemudi" class="form-control" required value="{{ $document->nama_pengemudi }}">
                </div>

                <div class="form-group">
                    <label>NPK</label>
                    <input type="text" name="npk" class="form-control" required value="{{ $document->npk }}">
                </div>

                <div class="form-group">
                    <label>Nomor SIM</label>
                    <input type="text" name="nomor_sim" class="form-control" value="{{ $document->nomor_sim }}">
                </div>

                <div class="form-group">
                    <label>Nomor SIMPER</label>
                    <input type="text" name="nomor_simper" class="form-control" value="{{ $document->nomor_simper }}">
                </div>

                <div class="form-group">
                    <label>Masa Berlaku</label>
                    <input type="text" name="masa_berlaku" class="form-control" value="{{ $document->masa_berlaku }}">
                </div>

                <div class="form-group">
                    <label>Nomor Polisi</label>
                    <input type="text" name="no_pol" class="form-control" required value="{{ $document->no_pol }}">
                </div>

                <div class="form-group">
                    <label>Nomor Lambung</label>
                    <input type="text" name="no_lambung" class="form-control" value="{{ $document->no_lambung }}">
                </div>

                <div class="form-group">
                    <label>Perusahaan</label>
                    <input type="text" name="perusahaan" class="form-control" required value="{{ $document->perusahaan }}">
                </div>

                <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" required value="{{ $document->jenis_kendaraan }}">
                </div>

                <div class="form-group">
                    <label>Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" class="form-control" required value="{{ $document->tanggal_pemeriksaan }}">
                </div>

            </div>

            <div class="section-divider">
                Checklist Pemeriksaan
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Objek Pemeriksaan</th>
                            <th style="width: 80px; text-align: center;">Baik</th>
                            <th style="width: 80px; text-align: center;">Tidak Baik</th>
                            <th style="width: 250px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        @php
                            $result = $document->results->firstWhere('checkup_item_id', $item->id);
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $item->item_number }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td style="text-align: center;">
                                <div class="radio-group">
                                    <input type="radio" name="hasil[{{ $item->id }}]" value="baik" class="radio-input" required {{ $result && $result->hasil == 'baik' ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div class="radio-group">
                                    <input type="radio" name="hasil[{{ $item->id }}]" value="tidak_baik" class="radio-input" required {{ $result && $result->hasil == 'tidak_baik' ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="tindakan_perbaikan[{{ $item->id }}]" class="form-control" style="padding: 6px;" value="{{ $result ? $result->tindakan_perbaikan : '' }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="section-divider">
                Rekomendasi & Catatan
            </div>

            <div class="form-grid" style="grid-template-columns: 1fr 1fr;">
                <div class="form-group">
                    <label>Status Kendaraan</label>
                    <select name="rekomendasi" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="layak" {{ $document->rekomendasi == 'layak' ? 'selected' : '' }}>Layak</option>
                        <option value="tidak_layak" {{ $document->rekomendasi == 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Zona</label>
                    <select name="zona" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="zona1" {{ $document->zona == 'zona1' ? 'selected' : '' }}>Zona 1</option>
                        <option value="zona2" {{ $document->zona == 'zona2' ? 'selected' : '' }}>Zona 2</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <label>Catatan Tambahan (Opsional)</label>
                <textarea name="catatan_petugas" rows="3" class="form-control" placeholder="Masukkan catatan tambahan jika ada...">{{ $document->catatan_petugas }}</textarea>
            </div>

            <div class="section-divider">
                Lampiran Foto
            </div>

            @if($document->photos->count())
                <h5 class="mt-4" style="font-size: 14px; font-weight: 600; color: #555;">Lampiran Foto Saat Ini</h5>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-bottom: 20px;">
                    @foreach($document->photos as $photo)
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$photo->file_path) }}" style="width:100%; border-radius:8px; height: 120px; object-fit: cover; border: 1px solid #ddd;">
                    </div>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label class="form-label mt-3">Tambah Foto Baru</label>
                <input type="file" name="photos[]" multiple accept=".jpg,.jpeg" class="form-control">
                <p class="text-xs text-gray-400 mt-2" style="font-size: 12px; color: #888;">Format: JPG/JPEG Only. Max 4MB per file.</p>
            </div>

            <div class="form-actions">
                <a href="{{ route('petugas.checkup.index') }}" class="btn-back">
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
