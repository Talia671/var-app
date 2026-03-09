<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ExamSeeder extends Seeder
{
    private $checkers;
    private $admins;
    private $avps;
    private $viewers;

    public function run(): void
    {
        $this->checkers = User::where('role', 'checker_lapangan')->get();
        $this->admins = User::where('role', 'admin_perijinan')->get();
        $this->avps = User::where('role', 'avp')->get();
        $this->viewers = User::where('role', 'viewer')->get();

        if ($this->checkers->isEmpty() || $this->admins->isEmpty() || $this->avps->isEmpty() || $this->viewers->isEmpty()) {
            return;
        }

        $this->seedSimper();
        $this->seedUjsimp();
        $this->seedCheckup();
        $this->seedRanmor();
    }

    private function seedSimper()
    {
        for ($i = 0; $i < 20; $i++) {
            $viewer = $this->viewers->random();
            $checker = $this->checkers->random();
            
            [$status, $createdAt, $verifiedAt, $approvedAt, $rejectedAt] = $this->generateWorkflowTimestamps();

            $data = [
                'template_id' => 1, // Assuming default template ID 1
                'petugas_id' => $checker->id,
                'nama' => $viewer->name,
                'npk' => $viewer->npk ?? 'PKT' . rand(1000, 9999),
                'perusahaan' => $viewer->department ?? 'PT Pupuk Kaltim',
                'jenis_simper' => 'A',
                'jenis_kendaraan' => 'Light Vehicle',
                'nomor_sim' => 'SIM-' . rand(100000, 999999),
                'jenis_sim' => 'A',
                'tanggal_uji' => $createdAt->toDateString(),
                'workflow_status' => $status,
                'zona' => 'zona_1',
                'penguji_nama' => $checker->name,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];

            // Use table name 'simper_documents' (renamed from 'assessments')
            $this->addWorkflowFields($data, $status, $verifiedAt, $approvedAt, $rejectedAt, 'simper_documents');

            DB::table('simper_documents')->insert($data);
        }
    }

    private function seedUjsimp()
    {
        for ($i = 0; $i < 20; $i++) {
            $viewer = $this->viewers->random();
            
            [$status, $createdAt, $verifiedAt, $approvedAt, $rejectedAt] = $this->generateWorkflowTimestamps();

            $data = [
                'nama' => $viewer->name,
                'npk' => $viewer->npk ?? 'PKT' . rand(1000, 9999),
                'perusahaan' => $viewer->department ?? 'PT Pupuk Kaltim',
                'jenis_kendaraan' => 'Light Vehicle',
                'tanggal_ujian' => $createdAt->toDateString(),
                'nomor_sim' => 'SIM-' . rand(100000, 999999),
                'jenis_sim' => 'A',
                'jenis_simper' => 'A',
                'workflow_status' => $status,
                'status' => 'belum_lulus', // Default
                // 'petugas_id' => $this->checkers->random()->id, // Removed as per schema check, it might not exist or wasn't requested in prompt for UJSIMP
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];
            
            // Check if petugas_id exists in ujsimp_tests (added in 2026_02_24_070549_add_petugas_id_to_ujsimp_tests_table.php)
            if (Schema::hasColumn('ujsimp_tests', 'petugas_id')) {
                $data['petugas_id'] = $this->checkers->random()->id;
            }

            $this->addWorkflowFields($data, $status, $verifiedAt, $approvedAt, $rejectedAt, 'ujsimp_tests');

            DB::table('ujsimp_tests')->insert($data);
        }
    }

    private function seedCheckup()
    {
        for ($i = 0; $i < 20; $i++) {
            $viewer = $this->viewers->random();
            $checker = $this->checkers->random();
            
            [$status, $createdAt, $verifiedAt, $approvedAt, $rejectedAt] = $this->generateWorkflowTimestamps();

            $data = [
                'nama_pengemudi' => $viewer->name,
                'npk' => $viewer->npk ?? 'PKT' . rand(1000, 9999),
                'perusahaan' => $viewer->department ?? 'PT Pupuk Kaltim',
                'jenis_kendaraan' => 'Light Vehicle',
                'tanggal_pemeriksaan' => $createdAt->toDateString(),
                'no_pol' => 'KT ' . rand(1000, 9999) . ' ABC',
                'zona' => rand(0, 1) ? 'zona1' : 'zona2',
                'workflow_status' => $status,
                'created_by' => $checker->id,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];

            $this->addWorkflowFields($data, $status, $verifiedAt, $approvedAt, $rejectedAt, 'checkup_documents');

            DB::table('checkup_documents')->insert($data);
        }
    }

    private function seedRanmor()
    {
        for ($i = 0; $i < 20; $i++) {
            $viewer = $this->viewers->random();
            $checker = $this->checkers->random();
            
            [$status, $createdAt, $verifiedAt, $approvedAt, $rejectedAt] = $this->generateWorkflowTimestamps();

            $data = [
                'pengemudi' => $viewer->name,
                'perusahaan' => $viewer->department ?? 'PT Pupuk Kaltim',
                'merk_kendaraan' => 'Toyota Hilux',
                'tanggal_periksa' => $createdAt->toDateString(),
                'no_pol' => 'KT ' . rand(1000, 9999) . ' ABC',
                'no_lambung' => 'LB-' . rand(100, 999),
                'zona' => rand(0, 1) ? 'zona1' : 'zona2',
                'workflow_status' => $status,
                'created_by' => $checker->id,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];

            $this->addWorkflowFields($data, $status, $verifiedAt, $approvedAt, $rejectedAt, 'ranmor_documents');

            DB::table('ranmor_documents')->insert($data);
        }
    }

    private function generateWorkflowTimestamps()
    {
        $createdAt = now()->subDays(rand(5, 30));
        $status = Arr::random(['submitted', 'verified', 'approved', 'rejected']);
        
        $verifiedAt = null;
        $approvedAt = null;
        $rejectedAt = null;

        if ($status === 'verified') {
            $verifiedAt = $createdAt->copy()->addDays(rand(1, 2));
        } elseif ($status === 'approved') {
            $verifiedAt = $createdAt->copy()->addDays(rand(1, 2));
            $approvedAt = $verifiedAt->copy()->addDays(rand(1, 2));
        } elseif ($status === 'rejected') {
            // Rejected can happen after submission (by verifier) or after verification (by approver)
            // For simplicity and to follow "submitted -> rejected" in prompt, let's say rejected by verifier/admin
            $rejectedAt = $createdAt->copy()->addDays(rand(1, 2));
            // Prompt says: submitted -> rejected. So no verified_at.
        }

        return [$status, $createdAt, $verifiedAt, $approvedAt, $rejectedAt];
    }

    private function addWorkflowFields(&$data, $status, $verifiedAt, $approvedAt, $rejectedAt, $tableName)
    {
        // Check columns existence to avoid errors
        $hasVerifiedBy = Schema::hasColumn($tableName, 'verified_by');
        $hasVerifiedAt = Schema::hasColumn($tableName, 'verified_at');
        $hasApprovedBy = Schema::hasColumn($tableName, 'approved_by');
        $hasApprovedAt = Schema::hasColumn($tableName, 'approved_at');
        $hasRejectedBy = Schema::hasColumn($tableName, 'rejected_by');
        $hasRejectedAt = Schema::hasColumn($tableName, 'rejected_at');
        $hasIsLocked = Schema::hasColumn($tableName, 'is_locked');

        if ($status === 'verified') {
            if ($hasVerifiedBy) $data['verified_by'] = $this->admins->random()->id;
            if ($hasVerifiedAt) $data['verified_at'] = $verifiedAt;
        } elseif ($status === 'approved') {
            if ($hasVerifiedBy) $data['verified_by'] = $this->admins->random()->id;
            if ($hasVerifiedAt) $data['verified_at'] = $verifiedAt;
            if ($hasApprovedBy) $data['approved_by'] = $this->avps->random()->id;
            if ($hasApprovedAt) $data['approved_at'] = $approvedAt;
            if ($hasIsLocked) $data['is_locked'] = true;
        } elseif ($status === 'rejected') {
            // Rejected logic:
            // If rejected directly from submitted, verified_by/at should be null?
            // Prompt says: "rejected records never have verified_at"
            // So we skip verified fields.
            if ($hasRejectedBy) $data['rejected_by'] = $this->admins->random()->id; // Rejected by Admin
            if ($hasRejectedAt) $data['rejected_at'] = $rejectedAt;
        }
    }
}
