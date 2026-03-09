<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Simper\SimperDocument;
use App\Models\Ujsimp\UjsimpTest;
use App\Models\Checkup\CheckupDocument;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Checkup\CheckupItem;

class ExamScenarioSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSimperNotes();
        $this->seedUjsimpScores();
        $this->seedCheckupResults();
        $this->seedRanmorFindings();
    }

    private function seedSimperNotes()
    {
        $documents = SimperDocument::all();

        foreach ($documents as $doc) {
            // Check if notes already exist to avoid duplicates
            if (DB::table('simper_notes')->where('simper_document_id', $doc->id)->exists()) {
                continue;
            }

            $notes = [
                [
                    'no_urut' => 1,
                    'uraian' => 'Pengemudi memahami prosedur keselamatan.',
                ],
                [
                    'no_urut' => 2,
                    'uraian' => 'Pengemudi mampu mengoperasikan kendaraan dengan baik.',
                ],
            ];

            foreach ($notes as $note) {
                DB::table('simper_notes')->insert([
                    'simper_document_id' => $doc->id,
                    'no_urut' => $note['no_urut'],
                    'uraian' => $note['uraian'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedUjsimpScores()
    {
        $tests = UjsimpTest::all();
        // Use DB table directly as UjsimpMasterItem model might not exist or be in a different namespace
        // The table name from migration is 'ujsimp_master_items'
        $items = DB::table('ujsimp_master_items')->get();

        if ($items->isEmpty()) {
            return;
        }

        foreach ($tests as $test) {
            // Check if scores already exist
            if (DB::table('ujsimp_scores')->where('ujsimp_test_id', $test->id)->exists()) {
                continue;
            }

            foreach ($items as $item) {
                $nilaiAngka = rand(60, 100);
                $nilaiHuruf = 'K'; // Default
                if ($nilaiAngka >= 85) {
                    $nilaiHuruf = 'B';
                } elseif ($nilaiAngka >= 70) {
                    $nilaiHuruf = 'S';
                }

                DB::table('ujsimp_scores')->insert([
                    'ujsimp_test_id' => $test->id,
                    'ujsimp_item_id' => $item->id, // Assuming scores link to master items or ujsimp_items?
                    // The prompt says "ujsimp_item_id". But UjsimpTest might link to UjsimpItem or UjsimpMasterItem.
                    // Let's assume ujsimp_scores table has ujsimp_item_id column.
                    'nilai_angka' => $nilaiAngka,
                    'nilai_huruf' => $nilaiHuruf,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedCheckupResults()
    {
        $documents = CheckupDocument::all();
        $items = CheckupItem::all();

        if ($items->isEmpty()) {
            return;
        }

        foreach ($documents as $doc) {
            // Check if results already exist
            if ($doc->results()->count() > 0) {
                continue;
            }

            foreach ($items as $item) {
                $hasilOptions = ['baik', 'tidak_baik', 'tidak_ada'];
                $hasil = $hasilOptions[array_rand($hasilOptions)];
                $tindakan = null;

                if ($hasil === 'tidak_baik') {
                    $tindakan = 'Perlu perbaikan';
                }

                DB::table('checkup_results')->insert([
                    'checkup_document_id' => $doc->id,
                    'checkup_item_id' => $item->id,
                    'hasil' => $hasil,
                    'tindakan_perbaikan' => $tindakan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedRanmorFindings()
    {
        $documents = RanmorDocument::all();
        $findings = [
            'Pemeriksaan lampu depan',
            'Kondisi ban perlu diperhatikan',
            'Rem parkir perlu penyesuaian',
            'Kaca spion retak',
            'Klakson tidak berfungsi optimal',
        ];

        foreach ($documents as $doc) {
            // Check if findings already exist
            if ($doc->findings()->count() > 0) {
                continue;
            }

            $count = rand(1, 3);
            $selectedFindings = array_rand(array_flip($findings), $count);
            if (!is_array($selectedFindings)) {
                $selectedFindings = [$selectedFindings];
            }

            foreach ($selectedFindings as $uraian) {
                DB::table('ranmor_findings')->insert([
                    'ranmor_document_id' => $doc->id,
                    'uraian' => $uraian,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
