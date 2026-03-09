<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ujsimp\UjsimpScore;
use App\Models\Ujsimp\UjsimpTest;
use App\Services\CooldownService;
use App\Services\ExamDuplicateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjsimpController extends Controller
{
    public function index()
    {
        $tests = UjsimpTest::where('petugas_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('petugas.ujsimp.index', compact('tests'));
    }

    public function create(CooldownService $cooldownService)
    {
        // Cooldown check
        if ($retryAt = $cooldownService->checkUserCooldown(Auth::id(), 'ujsimp')) {
            $date = $retryAt->format('d M Y H:i');

            return redirect()
                ->route('petugas.ujsimp.index')
                ->with('error', "Anda sedang dalam masa pending. Silakan coba kembali setelah $date.");
        }

        // Fetch from database to ensure sync with Super Admin
        $dbItems = \App\Models\Ujsimp\UjsimpItem::orderBy('urutan')->get();
        
        $items = $dbItems->groupBy('kategori')->map(function ($group, $kategori) {
            return [
                'kategori' => $kategori,
                'data' => $group->pluck('uraian', 'id')->toArray()
            ];
        })->values()->toArray();

        return view('petugas.ujsimp.create', compact('items'));
    }

    public function store(Request $request, CooldownService $cooldownService, ExamDuplicateService $examDuplicateService)
    {
        // Cooldown check
        if ($retryAt = $cooldownService->checkUserCooldown(Auth::id(), 'ujsimp')) {
            $date = $retryAt->format('d M Y H:i');

            return redirect()
                ->route('petugas.ujsimp.index')
                ->with('error', "Anda sedang dalam masa pending. Silakan coba kembali setelah $date.");
        }

        // Security Code Check
        if ($cooldownService->isSuspended($request->security_code)) {
            abort(403, 'Akun ini masih dalam masa suspend');
        }

        // Duplicate Exam Check
        if ($examDuplicateService->checkDuplicate($request->security_code, 'ujsimp')) {
            ActivityLog::log('exam_duplicate_blocked', 'ujsimp', 'Duplicate exam creation blocked for '.$request->security_code);
            return back()->withInput()->with('error', 'User ini sudah memiliki ujian UJSIMP yang masih aktif.');
        }

        $request->validate([
            'security_code' => ['required', 'regex:/^S-PKT-\d{6}$/'],
            'nama' => 'required|string|max:255',
            'npk' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'tanggal_ujian' => 'required|date',
            'nomor_sim' => 'required|string|max:255',
            'jenis_sim' => 'required|string|max:255',
            'jenis_simper' => 'required|string|max:255',
        ]);

        $test = UjsimpTest::create([
            'security_code' => $request->security_code,
            'petugas_id' => Auth::id(),
            'nama' => $request->nama,
            'npk' => $request->npk,
            'perusahaan' => $request->perusahaan,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tanggal_ujian' => $request->tanggal_ujian,
            'nomor_sim' => $request->nomor_sim,
            'jenis_sim' => $request->jenis_sim,
            'jenis_simper' => $request->jenis_simper,
            'catatan_penguji' => $request->catatan_penguji,
            'status' => 'belum_lulus',
            'workflow_status' => 'draft',
        ]);

        $total = 0;
        $count = 0;

        if ($request->nilai) {
            foreach ($request->nilai as $itemId => $nilai) {
                $angka = $nilai['angka'] ?? 0;

                UjsimpScore::create([
                    'ujsimp_test_id' => $test->id,
                    'ujsimp_item_id' => $itemId,
                    'nilai_huruf' => $nilai['huruf'] ?? null,
                    'nilai_angka' => $angka,
                ]);

                $total += $angka;
                $count++;
            }
        }

        $rata = $count > 0 ? $total / $count : 0;
        $status = $rata >= 75 ? 'lulus' : 'belum_lulus';

        $test->update([
            'nilai_total' => $total,
            'nilai_rata_rata' => $rata,
            'status' => $status,
        ]);

        ActivityLog::log('exam_created', 'ujsimp', "Created UJSIMP Test for {$test->nama} (ID: {$test->id})");

        return redirect()
            ->route('petugas.ujsimp.show', $test->id)
            ->with('success', 'Data berhasil disimpan sebagai draft.');
    }

    public function show($id)
    {
        $document = UjsimpTest::with([
            'creator',
            'examiner',
            'verifier',
            'approver'
        ])->findOrFail($id);

        $items = \App\Models\Ujsimp\UjsimpItem::orderBy('urutan')->get();

        $results = UjsimpScore::where('ujsimp_test_id', $document->id)
            ->get()
            ->keyBy('ujsimp_item_id');

        return view('petugas.ujsimp.show', [
            'document' => $document,
            'items' => $items,
            'results' => $results
        ]);
    }

    public function edit($id)
    {
        $test = UjsimpTest::with('scores')->findOrFail($id);

        if (! $test->canBeEdited()) {
            abort(403, 'Dokumen tidak bisa diedit.');
        }

        $items = \App\Models\Ujsimp\UjsimpItem::orderBy('urutan')->get();

        return view('petugas.ujsimp.edit', compact('test', 'items'));
    }

    public function update(Request $request, $id)
    {
        $test = UjsimpTest::findOrFail($id);

        if (! $test->canBeEdited()) {
            abort(403, 'Dokumen tidak bisa diedit.');
        }

        $test->update($request->all());

        // Update Scores
        if ($request->nilai) {
            $total = 0;
            $count = 0;
            
            // Clear existing scores
            $test->scores()->delete();

            foreach ($request->nilai as $itemId => $nilai) {
                $angka = $nilai['angka'] ?? 0;

                UjsimpScore::create([
                    'ujsimp_test_id' => $test->id,
                    'ujsimp_item_id' => $itemId,
                    'nilai_huruf' => $nilai['huruf'] ?? null,
                    'nilai_angka' => $angka,
                ]);

                $total += $angka;
                $count++;
            }

            $rata = $count > 0 ? $total / $count : 0;
            $status = $rata >= 75 ? 'lulus' : 'belum_lulus';

            $test->update([
                'nilai_total' => $total,
                'nilai_rata_rata' => $rata,
                'status' => $status,
            ]);
        }

        ActivityLog::log('update', 'ujsimp', 'Updated UJSIMP Test ID: '.$test->id);

        return redirect()
            ->route('petugas.ujsimp.show', $id)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function submit($id)
    {
        $test = UjsimpTest::findOrFail($id);

        if (! $test->canBeEdited()) {
            abort(403, 'Dokumen tidak bisa disubmit.');
        }

        $test->update(['workflow_status' => 'submitted']);

        ActivityLog::log('exam_submitted', 'ujsimp', "Submitted UJSIMP Test for {$test->nama} (ID: {$test->id})");

        return back()->with('success', 'Data berhasil disubmit.');
    }
}
