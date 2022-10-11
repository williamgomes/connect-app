<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param null    $status
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request, $status = null)
    {
        $this->authorize('viewAnyPersonal', Issue::class);

        $issues = Issue::select('issues.*')
            ->join('issue_ticket', function ($join) use ($request) {
                $join->on('issue_ticket.issue_id', 'issues.id')
                    ->whereIn('issue_ticket.ticket_id', $request->user()->tickets()->pluck('id'));
            });

        if ($status) {
            $issues->where('status', $status);
        }

        // Order by updated_at
        $issues->orderBy('updated_at', 'DESC');

        return view('web.issues.index')->with([
            'issues' => $issues->paginate(25),
        ]);
    }

    /**
     * @param Request $request
     * @param Issue   $issue
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Issue $issue)
    {
        if ($request->wantsJson()) {
            $html = view('web.issues.single', [
                'issue' => $issue,
            ])->render();

            return response()->json([
                'html' => $html,
            ]);
        } else {
            return view('web.issues.show')->with([
                'issue' => $issue,
            ]);
        }
    }
}
