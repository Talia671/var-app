<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ranmor\RanmorDocument;
use App\Models\Ranmor\RanmorFinding;

class RanmorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX - Riwayat Petugas
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = RanmorDocument::where('created_by', Auth::id());

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pol', 'like', "%{$search}%")
                  ->orWhere('pengemudi', 'like', "%{$search}%")
                  ->orWhere('npk', 'like', "%{$search}%");
            });
        }

        // Filter Zona
        if ($request->filled('zona')) {
            $query->where('zona', $request->zona);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('workflow_status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $documents = $query->paginate(10)->withQueryString();

        return view('petugas.ranmor.index', compact('documents'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('petugas.ranmor.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (Draft)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'zona' => 'required|in:zona1,zona2',
            'no_pol' => 'required',
            'no_lambung' => 'required',
            'tanggal_periksa' => 'required|date',
            'npk' => 'required',
            'pengemudi' => 'required',
        ]);

        $document = RanmorDocument::create([
            'zona' => $request->zona,
            'no_pol' => $request->no_pol,
            'no_lambung' => $request->no_lambung,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'warna' => $request->warna,
            'perusahaan' => $request->perusahaan,
            'merk_kendaraan' => $request->merk_kendaraan,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'no_rangka' => $request->no_rangka,
            'no_mesin' => $request->no_mesin,
            'status_kepemilikan' => $request->status_kepemilikan,
            'pengemudi' => $request->pengemudi,
            'npk' => $request->npk,
            'nomor_sim' => $request->nomor_sim,
            'nomor_simper' => $request->nomor_simper,
            'masa_berlaku' => $request->masa_berlaku,
            'tanggal_periksa' => $request->tanggal_periksa,
            'workflow_status' => 'draft',
            'created_by' => Auth::id(),
        ]);

        // Simpan temuan
        if ($request->uraian) {
            foreach ($request->uraian as $uraian) {
                if ($uraian != null) {
                    RanmorFinding::create([
                        'ranmor_document_id' => $document->id,
                        'uraian' => $uraian,
                    ]);
                }
            }
        }

        return redirect()
            ->route('petugas.ranmor.index')
            ->with('success', 'Dokumen berhasil disimpan sebagai Draft.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $document = RanmorDocument::with('findings')
            ->where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        return view('petugas.ranmor.show', compact('document'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $document = RanmorDocument::with('findings')
            ->where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (!in_array($document->workflow_status, ['draft', 'rejected'])) {
            abort(403, 'Dokumen tidak bisa diedit.');
        }

        return view('petugas.ranmor.edit', compact('document'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $document = RanmorDocument::where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (!in_array($document->workflow_status, ['draft', 'rejected'])) {
            abort(403, 'Dokumen tidak bisa diedit.');
        }

        $document->update([
            'zona' => $request->zona,
            'no_pol' => $request->no_pol,
            'no_lambung' => $request->no_lambung,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'warna' => $request->warna,
            'perusahaan' => $request->perusahaan,
            'merk_kendaraan' => $request->merk_kendaraan,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'no_rangka' => $request->no_rangka,
            'no_mesin' => $request->no_mesin,
            'status_kepemilikan' => $request->status_kepemilikan,
            'pengemudi' => $request->pengemudi,
            'npk' => $request->npk,
            'nomor_sim' => $request->nomor_sim,
            'nomor_simper' => $request->nomor_simper,
            'masa_berlaku' => $request->masa_berlaku,
            'tanggal_periksa' => $request->tanggal_periksa,
        ]);

        // Hapus temuan lama
        $document->findings()->delete();

        // Simpan ulang temuan
        if ($request->uraian) {
            foreach ($request->uraian as $uraian) {
                if ($uraian != null) {
                    RanmorFinding::create([
                        'ranmor_document_id' => $document->id,
                        'uraian' => $uraian,
                    ]);
                }
            }
        }

        return redirect()
            ->route('petugas.ranmor.show', $document->id)
            ->with('success', 'Draft berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */
    public function submit($id)
    {
        $document = RanmorDocument::where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (!in_array($document->workflow_status, ['draft', 'rejected'])) {
            return back()->with('error', 'Dokumen tidak bisa disubmit.');
        }

        $document->update([
            'workflow_status' => 'submitted'
        ]);

        return redirect()
            ->route('petugas.ranmor.show', $id)
            ->with('success', 'Dokumen berhasil dikirim ke Admin.');
    }
}