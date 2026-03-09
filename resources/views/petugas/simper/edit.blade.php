@extends('layouts.petugas')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
        Edit SIMPER
    </h2>

    <form method="POST" action="{{ route('petugas.simper.update', $assessment->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" value="{{ $assessment->nama }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">NPK</label>
                <input type="text" name="npk" value="{{ $assessment->npk }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Perusahaan</label>
                <input type="text" name="perusahaan" value="{{ $assessment->perusahaan }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                <input type="text" name="jenis_kendaraan" value="{{ $assessment->jenis_kendaraan }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor SIM</label>
                <input type="text" name="nomor_sim" value="{{ $assessment->nomor_sim }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis SIM</label>
                <input type="text" name="jenis_sim" value="{{ $assessment->jenis_sim }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis SIMPER</label>
                <input type="text" name="jenis_simper" value="{{ $assessment->jenis_simper }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Uji</label>
                <input type="date" name="tanggal_uji" value="{{ $assessment->tanggal_uji ? \Carbon\Carbon::parse($assessment->tanggal_uji)->format('Y-m-d') : '' }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('petugas.simper.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-medium">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium shadow-sm">
                Update Data
            </button>
        </div>
    </form>
</div>

@endsection