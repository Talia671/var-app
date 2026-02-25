<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Checkup\CheckupItem;

class CheckupItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Lampu Depan (Utama)',
            'Lampu Belakang / Rem',
            'Lampu Sein / Hazard',
            'Rem Tangan / Parkir',
            'Klakson',
            'Wiper / Washer',
            'Kaca Spion',
            'Sabuk Pengaman',
            'Kondisi Ban',
            'Kebocoran Oli/Fluida',
        ];

        foreach ($items as $index => $item) {
            CheckupItem::create([
                'uraian' => $item,
                'urutan' => $index + 1,
            ]);
        }
    }
}
