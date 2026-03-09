<?php

namespace App\Http\Controllers\Avp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalHistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Build Subqueries for each module
        $simper = DB::table('simper_documents')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(approved_at, rejected_at) as action_at'),
                'workflow_status as status',
                'petugas_id as created_by',
                'nama as user_name',
                DB::raw("'SIMPER' as module_type")
            )
            ->where(function ($query) use ($userId) {
                $query->where('approved_by', $userId)
                    ->orWhere('rejected_by', $userId);
            });

        $ujsimp = DB::table('ujsimp_tests')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(approved_at, rejected_at) as action_at'),
                'workflow_status as status',
                'petugas_id as created_by',
                'nama as user_name',
                DB::raw("'UJSIMP' as module_type")
            )
            ->where(function ($query) use ($userId) {
                $query->where('approved_by', $userId)
                    ->orWhere('rejected_by', $userId);
            });

        $checkup = DB::table('checkup_documents')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(approved_at, rejected_at) as action_at'),
                'workflow_status as status',
                'created_by',
                'nama_pengemudi as user_name',
                DB::raw("'CHECKUP' as module_type")
            )
            ->where(function ($query) use ($userId) {
                $query->where('approved_by', $userId)
                    ->orWhere('rejected_by', $userId);
            });

        $ranmor = DB::table('ranmor_documents')
            ->select(
                'id as document_id',
                'created_at',
                DB::raw('COALESCE(approved_at, rejected_at) as action_at'),
                'workflow_status as status',
                'created_by',
                'pengemudi as user_name',
                DB::raw("'RANMOR' as module_type")
            )
            ->where(function ($query) use ($userId) {
                $query->where('approved_by', $userId)
                    ->orWhere('rejected_by', $userId);
            });

        // 2. Combine with UNION ALL
        $union = $simper
            ->unionAll($ujsimp)
            ->unionAll($checkup)
            ->unionAll($ranmor);

        // 3. Wrap in main query for Joining and Filtering
        $query = DB::query()
            ->fromSub($union, 'documents')
            ->leftJoin('users as checkers', 'documents.created_by', '=', 'checkers.id')
            ->select(
                'documents.*',
                'checkers.name as checker_name',
                'checkers.npk as checker_npk'
            );

        // 4. Apply Filters

        // Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('documents.status', $request->status);
        }

        // Search Filter (Optional but good to have)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(documents.user_name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(checkers.name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(documents.module_type) LIKE ?', ["%{$search}%"]);
            });
        }

        // Sort Filter
        $sort = $request->get('sort', 'terbaru');
        $direction = $sort === 'terlama' ? 'asc' : 'desc';
        $query->orderBy('documents.action_at', $direction);

        // 5. Pagination
        $history = $query->paginate(15)->withQueryString();

        return view('avp.approval_history', compact('history'));
    }
}
