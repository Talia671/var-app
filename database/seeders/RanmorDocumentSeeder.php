<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Ranmor\RanmorFinding;
use App\Models\User;

class RanmorDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $petugasIds = User::where('role', 'petugas')->pluck('id')->toArray();
        $adminId = User::where('role', 'admin')->first()->id;
        $statuses = ['draft', 'submitted', 'approved', 'rejected'];

        $viewers = [
            ['nama' => 'Budi', 'npk' => 'PKT001'],
            ['nama' => 'Andi', 'npk' => 'PKT002'],
        ];

        // 1. Create 2 data per viewer
        foreach ($viewers as $viewer) {
            for ($i = 0; $i < 2; $i++) {
                $status = $statuses[array_rand($statuses)];
                $this->createDocument($viewer['nama'], $viewer['npk'], $status, $petugasIds[array_rand($petugasIds)], $adminId);
            }
        }

        // 2. Create 15 random data
        for ($i = 1; $i <= 15; $i++) {
            $nama = 'Karyawan ' . $i;
            $npk = 'PKT' . str_pad($i + 100, 3, '0', STR_PAD_LEFT);
            $status = $statuses[array_rand($statuses)];
            $this->createDocument($nama, $npk, $status, $petugasIds[array_rand($petugasIds)], $adminId);
        }
    }

    private function createDocument($nama, $npk, $workflowStatus, $petugasId, $adminId)
    {
        $doc = RanmorDocument::create([
            'pengemudi' => $nama,
            'no_pol' => 'KT ' . rand(1000, 9999) . ' ABC',
            'no_lambung' => 'L-' . rand(100, 999),
            'zona' => 'zona1',
            'perusahaan' => 'PT Pupuk Kaltim',
            'merk_kendaraan' => 'Toyota',
            'tanggal_periksa' => now()->subDays(rand(0, 60)),
            'workflow_status' => $workflowStatus,
            'created_by' => $petugasId,
            'approved_by' => $workflowStatus === 'approved' ? $adminId : null,
            'approved_at' => $workflowStatus === 'approved' ? now()->subDays(rand(0, 60)) : null,
            'created_at' => now()->subDays(rand(0, 60)),
            'updated_at' => now(),
            'is_locked' => $workflowStatus === 'approved',
        ]);

        $findingsCount = rand(1, 3);
        for ($i = 0; $i < $findingsCount; $i++) {
            RanmorFinding::create([
                'ranmor_document_id' => $doc->id,
                'uraian' => 'Temuan random ke-' . ($i + 1) . ' untuk ' . $nama,
            ]);
        }
    }
}
