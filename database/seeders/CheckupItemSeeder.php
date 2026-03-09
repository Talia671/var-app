<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckupItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'item_number' => 1,
                'item_name' => 'STNK',
                'standard' => 'Dokumen kendaraan harus tersedia dan masih berlaku',
                'category' => 'dokumen',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 1,
                'uraian' => 'STNK'
            ],
            [
                'item_number' => 2,
                'item_name' => 'Buku KIR (Kendaraan Barang)',
                'standard' => 'Buku KIR harus valid dan sesuai kendaraan',
                'category' => 'dokumen',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik','tidak_ada']),
                'is_active' => 1,
                'urutan' => 2,
                'uraian' => 'Buku KIR (Kendaraan Barang)'
            ],
            [
                'item_number' => 3,
                'item_name' => 'Surat Ijin operasi bagi kendaraan luar kaltim',
                'standard' => 'Harus memiliki surat ijin operasi yang sah',
                'category' => 'dokumen',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik','tidak_ada']),
                'is_active' => 1,
                'urutan' => 3,
                'uraian' => 'Surat Ijin operasi bagi kendaraan luar kaltim'
            ],
            [
                'item_number' => 4,
                'item_name' => 'Kotak P3K',
                'standard' => 'Peralatan P3K tersedia dan lengkap',
                'category' => 'perlengkapan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 4,
                'uraian' => 'Kotak P3K'
            ],
            [
                'item_number' => 5,
                'item_name' => 'Segitiga pengaman',
                'standard' => 'Segitiga pengaman tersedia',
                'category' => 'perlengkapan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 5,
                'uraian' => 'Segitiga pengaman'
            ],
            [
                'item_number' => 6,
                'item_name' => 'APAR (Alat Pemadam Api Ringan)',
                'standard' => 'APAR tersedia, belum kadaluarsa dan tekanan normal',
                'category' => 'perlengkapan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 6,
                'uraian' => 'APAR (Alat Pemadam Api Ringan)'
            ],
            [
                'item_number' => 7,
                'item_name' => 'Kunci Roda dan dongkrak',
                'standard' => 'Tersedia dan berfungsi',
                'category' => 'perlengkapan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 7,
                'uraian' => 'Kunci Roda dan dongkrak'
            ],
            [
                'item_number' => 8,
                'item_name' => 'Nomor lambung 3 sisi (kanan-kiri-belakang) & bukan magnet',
                'standard' => 'Nomor lambung terlihat jelas dan permanen (stiker/cat)',
                'category' => 'body',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 8,
                'uraian' => 'Nomor lambung 3 sisi (kanan-kiri-belakang) & bukan magnet'
            ],
            [
                'item_number' => 9,
                'item_name' => 'Kaca film maksimal 40% dan bukan rayben',
                'standard' => 'Tingkat kegelapan kaca film sesuai standar keselamatan',
                'category' => 'body',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 9,
                'uraian' => 'Kaca film maksimal 40% dan bukan rayben'
            ],
            [
                'item_number' => 10,
                'item_name' => 'Kaca depan (kiri-kanan-belakang)',
                'standard' => 'Tidak pecah dan pandangan jelas',
                'category' => 'body',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 10,
                'uraian' => 'Kaca depan (kiri-kanan-belakang)'
            ],
            [
                'item_number' => 11,
                'item_name' => 'Kaca spion (kiri-tengah-kanan)',
                'standard' => 'Lengkap dan berfungsi normal',
                'category' => 'body',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 11,
                'uraian' => 'Kaca spion (kiri-tengah-kanan)'
            ],
            [
                'item_number' => 12,
                'item_name' => 'Wipper (penghapus kaca)',
                'standard' => 'Karet wiper bagus dan motor berfungsi',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 12,
                'uraian' => 'Wipper (penghapus kaca)'
            ],
            [
                'item_number' => 13,
                'item_name' => 'Lampu depan besar (kiri/kanan)',
                'standard' => 'Menyala terang (jauh/dekat)',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 13,
                'uraian' => 'Lampu depan besar (kiri/kanan)'
            ],
            [
                'item_number' => 14,
                'item_name' => 'Lampu depan kecil (kiri/kanan)',
                'standard' => 'Menyala normal',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 14,
                'uraian' => 'Lampu depan kecil (kiri/kanan)'
            ],
            [
                'item_number' => 15,
                'item_name' => 'Lampu sein/rating depan (kiri/kanan)',
                'standard' => 'Menyala dan berkedip normal',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 15,
                'uraian' => 'Lampu sein/rating depan (kiri/kanan)'
            ],
            [
                'item_number' => 16,
                'item_name' => 'Lampu sein/rating belakang (kiri/kanan)',
                'standard' => 'Menyala dan berkedip normal',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 16,
                'uraian' => 'Lampu sein/rating belakang (kiri/kanan)'
            ],
            [
                'item_number' => 17,
                'item_name' => 'Lampu hazard depan (kiri/kanan)',
                'standard' => 'Menyala bersamaan',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 17,
                'uraian' => 'Lampu hazard depan (kiri/kanan)'
            ],
            [
                'item_number' => 18,
                'item_name' => 'Lampu hazard belakang (kiri/kanan)',
                'standard' => 'Menyala bersamaan',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 18,
                'uraian' => 'Lampu hazard belakang (kiri/kanan)'
            ],
            [
                'item_number' => 19,
                'item_name' => 'Lampu kotak belakang (kiri/kanan)',
                'standard' => 'Menyala normal',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 19,
                'uraian' => 'Lampu kotak belakang (kiri/kanan)'
            ],
            [
                'item_number' => 20,
                'item_name' => 'Lampu rem (kiri/kanan)',
                'standard' => 'Menyala saat pedal rem diinjak',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 20,
                'uraian' => 'Lampu rem (kiri/kanan)'
            ],
            [
                'item_number' => 21,
                'item_name' => 'Ban & Ban Serep',
                'standard' => 'Kondisi kembang ban masih tebal dan tekanan angin cukup',
                'category' => 'kaki_kaki',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 21,
                'uraian' => 'Ban & Ban Serep'
            ],
            [
                'item_number' => 22,
                'item_name' => 'Pelag & Baut-baut',
                'standard' => 'Tidak retak dan baut lengkap',
                'category' => 'kaki_kaki',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 22,
                'uraian' => 'Pelag & Baut-baut'
            ],
            [
                'item_number' => 23,
                'item_name' => 'Lampu mundur/parkir',
                'standard' => 'Menyala saat gigi mundur',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 23,
                'uraian' => 'Lampu mundur/parkir'
            ],
            [
                'item_number' => 24,
                'item_name' => 'Lamp plat motor',
                'standard' => 'Menyala menerangi plat nomor',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 24,
                'uraian' => 'Lamp plat motor'
            ],
            [
                'item_number' => 25,
                'item_name' => 'Stir (tie-rod) kemudi',
                'standard' => 'Tidak oblak dan responsif',
                'category' => 'mesin',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 25,
                'uraian' => 'Stir (tie-rod) kemudi'
            ],
            [
                'item_number' => 26,
                'item_name' => 'Body Kendaraan',
                'standard' => 'Tidak keropos parah dan cat rapi',
                'category' => 'body',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 26,
                'uraian' => 'Body Kendaraan'
            ],
            [
                'item_number' => 27,
                'item_name' => 'Lampu rotari ken besar/truck',
                'standard' => 'Menyala dan berputar (khusus kendaraan besar)',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik','tidak_ada']),
                'is_active' => 1,
                'urutan' => 27,
                'uraian' => 'Lampu rotari ken besar/truck'
            ],
            [
                'item_number' => 28,
                'item_name' => 'Alarm mundur ken besar/truck/bus',
                'standard' => 'Berbunyi saat mundur',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik','tidak_ada']),
                'is_active' => 1,
                'urutan' => 28,
                'uraian' => 'Alarm mundur ken besar/truck/bus'
            ],
            [
                'item_number' => 29,
                'item_name' => 'Start-on',
                'standard' => 'Mesin mudah dinyalakan',
                'category' => 'mesin',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 29,
                'uraian' => 'Start-on'
            ],
            [
                'item_number' => 30,
                'item_name' => 'Mesin/Panbel/Radiator',
                'standard' => 'Suara mesin halus, panbel tidak retak, radiator tidak bocor',
                'category' => 'mesin',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 30,
                'uraian' => 'Mesin/Panbel/Radiator'
            ],
            [
                'item_number' => 31,
                'item_name' => 'Battery accu',
                'standard' => 'Tegangan normal, terminal bersih',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 31,
                'uraian' => 'Battery accu'
            ],
            [
                'item_number' => 32,
                'item_name' => 'Spedometer',
                'standard' => 'Jarum penunjuk kecepatan dan odometer berfungsi',
                'category' => 'interior',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 32,
                'uraian' => 'Spedometer'
            ],
            [
                'item_number' => 33,
                'item_name' => 'Indikator panas dan bahan bakar',
                'standard' => 'Berfungsi akurat',
                'category' => 'interior',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 33,
                'uraian' => 'Indikator panas dan bahan bakar'
            ],
            [
                'item_number' => 34,
                'item_name' => 'Gas',
                'standard' => 'Responsif dan kembali ke posisi idle dengan baik',
                'category' => 'mesin',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 34,
                'uraian' => 'Gas'
            ],
            [
                'item_number' => 35,
                'item_name' => 'Knolpot tidak bocor & bukan racing',
                'standard' => 'Suara standar pabrik dan emisi normal',
                'category' => 'mesin',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 35,
                'uraian' => 'Knolpot tidak bocor & bukan racing'
            ],
            [
                'item_number' => 36,
                'item_name' => 'Coupling',
                'standard' => 'Tidak selip dan perpindahan gigi halus',
                'category' => 'mesin',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 36,
                'uraian' => 'Coupling'
            ],
            [
                'item_number' => 37,
                'item_name' => 'Perseneling',
                'standard' => 'Perpindahan gigi lancar',
                'category' => 'mesin',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 37,
                'uraian' => 'Perseneling'
            ],
            [
                'item_number' => 38,
                'item_name' => 'Klakson',
                'standard' => 'Berbunyi nyaring',
                'category' => 'kelistrikan',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 38,
                'uraian' => 'Klakson'
            ],
            [
                'item_number' => 39,
                'item_name' => 'Jok/tempat duduk',
                'standard' => 'Kondisi baik dan kokoh',
                'category' => 'interior',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 39,
                'uraian' => 'Jok/tempat duduk'
            ],
            [
                'item_number' => 40,
                'item_name' => 'Safety belt',
                'standard' => 'Tersedia dan berfungsi mengunci',
                'category' => 'interior',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 40,
                'uraian' => 'Safety belt'
            ],
            [
                'item_number' => 41,
                'item_name' => 'Rem (brake)',
                'standard' => 'Pakem dan tidak bocor',
                'category' => 'kaki_kaki',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 41,
                'uraian' => 'Rem (brake)'
            ],
            [
                'item_number' => 42,
                'item_name' => 'Hand brake',
                'standard' => 'Mampu menahan kendaraan di tanjakan',
                'category' => 'kaki_kaki',
                'field_type' => 'radio',
                'options' => json_encode(['baik','tidak_baik']),
                'is_active' => 1,
                'urutan' => 42,
                'uraian' => 'Hand brake'
            ],
        ];

        foreach ($items as $item) {
            DB::table('checkup_items')->updateOrInsert(
                ['item_number' => $item['item_number']],
                [
                    'item_name' => $item['item_name'],
                    'standard' => $item['standard'],
                    'category' => $item['category'],
                    'field_type' => $item['field_type'],
                    'options' => $item['options'],
                    'is_active' => $item['is_active'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
