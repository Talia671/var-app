@extends('layouts.admin') {{-- sesuaikan dengan layout admin kamu --}}

@section('content')

<div class="card-premium">

    <h2 style="margin-bottom:8px;">Form Ujian Praktek SIM Perusahaan</h2>
    <p style="color:#6b7280;margin-bottom:30px;">
        Input identitas peserta dan nilai 32 poin ujian keterampilan.
    </p>

    <form method="POST" action="{{ route('admin.ujsimp.store') }}">
        @csrf

        {{-- ================= IDENTITAS ================= --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:35px;">

            <div>
                <label>Nama</label>
                <input type="text" name="nama" required class="form-control">
            </div>

            <div>
                <label>NPK / Nomor Badge</label>
                <input type="text" name="npk" required class="form-control">
            </div>

            <div>
                <label>Perusahaan / Dept</label>
                <input type="text" name="perusahaan" required class="form-control">
            </div>

            <div>
                <label>Jenis Kendaraan</label>
                <input type="text" name="jenis_kendaraan" required class="form-control">
            </div>

            <div>
                <label>Tanggal Ujian</label>
                <input type="date" name="tanggal_ujian" required class="form-control">
            </div>

            <div>
                <label>Nomor SIM</label>
                <input type="text" name="nomor_sim" required class="form-control">
            </div>

            <div>
                <label>Jenis SIM</label>
                <input type="text" name="jenis_sim" required class="form-control">
            </div>

            <div>
                <label>Jenis SIMPER</label>
                <input type="text" name="jenis_simper" required class="form-control">
            </div>

        </div>

        {{-- ================= TABEL NILAI ================= --}}
        <div style="overflow-x:auto;">

            <table class="modern-table" style="font-size:13px;">

                <thead>
                    <tr>
                        <th rowspan="2" style="width:50px;">NO</th>
                        <th rowspan="2">URAIAN UJI KETERAMPILAN</th>
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
                    <tr>
                        <td>{{ $item->urutan }}</td>
                        <td>{{ $item->uraian }}</td>

                        <td style="text-align:center;">
                            <input type="radio"
                                   name="nilai[{{ $item->id }}][huruf]"
                                   value="B">
                        </td>

                        <td style="text-align:center;">
                            <input type="radio"
                                   name="nilai[{{ $item->id }}][huruf]"
                                   value="S">
                        </td>

                        <td style="text-align:center;">
                            <input type="radio"
                                   name="nilai[{{ $item->id }}][huruf]"
                                   value="K">
                        </td>

                        <td style="text-align:center;">
                            <input type="number"
                                   name="nilai[{{ $item->id }}][angka]"
                                   min="0"
                                   max="100"
                                   style="width:70px;padding:4px;">
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        {{-- ================= SUBMIT ================= --}}
        <div style="margin-top:30px;text-align:right;">
            <button type="submit"
                    style="
                        background:var(--primary);
                        color:white;
                        padding:10px 20px;
                        border:none;
                        border-radius:10px;
                        font-weight:600;
                        cursor:pointer;">
                Simpan Data Ujian
            </button>
        </div>

    </form>

</div>


{{-- ================= STYLE TAMBAHAN ================= --}}
<style>
.form-control{
    width:100%;
    padding:8px 10px;
    border-radius:8px;
    border:1px solid #e5e7eb;
    margin-top:6px;
    font-size:14px;
}
.form-control:focus{
    outline:none;
    border-color:var(--primary);
}
</style>

@endsection