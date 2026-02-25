<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Checkup\CheckupDocument;
use App\Models\Checkup\CheckupItem;
use App\Models\Checkup\CheckupResult;
use App\Models\Checkup\CheckupPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckupController extends Controller
{
    public function preview($id)
    {
        $document = CheckupDocument::with(['results.item','photos','creator','approver'])
            ->where('id',$id)
            ->where('workflow_status','approved')
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.checkup.pdf', compact('document'))
            ->setPaper('a4','portrait');

        return $pdf->stream('checkup-preview.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX (RIWAYAT PETUGAS)
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $documents = CheckupDocument::where('created_by', Auth::id())
            ->latest()
            ->paginate(10);

        return view('petugas.checkup.index', compact('documents'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $items = CheckupItem::orderBy('urutan')->get();

        return view('petugas.checkup.create', compact('items'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (SAVE DRAFT)
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengemudi' => 'required',
            'npk' => 'required',
            'no_pol' => 'required',
            'perusahaan' => 'required',
            'jenis_kendaraan' => 'required',
            'tanggal_pemeriksaan' => 'required|date',
        ]);

        $document = CheckupDocument::create([
            'nama_pengemudi' => $request->nama_pengemudi,
            'npk' => $request->npk,
            'nomor_sim' => $request->nomor_sim,
            'nomor_simper' => $request->nomor_simper,
            'masa_berlaku' => $request->masa_berlaku,
            'no_pol' => $request->no_pol,
            'no_lambung' => $request->no_lambung,
            'perusahaan' => $request->perusahaan,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'rekomendasi' => $request->rekomendasi,
            'zona' => $request->zona,
            'created_by' => Auth::id(),
        ]);

        // Simpan checklist
        foreach ($request->hasil as $itemId => $hasil) {
            CheckupResult::create([
                'checkup_document_id' => $document->id,
                'checkup_item_id' => $itemId,
                'hasil' => $hasil,
                'tindakan_perbaikan' => $request->tindakan[$itemId] ?? null,
            ]);
        }

        // Upload foto
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('checkup', 'public');

                CheckupPhoto::create([
                    'checkup_document_id' => $document->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('petugas.checkup.index')
            ->with('success', 'CheckUp berhasil disimpan sebagai draft.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $document = CheckupDocument::with(['results.item','photos'])
            ->where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        return view('petugas.checkup.show', compact('document'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $document = CheckupDocument::with('results')
            ->where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (!$document->canBeEdited()) {
            return back()->with('error','Dokumen tidak dapat diedit.');
        }

        $items = CheckupItem::orderBy('urutan')->get();

        return view('petugas.checkup.edit', compact('document','items'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $document = CheckupDocument::where('id',$id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (!$document->canBeEdited()) {
            return back()->with('error','Dokumen tidak dapat diedit.');
        }

        $document->update($request->only([
            'nama_pengemudi',
            'npk',
            'nomor_sim',
            'nomor_simper',
            'masa_berlaku',
            'no_pol',
            'no_lambung',
            'perusahaan',
            'jenis_kendaraan',
            'tanggal_pemeriksaan',
            'rekomendasi',
            'zona',
        ]));

        // Update checklist
        foreach ($request->hasil as $itemId => $hasil) {
            CheckupResult::where('checkup_document_id',$document->id)
                ->where('checkup_item_id',$itemId)
                ->update([
                    'hasil'=>$hasil,
                    'tindakan_perbaikan'=>$request->tindakan[$itemId] ?? null
                ]);
        }

        return redirect()->route('petugas.checkup.show',$document->id)
            ->with('success','Dokumen berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    public function submit($id)
    {
        $document = CheckupDocument::where('id',$id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (!$document->isDraft() && !$document->isRejected()) {
            return back()->with('error','Status tidak valid untuk submit.');
        }

        $document->update([
            'workflow_status' => 'submitted'
        ]);

        return back()->with('success','Dokumen berhasil disubmit.');
    }
}