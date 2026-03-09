<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CoreSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCompanies();
        $this->seedZones();
        $this->seedCheckupItems();
        $this->seedUjsimpItems();
        $this->seedAssessmentTemplates();
    }

    private function seedCompanies(): void
    {
        $companies = [
            'PT Pupuk Kaltim',
            'PT Energi Kaltim',
            'PT Bara Nusantara',
            'PT Mineral Indonesia',
            'PT Tambang Sejahtera',
        ];

        foreach ($companies as $company) {
            // Using updateOrInsert to avoid duplicates and ensure idempotency
            DB::table('companies')->updateOrInsert(
                ['name' => $company],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    private function seedZones(): void
    {
        $zones = [
            'Zona 1',
            'Zona 2',
        ];

        foreach ($zones as $zone) {
            DB::table('zones')->updateOrInsert(
                ['name' => $zone],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    private function seedCheckupItems(): void
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
            DB::table('checkup_items')->updateOrInsert(
                ['item_name' => $item],
                [
                    'item_number' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function seedUjsimpItems(): void
    {
        $itemsConfig = config('ujsimp.items');
        
        foreach ($itemsConfig as $category) {
            $kategori = $category['kategori'];
            foreach ($category['data'] as $id => $uraian) {
                DB::table('ujsimp_items')->updateOrInsert(
                    ['id' => $id],
                    [
                        'kategori' => str_contains($kategori, 'teknik') ? 'teknik' : 'rambu',
                        'urutan' => $id,
                        'uraian' => $uraian,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Also seed ujsimp_master_items for Super Admin
                if (Schema::hasTable('ujsimp_master_items')) {
                    DB::table('ujsimp_master_items')->updateOrInsert(
                        ['id' => $id],
                        [
                            'category' => str_contains($kategori, 'teknik') ? 'teknik' : 'rambu',
                            'urutan' => $id,
                            'uraian' => $uraian,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }

    private function seedAssessmentTemplates(): void
    {
        // Table renamed from assessment_templates to simper_templates
        $tableName = 'simper_templates';

        if (!Schema::hasTable($tableName)) {
            return;
        }

        // Check if template with ID 1 exists
        if (DB::table($tableName)->where('id', 1)->exists()) {
            return;
        }

        $data = [
            'id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Only add name if the column exists
        if (Schema::hasColumn($tableName, 'name')) {
            $data['name'] = 'SIMPER Default Assessment';
        }

        DB::table($tableName)->insert($data);
    }
}
