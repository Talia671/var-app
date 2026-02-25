<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujsimp\UjsimpItem;

class UjsimpItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [

            /*
            |--------------------------------------------------------------------------
            | 12 TEST TEKNIK MENGEMUDI
            |--------------------------------------------------------------------------
            */

            [
                'kategori' => 'teknik',
                'urutan' => 1,
                'uraian' => 'Melakukan pemeriksaan terhadap kondisi kendaraan, surat surat perlengkapan lainnya sebelum mengemudikan kendaraan'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 2,
                'uraian' => 'Melakukan pemanasan mesin sebelum menjalankan kendaraan'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 3,
                'uraian' => 'Pada posisi berhenti lurus, bergerak maju belok kanan masuk terusan'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 4,
                'uraian' => 'Setelah berhenti bergerak mundur belok kanan masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 5,
                'uraian' => 'Setelah berhenti bergerak maju belok kiri masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 6,
                'uraian' => 'Setelah berhenti bergerak mundur lurus masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 7,
                'uraian' => 'Setelah berhenti bergerak maju belok kiri lurus masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 8,
                'uraian' => 'Setelah berhenti bergerak mundur belok kanan lurus masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 9,
                'uraian' => 'Setelah berhenti bergerak maju belok kanan lurus masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 10,
                'uraian' => 'Setelah berhenti bergerak mundur belok kiri lurus masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 11,
                'uraian' => 'Setelah berhenti bergerak maju lurus masuk terusan stop'
            ],
            [
                'kategori' => 'teknik',
                'urutan' => 12,
                'uraian' => 'Setelah berhenti bergerak mundur belok kiri lurus masuk terusan stop'
            ],


            /*
            |--------------------------------------------------------------------------
            | 20 TEST TERHADAP PENGUASAAN KENDARAAN DAN RAMBU-RAMBU LALU LINTAS
            |--------------------------------------------------------------------------
            */

            [
                'kategori' => 'rambu',
                'urutan' => 13,
                'uraian' => 'Cara mengemudikan kemudi (stir)'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 14,
                'uraian' => 'Cara menggunakan gigi persneling mulai dari rendah ke tinggi & sebaliknya'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 15,
                'uraian' => 'Cara menggunakan gas'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 16,
                'uraian' => 'Cara menggunakan kopling'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 17,
                'uraian' => 'Cara menggunakan rem kaki'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 18,
                'uraian' => 'Cara menggunakan klakson'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 19,
                'uraian' => 'Cara menggunakan kaca spion'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 20,
                'uraian' => 'Cara menggunakan lampu (ritting / sein)'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 21,
                'uraian' => 'Berjalan dengan sempurna mulai dari awal hingga ke jalan raya'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 22,
                'uraian' => 'Berjalan dengan kecepatan max 40 km/jam di area plant site'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 23,
                'uraian' => 'Berjalan dengan tenang di tempat keramaian / tidak menggunakan hp saat mengemudikan kendaraan'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 24,
                'uraian' => 'Mendahului kendaraan (menyalip) dengan aman & tidak melanggar peraturan'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 25,
                'uraian' => 'Memberhentikan kendaraan dengan mendadak sesuai dengan keperluan yang berlaku tanpa menghindari gangguan mesin mati, tabrakan dll'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 26,
                'uraian' => 'Berhenti pada tanjakan, lalu bergerak maju tanpa mesin mati serta tidak bergerak mundur'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 27,
                'uraian' => 'Mengikuti kendaraan di depan dengan memperhatikan jarak yang telah di tentukan sesuai dengan kecepatan'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 28,
                'uraian' => 'Dapat menguasai kendaraan pada posisi di tikungan, belokan dll'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 29,
                'uraian' => 'Tidak berhenti pada tempat dilarang berhenti'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 30,
                'uraian' => 'Tidak parkir pada tempat dilarang parkir'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 31,
                'uraian' => 'Mematuhi terhadap keselamatan dan rambu-rambu lalu lintas'
            ],
            [
                'kategori' => 'rambu',
                'urutan' => 32,
                'uraian' => 'Parkir mundur pada tempat yang telah di tentukan'
            ],

        ];

        foreach ($items as $item) {
            UjsimpItem::create($item);
        }
    }
}