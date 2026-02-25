@extends('layouts.petugas')

@section('content')

<div class="max-w-7xl mx-auto">
    <h2 class="text-xl font-bold mb-6">Edit RANMOR Kendaraan</h2>

    <form action="{{ route('petugas.ranmor.update', $document->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- SECTION 1 — DATA KENDARAAN --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="font-semibold mb-4 border-b pb-2 text-blue-600">
                Data Pengemudi & Kendaraan
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kerja (Zonasi)</label>
                    <select name="zona" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Zona --</option>
                        <option value="zona1" {{ $document->zona == 'zona1' ? 'selected' : '' }}>Zona 1</option>
                        <option value="zona2" {{ $document->zona == 'zona2' ? 'selected' : '' }}>Zona 2</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi / Sertifikat</label>
                    <input type="text" name="no_pol" value="{{ $document->no_pol }}" placeholder="Contoh: KT-1548 YW" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Lambung</label>
                    <input type="text" name="no_lambung" value="{{ $document->no_lambung }}" placeholder="Contoh: ACI-01" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pembuatan</label>
                        <input type="text" name="tahun_pembuatan" value="{{ $document->tahun_pembuatan }}" placeholder="Tahun" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                        <input type="text" name="warna" value="{{ $document->warna }}" placeholder="Warna" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan / Departemen</label>
                    <input type="text" name="perusahaan" value="{{ $document->perusahaan }}" placeholder="Nama Perusahaan" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Merk Kendaraan</label>
                    <input type="text" name="merk_kendaraan" value="{{ $document->merk_kendaraan }}" placeholder="Contoh: Mitsubishi Xpander" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" value="{{ $document->jenis_kendaraan }}" placeholder="Jenis Kendaraan" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Kepemilikan</label>
                    <input type="text" name="status_kepemilikan" value="{{ $document->status_kepemilikan }}" placeholder="Status Kepemilikan" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rangka</label>
                    <input type="text" name="no_rangka" value="{{ $document->no_rangka }}" placeholder="Nomor Rangka" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Mesin</label>
                    <input type="text" name="no_mesin" value="{{ $document->no_mesin }}" placeholder="Nomor Mesin" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengemudi / Operator</label>
                    <input type="text" name="pengemudi" value="{{ $document->pengemudi }}" placeholder="Nama Pengemudi" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NPK</label>
                    <input type="text" name="npk" value="{{ $document->npk }}" placeholder="Nomor Pokok Karyawan" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SIM / SIO</label>
                    <input type="text" name="nomor_sim" value="{{ $document->nomor_sim }}" placeholder="Nomor SIM" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SIMPER / SIOPER</label>
                    <input type="text" name="nomor_simper" value="{{ $document->nomor_simper }}" placeholder="Nomor SIMPER" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku SIMPER / SIOPER</label>
                    <input type="text" name="masa_berlaku" value="{{ $document->masa_berlaku }}" placeholder="Contoh: JUNI 2026" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Periksa</label>
                    <input type="date" name="tanggal_periksa" value="{{ $document->tanggal_periksa->format('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>
        </div>

        {{-- SECTION 2 — YANG PERLU DILENGKAPI --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="font-semibold mb-4 border-b pb-2 text-blue-600">
                Yang Perlu Dilengkapi (Temuan)
            </h3>

            <div id="findings-container" class="space-y-3">
                @forelse($document->findings as $finding)
                <div class="flex gap-2">
                    <input type="text" name="uraian[]" value="{{ $finding->uraian }}" placeholder="Uraian temuan..." class="flex-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" onclick="removeField(this)" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                        Hapus
                    </button>
                </div>
                @empty
                <div class="flex gap-2">
                    <input type="text" name="uraian[]" placeholder="Uraian temuan..." class="flex-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" onclick="removeField(this)" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                        Hapus
                    </button>
                </div>
                @endforelse
            </div>

            <button type="button" onclick="addField()" class="mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm">
                + Tambah Baris
            </button>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('petugas.ranmor.show', $document->id) }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition font-semibold">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function addField() {
        const container = document.getElementById('findings-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="uraian[]" placeholder="Uraian temuan..." class="flex-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            <button type="button" onclick="removeField(this)" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
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