@extends('layouts.petugas')

@section('content')

<div class="container-page">

    <div class="page-header">
        <h1 class="page-title">
            Edit RANMOR Kendaraan
        </h1>
    </div>

    <div class="card-ui">

        <form action="{{ route('petugas.ranmor.update', $document->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-section">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Data Pengemudi & Kendaraan</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Lokasi Kerja (Zonasi)</label>
                        <select name="zona" class="form-control" required>
                            <option value="">-- Pilih Zona --</option>
                            <option value="zona1" {{ $document->zona == 'zona1' ? 'selected' : '' }}>Zona 1</option>
                            <option value="zona2" {{ $document->zona == 'zona2' ? 'selected' : '' }}>Zona 2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Polisi / Sertifikat</label>
                        <input type="text" name="no_pol" value="{{ $document->no_pol }}" placeholder="Contoh: KT-1548 YW" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Lambung</label>
                        <input type="text" name="no_lambung" value="{{ $document->no_lambung }}" placeholder="Contoh: ACI-01" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tahun Pembuatan</label>
                        <input type="text" name="tahun_pembuatan" value="{{ $document->tahun_pembuatan }}" placeholder="Tahun" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Warna</label>
                        <input type="text" name="warna" value="{{ $document->warna }}" placeholder="Warna" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Perusahaan / Departemen</label>
                        <input type="text" name="perusahaan" value="{{ $document->perusahaan }}" placeholder="Nama Perusahaan" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Merk Kendaraan</label>
                        <input type="text" name="merk_kendaraan" value="{{ $document->merk_kendaraan }}" placeholder="Contoh: Mitsubishi Xpander" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" value="{{ $document->jenis_kendaraan }}" placeholder="Jenis Kendaraan" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Kepemilikan</label>
                        <input type="text" name="status_kepemilikan" value="{{ $document->status_kepemilikan }}" placeholder="Status Kepemilikan" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Rangka</label>
                        <input type="text" name="no_rangka" value="{{ $document->no_rangka }}" placeholder="Nomor Rangka" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Mesin</label>
                        <input type="text" name="no_mesin" value="{{ $document->no_mesin }}" placeholder="Nomor Mesin" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pengemudi / Operator</label>
                        <input type="text" name="pengemudi" value="{{ $document->pengemudi }}" placeholder="Nama Pengemudi" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">NPK</label>
                        <input type="text" name="npk" value="{{ $document->npk }}" placeholder="Nomor Pokok Karyawan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor SIM / SIO</label>
                        <input type="text" name="nomor_sim" value="{{ $document->nomor_sim }}" placeholder="Nomor SIM" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor SIMPER / SIOPER</label>
                        <input type="text" name="nomor_simper" value="{{ $document->nomor_simper }}" placeholder="Nomor SIMPER" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Masa Berlaku SIMPER / SIOPER</label>
                        <input type="text" name="masa_berlaku" value="{{ $document->masa_berlaku }}" placeholder="Contoh: JUNI 2026" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa" value="{{ $document->tanggal_periksa ? $document->tanggal_periksa->format('Y-m-d') : '' }}" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="card-section mt-6">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Temuan & Catatan</h3>

                <div class="form-group">
                    <label class="form-label">Yang Perlu Dilengkapi (Temuan)</label>
                    <div id="findings-container" class="space-y-3 mb-3">
                        @forelse($document->findings as $finding)
                        <div class="flex gap-2">
                            <input type="text" name="uraian[]" value="{{ $finding->uraian }}" placeholder="Uraian temuan..." class="form-control">
                            <button type="button" onclick="removeField(this)" class="btn-ui btn-danger">
                                Hapus
                            </button>
                        </div>
                        @empty
                        <div class="flex gap-2">
                            <input type="text" name="uraian[]" placeholder="Uraian temuan..." class="form-control">
                            <button type="button" onclick="removeField(this)" class="btn-ui btn-danger">
                                Hapus
                            </button>
                        </div>
                        @endforelse
                    </div>

                    <button type="button" onclick="addField()" class="btn-ui btn-secondary">
                        + Tambah Baris Temuan
                    </button>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan_petugas" rows="3" class="form-control" placeholder="Masukkan catatan tambahan jika ada...">{{ $document->catatan_petugas }}</textarea>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('petugas.ranmor.index') }}" class="btn-ui btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn-ui btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addField() {
        const container = document.getElementById('findings-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="uraian[]" placeholder="Uraian temuan..." class="form-control">
            <button type="button" onclick="removeField(this)" class="btn-ui btn-danger">
                Hapus
            </button>
        `;
        container.appendChild(div);
    }

    function removeField(button) {
        button.parentElement.remove();
    }
</script>

@endsection
