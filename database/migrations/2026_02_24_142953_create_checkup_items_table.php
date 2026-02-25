<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkup_items', function (Blueprint $table) {
            $table->id();
            $table->string('uraian');
            $table->integer('urutan');
            $table->timestamps();
        });

        DB::table('checkup_items')->insert([
            ['uraian'=>'STNK','urutan'=>1],
            ['uraian'=>'Buku KIR (Kendaraan Barang)','urutan'=>2],
            ['uraian'=>'Surat Ijin operasi bagi kendaraan luar kaltim','urutan'=>3],
            ['uraian'=>'Kotak P3','urutan'=>4],
            ['uraian'=>'Segitiga pengaman','urutan'=>5],
            ['uraian'=>'APAR (Alat Pemadam Api Ringan)','urutan'=>6],
            ['uraian'=>'Kunci Roda dan dongkrak','urutan'=>7],
            ['uraian'=>'Nomor lambung 3 sisi (kanan-kiri-belakang) & bukan magnet','urutan'=>8],
            ['uraian'=>'Kaca film maksimal 40% dan bukan rayben','urutan'=>9],
            ['uraian'=>'Kaca depan (kiri-kanan-belakang)','urutan'=>10],
            ['uraian'=>'Kaca spion (kiri-tengah-kanan)','urutan'=>11],
            ['uraian'=>'Wipper (penghapus kaca)','urutan'=>12],
            ['uraian'=>'Lampu depan besar (kiri/kanan)','urutan'=>13],
            ['uraian'=>'Lampu depan kecil (kiri/kanan)','urutan'=>14],
            ['uraian'=>'Lampu sein/rating depan (kiri/kanan)','urutan'=>15],
            ['uraian'=>'Lampu sein/rating belakang (kiri/kanan)','urutan'=>16],
            ['uraian'=>'Lampu hazard depan (kiri/kanan)','urutan'=>17],
            ['uraian'=>'Lampu hazard belakang (kiri/kanan)','urutan'=>18],
            ['uraian'=>'Lampu kotak belakang (kiri/kanan)','urutan'=>19],
            ['uraian'=>'Lampu rem (kiri/kanan)','urutan'=>20],
            ['uraian'=>'Ban & Ban Serep','urutan'=>21],
            ['uraian'=>'Pelag & Baut-baut','urutan'=>22],
            ['uraian'=>'Lampu mundur/parkir','urutan'=>23],
            ['uraian'=>'Lamp plat motor','urutan'=>24],
            ['uraian'=>'Stir (tie-rod) kemudi','urutan'=>25],
            ['uraian'=>'Body Kendaraan','urutan'=>26],
            ['uraian'=>'Lampu rotari ken besar/truck','urutan'=>27],
            ['uraian'=>'Alarm mundur ken besar/truck/bus','urutan'=>28],
            ['uraian'=>'Start-on','urutan'=>29],
            ['uraian'=>'Mesin/Panbel/Radiator','urutan'=>30],
            ['uraian'=>'Battery accu','urutan'=>31],
            ['uraian'=>'Spedometer','urutan'=>32],
            ['uraian'=>'Indikator panas dan bahan bakar','urutan'=>33],
            ['uraian'=>'Gas','urutan'=>34],
            ['uraian'=>'Knolpot tidak bocor & bukan racing','urutan'=>35],
            ['uraian'=>'Coupling','urutan'=>36],
            ['uraian'=>'Perseneling','urutan'=>37],
            ['uraian'=>'Klakson','urutan'=>38],
            ['uraian'=>'Jok/tempat duduk','urutan'=>39],
            ['uraian'=>'Safety belt','urutan'=>40],
            ['uraian'=>'Rem (brake)','urutan'=>41],
            ['uraian'=>'Hand brake','urutan'=>42],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('checkup_items');
    }
};