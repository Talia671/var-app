@extends('layouts.petugas')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Detail CheckUp Kendaraan</h2>

        <div class="space-x-2">
            @if($document->canBeEdited())
                <a href="{{ route('petugas.checkup.edit',$document->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Edit
                </a>

                <form action="{{ route('petugas.checkup.submit',$document->id) }}"
                      method="POST" class="inline">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Submit
                    </button>
                </form>
            @endif

            @if($document->workflow_status == 'approved')
                <a href="{{ route('petugas.checkup.preview', $document->id) }}"
                   target="_blank"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Review PDF
                </a>
            @endif
        </div>
    </div>

    {{-- STATUS --}}
    <div class="mb-4">
        Status:
        @if($document->workflow_status == 'draft')
            <span class="px-3 py-1 bg-gray-200 rounded-full text-xs">Draft</span>
        @elseif($document->workflow_status == 'submitted')
            <span class="px-3 py-1 bg-yellow-200 rounded-full text-xs">Submitted</span>
        @elseif($document->workflow_status == 'approved')
            <span class="px-3 py-1 bg-green-200 rounded-full text-xs">Approved</span>
        @elseif($document->workflow_status == 'rejected')
            <span class="px-3 py-1 bg-red-200 rounded-full text-xs">Rejected</span>
        @endif
    </div>

    {{-- DATA --}}
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h3 class="font-semibold mb-4 border-b pb-2">Data Kendaraan</h3>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>Nama: <b>{{ $document->nama_pengemudi }}</b></div>
            <div>NPK: <b>{{ $document->npk }}</b></div>
            <div>No Polisi: <b>{{ $document->no_pol }}</b></div>
            <div>No Lambung: <b>{{ $document->no_lambung }}</b></div>
            <div>Nomor SIM: <b>{{ $document->nomor_sim }}</b></div>
            <div>Nomor SIMPER: <b>{{ $document->nomor_simper }}</b></div>
            <div>Masa Berlaku: <b>{{ $document->masa_berlaku }}</b></div>
            <div>Jenis Kendaraan: <b>{{ $document->jenis_kendaraan }}</b></div>
            <div>Perusahaan: <b>{{ $document->perusahaan }}</b></div>
            <div>Tanggal: <b>{{ $document->tanggal_pemeriksaan->format('d-m-Y') }}</b></div>
            <div>Zona: <b class="uppercase">{{ $document->zona }}</b></div>
            <div>Rekomendasi: <b class="capitalize text-{{ $document->rekomendasi == 'layak' ? 'green' : 'red' }}-600">{{ $document->rekomendasi }}</b></div>
        </div>
    </div>

    {{-- CHECKLIST --}}
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h3 class="font-semibold mb-4 border-b pb-2">Checklist Pemeriksaan</h3>

        <table class="w-full text-xs border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2 text-left">Uraian</th>
                    <th class="border p-2">Hasil</th>
                    <th class="border p-2">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($document->results as $result)
                <tr>
                    <td class="border p-2 text-center">{{ $result->item->urutan }}</td>
                    <td class="border p-2">{{ $result->item->uraian }}</td>
                    <td class="border p-2 text-center">
                        @if($result->hasil == 'Baik')
                            <span class="text-green-600 font-semibold">Baik</span>
                        @else
                            <span class="text-red-600 font-semibold">{{ $result->hasil }}</span>
                        @endif
                    </td>
                    <td class="border p-2">{{ $result->tindakan_perbaikan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- FOTO --}}
    @if($document->photos->count())
    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="font-semibold mb-4 border-b pb-2">Foto Kendaraan</h3>

        <div class="grid grid-cols-3 gap-4">
            @foreach($document->photos as $photo)
                <img src="{{ asset('storage/'.$photo->file_path) }}"
                     class="rounded shadow">
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection