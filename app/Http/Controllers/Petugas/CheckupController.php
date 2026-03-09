<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Checkup\CheckupDocument;
use App\Models\Checkup\CheckupItem;
use App\Models\Checkup\CheckupPhoto;
use App\Models\Checkup\CheckupResult;
use App\Services\CooldownService;
use App\Services\ExamDuplicateService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Modifiers\AlignRotationModifier;

class CheckupController extends Controller
{
    public function preview($id)
    {
        $document = CheckupDocument::with(['results.item', 'photos', 'creator', 'approver'])
            ->where('id', $id)
            ->where('workflow_status', 'approved')
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.checkup.pdf', compact('document'))
            ->setPaper('a4', 'portrait');

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
            ->paginate(15);

        return view('petugas.checkup.index', compact('documents'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(CooldownService $cooldownService)
    {
        // Cooldown check
        if ($retryAt = $cooldownService->checkUserCooldown(Auth::id(), 'checkup')) {
            $date = $retryAt->format('d M Y H:i');

            return redirect()
                ->route('petugas.checkup.index')
                ->with('error', "Anda sedang dalam masa pending. Silakan coba kembali setelah $date.");
        }

        $items = CheckupItem::orderBy('item_number')->get();

        return view('petugas.checkup.create', compact('items'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (SAVE DRAFT)
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, CooldownService $cooldownService, ExamDuplicateService $examDuplicateService)
    {
        // Cooldown check
        if ($retryAt = $cooldownService->checkUserCooldown(Auth::id(), 'checkup')) {
            $date = $retryAt->format('d M Y H:i');

            return redirect()
                ->route('petugas.checkup.index')
                ->with('error', "Anda sedang dalam masa pending. Silakan coba kembali setelah $date.");
        }

        // Security Code Check
        if ($cooldownService->isSuspended($request->security_code)) {
            abort(403, 'Akun ini masih dalam masa suspend');
        }

        // Duplicate Exam Check
        if ($examDuplicateService->checkDuplicate($request->security_code, 'checkup')) {
            ActivityLog::log('exam_duplicate_blocked', 'checkup', 'Duplicate exam creation blocked for '.$request->security_code);
            return back()->withInput()->with('error', 'User ini sudah memiliki pemeriksaan Checkup yang masih aktif.');
        }

        $request->validate([
            'security_code' => ['required', 'regex:/^S-PKT-\d{6}$/'],
            'nama_pengemudi' => 'required',
            'npk' => 'required',
            'no_pol' => 'required',
            'perusahaan' => 'required',
            'jenis_kendaraan' => 'required',
            'tanggal_pemeriksaan' => 'required|date',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpg,jpeg|max:4096',
            'hasil' => 'required|array',
        ]);

        $document = CheckupDocument::create([
            'security_code' => $request->security_code,
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
            'catatan_petugas' => $request->catatan_petugas,
            'created_by' => Auth::id(),
        ]);

        // Simpan checklist based on request results
        if ($request->has('hasil')) {
            foreach ($request->hasil as $itemId => $hasil) {
                CheckupResult::create([
                    'checkup_document_id' => $document->id,
                    'checkup_item_id' => $itemId,
                    'hasil' => $hasil,
                    'tindakan_perbaikan' => $request->tindakan_perbaikan[$itemId] ?? null,
                ]);
            }
        }

        // Upload foto
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // Generate unique structured filename
                // checkup_{document_id}_{timestamp}_{random}.jpg
                $timestamp = now()->format('YmdHis');
                $random = Str::random(5);
                $filename = "checkup_{$document->id}_{$timestamp}_{$random}.jpg";
                $path = 'checkup/' . $filename;

                // Ensure directory exists
                if (!Storage::disk('public')->exists('checkup')) {
                    Storage::disk('public')->makeDirectory('checkup');
                }

                try {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($photo);
                    
                    // Fix orientation
                    $image->modify(new AlignRotationModifier());
                    
                    // Resize to max width 1600px
                    $image->scale(width: 1600);
                    
                    // Encode to JPG with 80% quality
                    $encoded = $image->toJpeg(80);

                    // Save to storage
                    Storage::disk('public')->put($path, (string) $encoded);
                } catch (\Throwable $e) {
                    // Fallback if Image intervention fails
                    $path = $photo->storeAs('checkup', $filename, 'public');
                }

                CheckupPhoto::create([
                    'checkup_document_id' => $document->id,
                    'file_path' => $path,
                ]);
            }
        }

        // 📝 LOGGING
        \App\Models\ActivityLog::log('exam_created', 'checkup', "Created Checkup for {$document->nama_pengemudi} (ID: {$document->id})");

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
        $document = CheckupDocument::with(['photos'])
            ->where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        /*
        Load checklist template
        */
        $items = CheckupItem::where('is_active', 1)
            ->orderBy('item_number')
            ->get();

        /*
        Load results only once
        */
        $results = CheckupResult::where('checkup_document_id', $document->id)
            ->get()
            ->keyBy('checkup_item_id');

        return view('petugas.checkup.show', [
            'document' => $document,
            'items' => $items,
            'results' => $results
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $document = CheckupDocument::with([
            'results.item',
            'photos'
        ])->findOrFail($id);

        if ($document->created_by !== Auth::id()) {
            abort(403);
        }

        if (! $document->canBeEdited()) {
            return back()->with('error', 'Dokumen tidak dapat diedit.');
        }

        $items = CheckupItem::orderBy('item_number')->get();

        return view('petugas.checkup.edit', compact('document', 'items'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $document = CheckupDocument::where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (! $document->canBeEdited()) {
            return back()->with('error', 'Dokumen tidak dapat diedit.');
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
            'catatan_petugas',
        ]));

        // Update checklist
        if ($request->has('hasil')) {
            foreach ($request->hasil as $itemId => $hasil) {
                CheckupResult::updateOrCreate(
                    [
                        'checkup_document_id' => $document->id,
                        'checkup_item_id' => $itemId,
                    ],
                    [
                        'hasil' => $hasil,
                        'tindakan_perbaikan' => $request->tindakan_perbaikan[$itemId] ?? null,
                    ]
                );
            }
        }

        // Upload foto baru jika ada
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // Generate unique structured filename
                // checkup_{document_id}_{timestamp}_{random}.jpg
                $timestamp = now()->format('YmdHis');
                $random = Str::random(5);
                $filename = "checkup_{$document->id}_{$timestamp}_{$random}.jpg";
                $path = 'checkup/' . $filename;

                // Ensure directory exists
                if (!Storage::disk('public')->exists('checkup')) {
                    Storage::disk('public')->makeDirectory('checkup');
                }

                try {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($photo);
                    
                    // Fix orientation
                    $image->modify(new AlignRotationModifier());
                    
                    // Resize to max width 1600px
                    $image->scale(width: 1600);
                    
                    // Encode to JPG with 80% quality
                    $encoded = $image->toJpeg(80);

                    // Save to storage
                    Storage::disk('public')->put($path, (string) $encoded);
                } catch (\Throwable $e) {
                    // Fallback if Image intervention fails
                    $path = $photo->storeAs('checkup', $filename, 'public');
                }

                CheckupPhoto::create([
                    'checkup_document_id' => $document->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('petugas.checkup.show', $document->id)
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    public function submit($id)
    {
        $document = CheckupDocument::where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        if (! $document->isDraft() && ! $document->isRejected()) {
            return back()->with('error', 'Status tidak valid untuk submit.');
        }

        $document->update([
            'workflow_status' => 'submitted',
        ]);

        // 📝 LOGGING
        \App\Models\ActivityLog::log('exam_submitted', 'checkup', "Submitted Checkup for {$document->nama_pengemudi} (ID: {$document->id})");

        return back()->with('success', 'Dokumen berhasil disubmit.');
    }
}
