<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Simper\SimperDocument;

class SimperController extends Controller
{
    public function index()
    {
        $assessments = SimperDocument::where('petugas_id', Auth::id())
                ->latest()
                ->paginate(10);
        return view('petugas.simper.index', compact('assessments'));
    }

    public function show($id)
    {
        $assessment = SimperDocument::with('notes')
            ->where('petugas_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('petugas.simper.show', compact('assessment'));
    }

    public function create()
    {
        return view('petugas.simper.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ VALIDASI
        $request->validate([
            'zona' => 'required',
            'nama' => 'required|string|max:255',
            'npk' => 'required|string|max:100',
            'perusahaan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'nomor_sim' => 'required|string|max:100',
            'jenis_sim' => 'required|string|max:100',
            'jenis_simper' => 'required|string|max:50',
            'tanggal_uji' => 'required|date',
            'notes.*' => 'nullable|string'
        ]);

        // 2️⃣ SIMPAN DATA UTAMA (ASSESSMENT)
        $assessment = SimperDocument::create([
            'template_id' => 1,
            'petugas_id' => Auth::id(),
            'zona' => $request->zona,
            'nama' => $request->nama,
            'npk' => $request->npk,
            'perusahaan' => $request->perusahaan,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'nomor_sim' => $request->nomor_sim,
            'jenis_sim' => $request->jenis_sim,
            'jenis_simper' => $request->jenis_simper,
            'tanggal_uji' => $request->tanggal_uji,
            'penguji_nama' => Auth::user()->name,
            'workflow_status' => 'draft',
            'status' => 'pending'
        ]);

        // 3️⃣ SIMPAN NOTES
        if ($request->has('notes')) {
            foreach ($request->notes as $index => $note) {
                if (!empty($note)) {
                    $assessment->notes()->create([
                        'no_urut' => $index + 1,
                        'uraian' => $note
                    ]);
                }
            }
        }

        // 4️⃣ REDIRECT
        return redirect()
            ->route('petugas.simper.index')
            ->with('success', 'Pengajuan SIMPER berhasil disimpan sebagai draft.');
    }

    public function edit($id)
    {
        $assessment = SimperDocument::where('petugas_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        if (!in_array($assessment->workflow_status, ['draft', 'rejected'])) {
            abort(403, 'Data tidak bisa diedit.');
        }

        return view('petugas.simper.edit', compact('assessment'));
    }
    
    public function update(Request $request, $id)
    {
        $assessment = SimperDocument::where('petugas_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        if (!in_array($assessment->workflow_status, ['draft', 'rejected'])) {
            abort(403, 'Data tidak bisa diedit.');
        }

        $request->validate([
            'zona' => 'required',
            'nama' => 'required|string|max:255',
            'npk' => 'required|string|max:100',
            'perusahaan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'nomor_sim' => 'required|string|max:100',
            'jenis_sim' => 'required|string|max:100',
            'jenis_simper' => 'required|string|max:50',
            'tanggal_uji' => 'required|date',
        ]);

        $assessment->update([
            'zona' => $request->zona,
            'nama' => $request->nama,
            'npk' => $request->npk,
            'perusahaan' => $request->perusahaan,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'nomor_sim' => $request->nomor_sim,
            'jenis_sim' => $request->jenis_sim,
            'jenis_simper' => $request->jenis_simper,
            'tanggal_uji' => $request->tanggal_uji,
        ]);

        return redirect()
            ->route('petugas.simper.show', $assessment->id)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function submit($id)
    {
        $assessment = SimperDocument::where('petugas_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($assessment->workflow_status, ['draft', 'rejected'])) {
            return back()->with('error', 'Dokumen tidak bisa disubmit.');
        }

        $assessment->update([
            'workflow_status' => 'submitted'
        ]);

        return redirect()
            ->route('petugas.simper.index')
            ->with('success', 'Dokumen berhasil dikirim ke Admin.');
    }
}
