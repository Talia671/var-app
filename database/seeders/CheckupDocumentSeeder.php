<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Checkup\CheckupDocument;
use App\Models\Checkup\CheckupItem;
use App\Models\Checkup\CheckupResult;
use App\Models\User;

class CheckupDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $petugasIds = User::where('role', 'petugas')->pluck('id')->toArray();
        $adminId = User::where('role', 'admin')->first()->id;
        $items = CheckupItem::all();
        $statuses = ['draft', 'submitted', 'approved', 'rejected'];

        $viewers = [
            ['nama' => 'Budi', 'npk' => 'PKT001'],
            ['nama' => 'Andi', 'npk' => 'PKT002'],
        ];

        // 1. Create 2 data per viewer
        foreach ($viewers as $viewer) {
            for ($i = 0; $i < 2; $i++) {
                $status = $statuses[array_rand($statuses)];
                $this->createDocument($viewer['nama'], $viewer['npk'], $status, $petugasIds[array_rand($petugasIds)], $adminId, $items);
            }
        }

        // 2. Create 15 random data
        for ($i = 1; $i <= 15; $i++) {
            $nama = 'Karyawan ' . $i;
            $npk = 'PKT' . str_pad($i + 100, 3, '0', STR_PAD_LEFT);
            $status = $statuses[array_rand($statuses)];
            $this->createDocument($nama, $npk, $status, $petugasIds[array_rand($petugasIds)], $adminId, $items);
        }
    }

    private function createDocument($nama, $npk, $workflowStatus, $petugasId, $adminId, $items)
    {
        $doc = CheckupDocument::create([
            'nama_pengemudi' => $nama,
            'npk' => $npk,
            'nomor_sim' => 'SIM' . rand(10000, 99999),
            'perusahaan' => 'PT Pupuk Kaltim',
            'jenis_kendaraan' => 'LV',
            'tanggal_pemeriksaan' => now()->subDays(rand(0, 60)),
            'no_pol' => 'KT ' . rand(1000, 9999) . ' ABC',
            'no_lambung' => 'L-' . rand(100, 999),
            'zona' => 'zona1',
            'workflow_status' => $workflowStatus,
            'created_by' => $petugasId,
            'approved_by' => $workflowStatus === 'approved' ? $adminId : null,
            'approved_at' => $workflowStatus === 'approved' ? now()->subDays(rand(0, 60)) : null,
            'created_at' => now()->subDays(rand(0, 60)),
            'updated_at' => now(),
            'is_locked' => $workflowStatus === 'approved',
        ]);

        foreach ($items as $item) {
            $status = rand(1, 10);
            $hasil = 'Baik';
            if ($status > 8) $hasil = 'Rusak';
            else if ($status > 9) $hasil = 'Tidak Ada';

            CheckupResult::create([
                'checkup_document_id' => $doc->id,
                'checkup_item_id' => $item->id,
                'hasil' => $hasil,
                'tindakan_perbaikan' => $hasil === 'Rusak' ? 'Perbaikan diperlukan' : null,
            ]);
        }
    }
}
