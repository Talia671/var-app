@extends('layouts.petugas')

@section('content')

<h4 style="margin-bottom:20px;">Edit SIMPER</h4>

<div class="card-table">

<form action="{{ route('petugas.simper.update',$assessment->id) }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="form-grid">

        <div>
            <label>Nama</label>
            <input type="text" name="nama"
                value="{{ $assessment->data_json['nama'] ?? '' }}">
        </div>

        <div>
            <label>NPK</label>
            <input type="text" name="npk"
                value="{{ $assessment->data_json['npk'] ?? '' }}">
        </div>

        <div>
            <label>Perusahaan</label>
            <input type="text" name="perusahaan"
                value="{{ $assessment->data_json['perusahaan'] ?? '' }}">
        </div>

        <div>
            <label>Jenis Kendaraan</label>
            <input type="text" name="jenis_kendaraan"
                value="{{ $assessment->data_json['jenis_kendaraan'] ?? '' }}">
        </div>

        <div>
            <label>Nomor SIM</label>
            <input type="text" name="nomor_sim"
                value="{{ $assessment->data_json['nomor_sim'] ?? '' }}">
        </div>

        <div>
            <label>Jenis SIM</label>
            <input type="text" name="jenis_sim"
                value="{{ $assessment->data_json['jenis_sim'] ?? '' }}">
        </div>

        <div>
            <label>Ganti Foto SIM</label>
            <input type="file" name="foto_sim">
        </div>

        <div>
            <label>Ganti Foto KTP</label>
            <input type="file" name="foto_ktp">
        </div>

    </div>

    <button type="submit" class="btn-submit">
        Update Data
    </button>

</form>

</div>

@endsection