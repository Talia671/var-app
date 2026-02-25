<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujsimp\UjsimpTest;
use App\Models\Ujsimp\UjsimpItem;
use App\Models\Ujsimp\UjsimpScore;
use App\Models\User;

class UjsimpTestSeeder extends Seeder
{
    public function run(): void
    {
        $petugasIds = User::where('role', 'petugas')->pluck('id')->toArray();
        $adminId = User::where('role', 'admin')->first()->id;
        $items = UjsimpItem::all();
        $statuses = ['draft', 'submitted', 'approved', 'rejected'];

        $viewers = [
            ['nama' => 'Budi', 'npk' => 'PKT001'],
            ['nama' => 'Andi', 'npk' => 'PKT002'],
        ];

        // 1. Create 2 data per viewer
        foreach ($viewers as $viewer) {
            for ($i = 0; $i < 2; $i++) {
                $status = $statuses[array_rand($statuses)];
                $this->createTest($viewer['nama'], $viewer['npk'], $status, $petugasIds[array_rand($petugasIds)], $adminId, $items);
            }
        }

        // 2. Create 15 random data
        for ($i = 1; $i <= 15; $i++) {
            $nama = 'Karyawan ' . $i;
            $npk = 'PKT' . str_pad($i + 100, 3, '0', STR_PAD_LEFT);
            $status = $statuses[array_rand($statuses)];
            $this->createTest($nama, $npk, $status, $petugasIds[array_rand($petugasIds)], $adminId, $items);
        }
    }

    private function createTest($nama, $npk, $workflowStatus, $petugasId, $adminId, $items)
    {
        $test = UjsimpTest::create([
            'nama' => $nama,
            'npk' => $npk,
            'perusahaan' => 'PT Pupuk Kaltim',
            'jenis_kendaraan' => 'Dump Truck',
            'tanggal_ujian' => now()->subDays(rand(0, 60)),
            'nomor_sim' => 'SIM' . rand(10000, 99999),
            'jenis_sim' => 'B2',
            'jenis_simper' => 'A',
            'workflow_status' => $workflowStatus,
            'approved_by' => $workflowStatus === 'approved' ? $adminId : null,
            'approved_at' => $workflowStatus === 'approved' ? now()->subDays(rand(0, 60)) : null,
            'created_at' => now()->subDays(rand(0, 60)),
            'updated_at' => now(),
            'is_locked' => $workflowStatus === 'approved',
            'status' => 'lulus',
            'nilai_total' => 0,
            'nilai_rata_rata' => 0,
        ]);

        $totalScore = 0;
        foreach ($items as $item) {
            $nilaiAngka = rand(60, 100);
            $nilaiHuruf = $nilaiAngka >= 85 ? 'B' : ($nilaiAngka >= 70 ? 'S' : 'K');
            
            UjsimpScore::create([
                'ujsimp_test_id' => $test->id,
                'ujsimp_item_id' => $item->id,
                'nilai_huruf' => $nilaiHuruf,
                'nilai_angka' => $nilaiAngka,
            ]);
            $totalScore += $nilaiAngka;
        }

        $avg = $totalScore / count($items);
        $test->update([
            'nilai_total' => $totalScore,
            'nilai_rata_rata' => $avg,
            'status' => $avg >= 75 ? 'lulus' : 'belum_lulus',
        ]);
    }
}
