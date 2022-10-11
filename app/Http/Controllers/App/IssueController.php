<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Issue\IssueCreateRequest;
use App\Http\Requests\App\Issue\IssueUpdateRequest;
use App\Http\Requests\App\IssueComment\IssueCommentCreateRequest;
use App\Models\Issue;
use App\Models\IssueAttachment;
use App\Models\IssueComment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Issue::class);

        $issueQuery = Issue::with('author');

        if ($request->has('search')) {
            $issueQuery->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('key', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('author', function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
                });
        }

        return view('app.issues.index')->with([
            'issues' => $issueQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Issue::class);

        return view('app.issues.create')->with([
            'tickets' => Ticket::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IssueCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(IssueCreateRequest $request)
    {
        $this->authorize('create', Issue::class);

        Issue::create(array_merge($request->only([
            'title',
            'key',
            'type',
            'status',
            'description',
        ]), [
            'author_id' => $request->user()->id,
            'x_data'    => $request->only([
                'tickets',
                'attachments',
            ]),
        ]));

        return redirect()->action('App\IssueController@index')
            ->with('success', __('Issue was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Issue $issue
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Issue $issue)
    {
        $this->authorize('view', $issue);

        $comments = $issue->comments()
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('app.issues.show')->with([
            'issue'    => $issue,
            'comments' => $comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Issue $issue
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Issue $issue)
    {
        $this->authorize('update', $issue);

        return view('app.issues.edit')->with([
            'issue'   => $issue,
            'tickets' => Ticket::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IssueUpdateRequest $request
     * @param \App\Models\Issue  $issue
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(IssueUpdateRequest $request, Issue $issue)
    {
        $this->authorize('update', $issue);

        $issue->update(array_merge($request->only([
            'title',
            'key',
            'type',
            'status',
            'description',
        ]), [
            'x_data' => $request->only([
                'tickets',
                'attachments',
            ]),
        ]));

        return redirect()->action('App\IssueController@show', $issue)
            ->with('success', __('The issue was successfully updated.'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Issue $issue
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showAttachment(IssueAttachment $issueAttachment)
    {
        $this->authorize('view', $issueAttachment->issue);

        $fileFromStorage = Storage::get($issueAttachment->filename);
        $mimeType = Storage::mimeType($issueAttachment->filename);

        return response()->make($fileFromStorage, 200)
            ->header('Content-Type', $mimeType);
    }

    /**
     * @param IssueCommentCreateRequest $request
     * @param Issue                     $issue
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addComment(IssueCommentCreateRequest $request, Issue $issue)
    {
        $this->authorize('addComment', $issue);

        IssueComment::create([
            'issue_id' => $issue->id,
            'user_id'  => $request->user()->id,
            'content'  => $request->input('content'),
        ]);

        return redirect()->action('App\IssueController@show', $issue)
            ->with('success', __('The comment was successfully created.'));
    }
}
