<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Simper\SimperDocument;

class SimperSeeder extends Seeder
{
    public function run(): void
    {
        $petugasIds = \App\Models\User::where('role', 'petugas')->pluck('id')->toArray();
        $adminId = \App\Models\User::where('role', 'admin')->first()->id;

        $viewers = [
            ['nama' => 'Budi', 'npk' => 'PKT001'],
            ['nama' => 'Andi', 'npk' => 'PKT002'],
        ];

        $statuses = ['draft', 'submitted', 'approved', 'rejected'];

        // 1. Create 2 data per viewer (total 4)
        foreach ($viewers as $viewer) {
            for ($i = 0; $i < 2; $i++) {
                $status = $statuses[array_rand($statuses)];
                $this->createAssessment($viewer['nama'], $viewer['npk'], $status, $petugasIds[array_rand($petugasIds)], $adminId);
            }
        }

        // 2. Create 15 random data for admin/petugas
        for ($i = 1; $i <= 15; $i++) {
            $nama = 'Karyawan ' . $i;
            $npk = 'PKT' . str_pad($i + 100, 3, '0', STR_PAD_LEFT);
            $status = $statuses[array_rand($statuses)];
            $this->createAssessment($nama, $npk, $status, $petugasIds[array_rand($petugasIds)], $adminId);
        }
    }

    private function createAssessment($nama, $npk, $workflowStatus, $petugasId, $adminId)
    {
        $assessment = SimperDocument::create([
            'template_id' => 1,
            'petugas_id' => $petugasId,
            'zona' => 'zona_1',
            'nama' => $nama,
            'npk' => $npk,
            'perusahaan' => 'PT Pupuk Kaltim',
            'jenis_simper' => 'A',
            'jenis_kendaraan' => 'Dump Truck',
            'nomor_sim' => 'SIM' . rand(10000, 99999),
            'jenis_sim' => 'B2',
            'tanggal_uji' => now()->subDays(rand(0, 60)),
            'penguji_nama' => 'Ahmad Penguji',
            'catatan_umum' => 'Catatan umum untuk ' . $nama,
            'workflow_status' => $workflowStatus,
            'status' => $workflowStatus === 'approved' ? 'approved' : ($workflowStatus === 'rejected' ? 'rejected' : 'pending'),
            'approved_by' => $workflowStatus === 'approved' ? $adminId : null,
            'approved_at' => $workflowStatus === 'approved' ? now()->subDays(rand(0, 60)) : null,
            'created_at' => now()->subDays(rand(0, 60)),
            'updated_at' => now(),
            'is_locked' => $workflowStatus === 'approved',
        ]);

        $assessment->notes()->createMany([
            ['no_urut' => 1, 'uraian' => 'Catatan 1 untuk ' . $nama],
            ['no_urut' => 2, 'uraian' => 'Catatan 2 untuk ' . $nama],
        ]);
    }
}
