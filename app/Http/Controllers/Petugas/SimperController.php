<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Simper\SimperDocument;
use App\Services\CooldownService;
use App\Services\ExamDuplicateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimperController extends Controller
{
    public function index()
    {
        $assessments = SimperDocument::where('petugas_id', Auth::id())
            ->latest()
            ->paginate(15);

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

    public function create(CooldownService $cooldownService)
    {
        // Cooldown check
        if ($retryAt = $cooldownService->checkUserCooldown(Auth::id(), 'simper')) {
            $date = $retryAt->format('d M Y H:i');

            return redirect()
                ->route('petugas.simper.index')
                ->with('error', "Anda sedang dalam masa pending. Silakan coba kembali setelah $date.");
        }

        return view('petugas.simper.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ VALIDASI
        $request->validate([
            'security_code' => ['required', 'regex:/^S-PKT-\d{6}$/'],
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

        // 2️⃣ SIMPAN DATA UTAMA (ASSESSMENT)
        $assessment = SimperDocument::create([
            'security_code' => $request->security_code,
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
            'status' => 'pending',
        ]);

        // 3️⃣ SIMPAN NOTES
        if ($request->has('notes')) {
            foreach ($request->notes as $index => $note) {
                if (! empty($note)) {
                    $assessment->notes()->create([
                        'no_urut' => $index + 1,
                        'description' => $note,
                    ]);
                }
            }
        }

        ActivityLog::log('exam_created', 'simper', "Created Simper exam for security code: {$request->security_code}");

        return redirect()->route('petugas.simper.index')
            ->with('success', 'Data berhasil disimpan (Draft).');
    }

    public function edit($id)
    {
        $assessment = SimperDocument::where('petugas_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (! in_array($assessment->workflow_status, ['draft', 'rejected'])) {
            abort(403, 'Data tidak bisa diedit.');
        }

        return view('petugas.simper.edit', compact('assessment'));
    }

    public function update(Request $request, $id)
    {
        $assessment = SimperDocument::where('petugas_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (! in_array($assessment->workflow_status, ['draft', 'rejected'])) {
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

        if (! in_array($assessment->workflow_status, ['draft', 'rejected'])) {
            return back()->with('error', 'Dokumen tidak bisa disubmit.');
        }

        $assessment->update([
            'workflow_status' => 'submitted',
        ]);

        \App\Models\ActivityLog::log('exam_submitted', 'simper', "Submitted SIMPER for {$assessment->nama} (ID: {$assessment->id})");

        return redirect()
            ->route('petugas.simper.index')
            ->with('success', 'Dokumen berhasil dikirim ke Admin.');
    }
}
