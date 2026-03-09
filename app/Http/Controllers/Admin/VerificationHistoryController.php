<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VerificationHistoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'terbaru');
        $sort = in_array($sort, ['terbaru', 'terlama'], true) ? $sort : 'terbaru';
        $direction = $sort === 'terlama' ? 'asc' : 'desc';

        $simper = DB::table('simper_documents')
            ->leftJoin('users', 'simper_documents.petugas_id', '=', 'users.id')
            ->where(function ($q) {
                $q->whereNotNull('simper_documents.verified_by')
                  ->orWhereNotNull('simper_documents.rejected_by');
            })
            ->selectRaw("
                COALESCE(simper_documents.verified_at, simper_documents.rejected_at) as action_at,
                'SIMPER' as module,
                users.name as checker_name,
                users.npk as checker_npk,
                simper_documents.nama as user_name,
                CASE WHEN simper_documents.workflow_status = 'verified' THEN 'Verified' ELSE 'Rejected' END as status
            ")
            ->get();

        $ujsimp = DB::table('ujsimp_tests')
            ->leftJoin('users', 'ujsimp_tests.petugas_id', '=', 'users.id')
            ->where(function ($q) {
                $q->whereNotNull('ujsimp_tests.verified_by')
                  ->orWhereNotNull('ujsimp_tests.rejected_by');
            })
            ->selectRaw("
                COALESCE(ujsimp_tests.verified_at, ujsimp_tests.rejected_at) as action_at,
                'UJSIMP' as module,
                users.name as checker_name,
                users.npk as checker_npk,
                ujsimp_tests.nama as user_name,
                CASE WHEN ujsimp_tests.workflow_status = 'verified' THEN 'Verified' ELSE 'Rejected' END as status
            ")
            ->get();

        $checkup = DB::table('checkup_documents')
            ->leftJoin('users', 'checkup_documents.created_by', '=', 'users.id')
            ->where(function ($q) {
                $q->whereNotNull('checkup_documents.verified_by')
                  ->orWhereNotNull('checkup_documents.rejected_by');
            })
            ->selectRaw("
                COALESCE(checkup_documents.verified_at, checkup_documents.rejected_at) as action_at,
                'Checklist' as module,
                users.name as checker_name,
                users.npk as checker_npk,
                checkup_documents.nama_pengemudi as user_name,
                CASE WHEN checkup_documents.workflow_status = 'verified' THEN 'Verified' ELSE 'Rejected' END as status
            ")
            ->get();

        $ranmor = DB::table('ranmor_documents')
            ->leftJoin('users', 'ranmor_documents.created_by', '=', 'users.id')
            ->where(function ($q) {
                $q->whereNotNull('ranmor_documents.verified_by')
                  ->orWhereNotNull('ranmor_documents.rejected_by');
            })
            ->selectRaw("
                COALESCE(ranmor_documents.verified_at, ranmor_documents.rejected_at) as action_at,
                'Ranmor' as module,
                users.name as checker_name,
                users.npk as checker_npk,
                ranmor_documents.pengemudi as user_name,
                CASE WHEN ranmor_documents.workflow_status = 'verified' THEN 'Verified' ELSE 'Rejected' END as status
            ")
            ->get();

        $all = (new Collection())
            ->merge($simper)
            ->merge($ujsimp)
            ->merge($checkup)
            ->merge($ranmor)
            ->filter(function ($row) {
                return ! is_null($row->action_at);
            })
            ->sortBy([
                ['action_at', $direction],
            ])
            ->values();

        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $total = $all->count();
        $items = $all->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.verification_history', [
            'records' => $paginator,
            'sort' => $sort,
        ]);
    }
}
