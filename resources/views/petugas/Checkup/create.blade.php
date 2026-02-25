@extends('layouts.petugas')

@section('content')

<div class="max-w-7xl mx-auto">

    <h2 class="text-xl font-bold mb-6">Form CheckUp Kendaraan</h2>

    <form action="{{ route('petugas.checkup.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-8">
        @csrf

        {{-- ============================= --}}
        {{-- SECTION 1 — DATA KENDARAAN --}}
        {{-- ============================= --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="font-semibold mb-4 border-b pb-2">
                Data Pengemudi & Kendaraan
            </h3>

            <div class="grid grid-cols-2 gap-4">

                <input type="text" name="nama_pengemudi" 
                       placeholder="Nama Pengemudi"
                       class="form-input w-full" required>

                <input type="text" name="npk" 
                       placeholder="NPK"
                       class="form-input w-full" required>

                <input type="text" name="nomor_sim" 
                       placeholder="Nomor SIM"
                       class="form-input w-full">

                <input type="text" name="nomor_simper" 
                       placeholder="Nomor SIMPER"
                       class="form-input w-full">

                <input type="text" name="masa_berlaku" 
                       placeholder="Masa Berlaku"
                       class="form-input w-full">

                <input type="text" name="no_pol" 
                       placeholder="Nomor Polisi"
                       class="form-input w-full" required>

                <input type="text" name="no_lambung" 
                       placeholder="Nomor Lambung"
                       class="form-input w-full">

                <input type="text" name="perusahaan" 
                       placeholder="Perusahaan"
                       class="form-input w-full" required>

                <input type="text" name="jenis_kendaraan" 
                       placeholder="Jenis Kendaraan"
                       class="form-input w-full" required>

                <input type="date" name="tanggal_pemeriksaan"
                       class="form-input w-full" required>

            </div>
        </div>

        {{-- ============================= --}}
        {{-- SECTION 2 — CHECKLIST --}}
        {{-- ============================= --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="font-semibold mb-4 border-b pb-2">
                Checklist Pemeriksaan
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border text-left">Objek Pemeriksaan</th>
                            <th class="p-2 border">Baik</th>
                            <th class="p-2 border">Tidak Baik</th>
                            <th class="p-2 border">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr class="border-b">
                            <td class="p-2 border text-center">
                                {{ $item->urutan }}
                            </td>
                            <td class="p-2 border">
                                {{ $item->uraian }}
                            </td>
                            <td class="p-2 border text-center">
                                <input type="radio"
                                       name="hasil[{{ $item->id }}]"
                                       value="baik"
                                       required>
                            </td>
                            <td class="p-2 border text-center">
                                <input type="radio"
                                       name="hasil[{{ $item->id }}]"
                                       value="tidak_baik"
                                       required>
                            </td>
                            <td class="p-2 border">
                                <input type="text"
                                       name="tindakan[{{ $item->id }}]"
                                       class="w-full border rounded px-2 py-1 text-xs">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ============================= --}}
        {{-- SECTION 3 — REKOMENDASI --}}
        {{-- ============================= --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="font-semibold mb-4 border-b pb-2">
                Rekomendasi
            </h3>

            <div class="grid grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 font-medium">Status Kendaraan</label>
                    <select name="rekomendasi" class="form-input w-full">
                        <option value="">-- Pilih --</option>
                        <option value="layak">Layak</option>
                        <option value="tidak_layak">Tidak Layak</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Zona</label>
                    <select name="zona" class="form-input w-full">
                        <option value="">-- Pilih --</option>
                        <option value="zona1">Zona 1</option>
                        <option value="zona2">Zona 2</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ============================= --}}
        {{-- SECTION 4 — FOTO --}}
        {{-- ============================= --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="font-semibold mb-4 border-b pb-2">
                Upload Foto Kendaraan
            </h3>

            <input type="file"
                   name="photos[]"
                   multiple
                   accept="image/*"
                   class="border p-2 rounded w-full">
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                Simpan Draft
            </button>
        </div>

    </form>

</div>

@endsection