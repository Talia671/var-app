<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Ujsimp\UjsimpTest;
use App\Models\Ujsimp\UjsimpScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjsimpController extends Controller
{
    public function index()
    {
        $tests = UjsimpTest::where('petugas_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        return view('petugas.ujsimp.index', compact('tests'));
    }

    public function create()
    {
        $items = config('ujsimp.items');

        return view('petugas.ujsimp.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'npk'             => 'required|string|max:255',
            'perusahaan'      => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'tanggal_ujian'   => 'required|date',
            'nomor_sim'       => 'required|string|max:255',
            'jenis_sim'       => 'required|string|max:255',
            'jenis_simper'    => 'required|string|max:255',
        ]);

        $test = UjsimpTest::create([
            'petugas_id'      => Auth::id(),
            'nama'            => $request->nama,
            'npk'             => $request->npk,
            'perusahaan'      => $request->perusahaan,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tanggal_ujian'   => $request->tanggal_ujian,
            'nomor_sim'       => $request->nomor_sim,
            'jenis_sim'       => $request->jenis_sim,
            'jenis_simper'    => $request->jenis_simper,
            'status'          => 'belum_lulus',
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
                    'nilai_huruf'    => $nilai['huruf'] ?? null,
                    'nilai_angka'    => $angka,
                ]);

                $total += $angka;
                $count++;
            }
        }

        $rata = $count > 0 ? $total / $count : 0;
        $status = $rata >= 75 ? 'lulus' : 'belum_lulus';

        $test->update([
            'nilai_total'      => $total,
            'nilai_rata_rata'  => $rata,
            'status'           => $status,
        ]);

        return redirect()
            ->route('petugas.ujsimp.show', $test->id)
            ->with('success', 'Dokumen berhasil dibuat.');
    }

    public function show($id)
    {
        $test = UjsimpTest::with('scores')->findOrFail($id);
        return view('petugas.ujsimp.show', compact('test'));
    }

    public function edit($id)
    {
        $test = UjsimpTest::findOrFail($id);

        if (!$test->canBeEdited()) {
            abort(403, 'Dokumen tidak bisa diedit.');
        }

        return view('petugas.ujsimp.edit', compact('test'));
    }

    public function update(Request $request, $id)
    {
        $test = UjsimpTest::findOrFail($id);

        if (!$test->canBeEdited()) {
            abort(403, 'Dokumen tidak bisa diedit.');
        }

        $test->update($request->all());

        return redirect()
            ->route('petugas.ujsimp.show', $id)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function submit($id)
    {
        $test = UjsimpTest::findOrFail($id);

        if (!$test->isDraft() && !$test->isRejected()) {
            return back()->with('error','Dokumen tidak bisa disubmit.');
        }

        $test->update([
            'workflow_status' => 'submitted'
        ]);

        return back()->with('success','Dokumen berhasil dikirim ke Admin.');
    }
}