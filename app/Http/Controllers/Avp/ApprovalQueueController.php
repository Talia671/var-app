<?php

namespace App\Http\Controllers\Avp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApprovalQueueController extends Controller
{
    public function index(Request $request)
    {
        // 1. Build Subqueries for each module
        $simper = DB::table('simper_documents')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(verified_at, updated_at, created_at) as verified_at'),
                'verified_by',
                'petugas_id as created_by',
                'nama as user_name',
                'workflow_status',
                DB::raw("'SIMPER' as module_type")
            )
            ->whereIn('workflow_status', ['verified', 'approved', 'rejected']);

        $ujsimp = DB::table('ujsimp_tests')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(verified_at, updated_at, created_at) as verified_at'),
                'verified_by',
                'petugas_id as created_by',
                'nama as user_name',
                'workflow_status',
                DB::raw("'UJSIMP' as module_type")
            )
            ->whereIn('workflow_status', ['verified', 'approved', 'rejected']);

        $checkup = DB::table('checkup_documents')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(verified_at, updated_at, created_at) as verified_at'),
                'verified_by',
                'created_by',
                'nama_pengemudi as user_name',
                'workflow_status',
                DB::raw("'CHECKUP' as module_type")
            )
            ->whereIn('workflow_status', ['verified', 'approved', 'rejected']);

        $ranmor = DB::table('ranmor_documents')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(verified_at, updated_at, created_at) as verified_at'),
                'verified_by',
                'created_by',
                'pengemudi as user_name',
                'workflow_status',
                DB::raw("'RANMOR' as module_type")
            )
            ->whereIn('workflow_status', ['verified', 'approved', 'rejected']);

        // 2. Combine with UNION ALL
        $union = $simper
            ->unionAll($ujsimp)
            ->unionAll($checkup)
            ->unionAll($ranmor);

        // 3. Wrap in main query for Joining and Filtering
        $query = DB::query()
            ->fromSub($union, 'documents')
            ->leftJoin('users as verifiers', 'documents.verified_by', '=', 'verifiers.id')
            ->leftJoin('users as checkers', 'documents.created_by', '=', 'checkers.id')
            ->select(
                'documents.*',
                'verifiers.name as verifier_name',
                'checkers.name as checker_name'
            );

        // 4. Apply Filters

        // Search (Case Insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(documents.user_name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(verifiers.name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(documents.module_type) LIKE ?', ["%{$search}%"]);
            });
        }

        // Module Filter
        if ($request->filled('module') && $request->module !== 'all') {
            $query->where('documents.module_type', strtoupper($request->module));
        }

        // Time Range Filter (on verified_at)
        if ($request->filled('range')) {
            $range = $request->range;
            $now = Carbon::now();
            $startAt = null;

            if ($range === 'today') {
                $startAt = $now->copy()->startOfDay();
            } elseif ($range === 'week') {
                $startAt = $now->copy()->startOfWeek();
            } elseif ($range === 'month') {
                $startAt = $now->copy()->startOfMonth();
            }

            if ($startAt) {
                $query->where('documents.verified_at', '>=', $startAt);
            }
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        $direction = $sort === 'terlama' ? 'asc' : 'desc';
        $query->orderBy('documents.verified_at', $direction);

        // 5. Pagination
        $documents = $query->paginate(15)->withQueryString();

        return view('avp.approval_queue', compact('documents'));
    }
}
