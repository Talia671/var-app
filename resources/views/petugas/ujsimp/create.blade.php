@extends('layouts.petugas')

@section('content')

<div class="max-w-7xl mx-auto">

    <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">Form Ujian Praktek SIM Perusahaan</h2>

    <form method="POST" action="{{ route('petugas.ujsimp.store') }}" class="space-y-8">
        @csrf

        {{-- ============================= --}}
        {{-- SECTION 1 — DATA PESERTA --}}
        {{-- ============================= --}}
        <div class="bg-white dark:bg-night-card shadow rounded-xl p-6 border border-gray-100 dark:border-night-border">
            <h3 class="font-semibold mb-4 border-b pb-2 text-gray-800 dark:text-white">
                Data Peserta Ujian
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <input type="text" name="nama" 
                           placeholder="Nama Peserta"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <input type="text" name="npk" 
                           placeholder="NPK / Nomor Badge"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <input type="text" name="perusahaan" 
                           placeholder="Perusahaan / Dept"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <input type="text" name="jenis_kendaraan" 
                           placeholder="Jenis Kendaraan"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <input type="date" name="tanggal_ujian" 
                           placeholder="Tanggal Ujian"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <input type="text" name="nomor_sim" 
                           placeholder="Nomor SIM"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <input type="text" name="jenis_sim" 
                           placeholder="Jenis SIM"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <input type="text" name="jenis_simper" 
                           placeholder="Jenis SIMPER"
                           class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                </div>

            </div>
        </div>

        {{-- ============================= --}}
        {{-- SECTION 2 — URAIAN UJI --}}
        {{-- ============================= --}}
        <div class="bg-white dark:bg-night-card shadow rounded-xl p-6 border border-gray-100 dark:border-night-border">
            <h3 class="font-semibold mb-4 border-b pb-2 text-gray-800 dark:text-white">
                Uraian Uji Keterampilan
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th rowspan="2" class="p-3 border border-gray-200 dark:border-gray-700 text-center w-12 text-gray-700 dark:text-gray-300">NO</th>
                            <th rowspan="2" class="p-3 border border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300">URAIAN UJI KETERAMPILAN</th>
                            <th colspan="4" class="p-3 border border-gray-200 dark:border-gray-700 text-center text-gray-700 dark:text-gray-300">NILAI</th>
                        </tr>
                        <tr>
                            <th class="p-2 border border-gray-200 dark:border-gray-700 text-center w-16 text-gray-700 dark:text-gray-300">B</th>
                            <th class="p-2 border border-gray-200 dark:border-gray-700 text-center w-16 text-gray-700 dark:text-gray-300">S</th>
                            <th class="p-2 border border-gray-200 dark:border-gray-700 text-center w-16 text-gray-700 dark:text-gray-300">K</th>
                            <th class="p-2 border border-gray-200 dark:border-gray-700 text-center w-24 text-gray-700 dark:text-gray-300">ANGKA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($items as $group)
                            <tr class="bg-gray-50 dark:bg-gray-800/50">
                                <td colspan="6" class="p-3 border border-gray-200 dark:border-gray-700 font-bold text-gray-800 dark:text-gray-200">
                                    {{ strtoupper(str_replace('_',' ', $group['kategori'])) }}
                                </td>
                            </tr>

                            @foreach($group['data'] as $nomor => $uraian)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="p-3 border border-gray-200 dark:border-gray-700 text-center text-gray-600 dark:text-gray-400">
                                        {{ $nomor }}
                                    </td>
                                    <td class="p-3 border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200">
                                        {{ $uraian }}
                                    </td>

                                    <td class="p-3 border border-gray-200 dark:border-gray-700 text-center">
                                        <input type="radio"
                                               name="nilai[{{ $nomor }}][huruf]"
                                               value="B"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>

                                    <td class="p-3 border border-gray-200 dark:border-gray-700 text-center">
                                        <input type="radio"
                                               name="nilai[{{ $nomor }}][huruf]"
                                               value="S"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>

                                    <td class="p-3 border border-gray-200 dark:border-gray-700 text-center">
                                        <input type="radio"
                                               name="nilai[{{ $nomor }}][huruf]"
                                               value="K"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>

                                    <td class="p-3 border border-gray-200 dark:border-gray-700 text-center">
                                        <input type="number"
                                               name="nilai[{{ $nomor }}][angka]"
                                               min="0"
                                               max="100"
                                               class="w-full text-center text-sm border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-white p-1">
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-medium transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Data Ujian
            </button>
        </div>

    </form>

</div>

@endsection