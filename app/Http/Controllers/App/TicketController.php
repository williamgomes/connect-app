<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Ticket\TicketCreateRequest;
use App\Http\Requests\App\Ticket\TicketUpdateRequest;
use App\Http\Requests\App\TicketComment\TicketCommentCreateRequest;
use App\Jobs\SendSMS;
use App\Mail\NewTicketComment;
use App\Models\Category;
use App\Models\Country;
use App\Models\Issue;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\TicketCommentAttachment;
use App\Models\TicketPriority;
use App\Models\TicketTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param null    $status
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status = null)
    {
        $this->authorize('viewAny', Ticket::class);

        if ($request->user()->hasRole(User::ROLE_REGULAR)) {
            $tickets = $request->user()->tickets();
        } else {
            $tickets = Ticket::query();
        }

        $tickets->select('tickets.*', 'ticket_priorities.order as order')
            ->join('ticket_priorities', 'ticket_priorities.id', 'tickets.priority_id')
            ->leftJoin('ticket_ticket_tag', 'ticket_ticket_tag.ticket_id', 'tickets.id')
            ->leftJoin('ticket_tags', 'ticket_ticket_tag.ticket_tag_id', 'ticket_tags.id');

        if ($status) {
            $tickets->where('status', $status);
        }

        // Handle any search present
        if ($request->has('search')) {
            $search = $request->search;
            $tickets->where(function ($query) use ($search) {
                $query->where('tickets.id', 'LIKE', '%' . $search . '%')
                    ->orWhere('tickets.title', 'LIKE', '%' . $search . '%')
                    ->orWhere('tickets.status', 'LIKE', '%' . $search . '%')
                    ->orWhere('ticket_tags.name', 'LIKE', '%' . $search . '%');
            });
        }

        // Order by updated_at
        $tickets->distinct('tickets.id')
            ->orderBy('order')
            ->orderBy('updated_at', 'DESC');

        return view('app.tickets.index')->with([
            'tickets' => $tickets->paginate(25)->withPath('?search=' . $request->input('search', '')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Ticket::class);

        $requesters = User::where('active', User::IS_ACTIVE)
            ->where('role', User::ROLE_REGULAR)
            ->get();

        $categories = Category::active()->whereNull('parent_id')->get();
        $services = Service::active()->get();
        $countries = Country::active()->get();
        $priorities = TicketPriority::orderBy('order')->get();

        return view('app.tickets.create')->with([
            'requesters' => $requesters,
            'categories' => $categories,
            'services'   => $services,
            'countries'  => $countries,
            'issues'     => Issue::all(),
            'priorities' => $priorities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TicketCreateRequest $request)
    {
        $this->authorize('create', Ticket::class);

        $category = Category::find($request->input('category_id'));
        $fieldSlugs = $category->fields->pluck('slug')->toArray();

        $ticket = Ticket::create(array_merge($request->only([
            'title',
            'requester_id',
            'category_id',
            'service_id',
            'country_id',
            'priority_id',
        ]), [
            'user_id' => $request->user()->id,
            'x_data'  => array_merge([
                'comment_user_id' => $request->user()->id,
            ], $request->only(
                array_merge([
                    'subcategory_id',
                    'comment',
                    'issues',
                    'attachments',
                ], $fieldSlugs)
            )),
        ]));

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('success', __('The ticket was successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $users = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_AGENT])
            ->whereNotIn('id', $ticket->watchers->pluck('id')->merge([$ticket->requester_id, $ticket->user_id]))
            ->get();

        $comments = $ticket->comments(false)
            ->orderBy('id', 'DESC')
            ->get();

        $ticketTags = TicketTag::where('active', TicketTag::IS_ACTIVE)->whereNotIn('id', $ticket->ticketTags()->pluck('ticket_tags.id'))->get();

        return view('app.tickets.show')->with([
            'ticket'     => $ticket,
            'comments'   => $comments,
            'users'      => $users,
            'ticketTags' => $ticketTags,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $users = User::where('active', User::IS_ACTIVE)
            ->where('role', '!=', User::ROLE_REGULAR)
            ->get();

        $requesters = User::where('active', User::IS_ACTIVE)->get();

        $categories = Category::active()->whereNull('parent_id')->get();
        $services = Service::active()->get();
        $countries = Country::active()->get();
        $priorities = TicketPriority::orderBy('order')->get();

        return view('app.tickets.edit')->with([
            'ticket'     => $ticket,
            'users'      => $users,
            'requesters' => $requesters,
            'categories' => $categories,
            'services'   => $services,
            'countries'  => $countries,
            'issues'     => Issue::all(),
            'priorities' => $priorities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketUpdateRequest $request
     * @param \App\Models\Ticket  $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TicketUpdateRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update(array_merge($request->only([
            'title',
            'user_id',
            'requester_id',
            'category_id',
            'service_id',
            'country_id',
            'priority_id',
        ]), [
            'x_data' => $request->only([
                'subcategory_id',
                'comment',
                'issues',
            ]),
        ]));

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('success', __('The ticket was successfully updated.'));
    }

    /**
     * Reply to the specified resource from storage.
     *
     * @param TicketCommentCreateRequest $request
     * @param Ticket                     $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply(TicketCommentCreateRequest $request, Ticket $ticket)
    {
        $this->authorize('reply', $ticket);

        $ticket->reply(array_merge($request->only([
            'content',
            'attachments',
        ]), [
            'user_id' => $request->user()->id,
            'private' => isset($request->public) ? TicketComment::NOT_PRIVATE : TicketComment::IS_PRIVATE,
        ]));

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('success', __('The ticket comment was successfully created.'));
    }

    /**
     * Mark the specified resource from storage as solved.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsSolved(Ticket $ticket)
    {
        $this->authorize('markAsSolved', $ticket);

        $ticket->update([
            'status' => Ticket::STATUS_SOLVED,
        ]);

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('success', __('The ticket was successfully marked as solved.'));
    }

    /**
     * Remind requester about the specified resource from storage.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function remindRequester(Ticket $ticket)
    {
        $this->authorize('remindRequester', $ticket);

        if ($ticket->requester->phone_number) {
            $body = __('Your ticket') . ' #' . $ticket->id . ' ' . __('is awaiting your response in Synega Connect.');
            $body .= ' ' . __('Best regards, The Connect Team');
            SendSMS::dispatch($ticket->requester->phone_number, $body);
        }

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('success', __('The ticket requester was successfully reminded.'));
    }

    /**
     * Download a ticket comment attachment.
     *
     * @param TicketCommentAttachment $ticketCommentAttachment
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadAttachment(TicketCommentAttachment $ticketCommentAttachment)
    {
        $this->authorize('view', $ticketCommentAttachment->comment->ticket);

        return Storage::download($ticketCommentAttachment->filename, $ticketCommentAttachment->original_filename);
    }

    /**
     * @param Request $request
     * @param Ticket  $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createWatcher(Request $request, Ticket $ticket)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::find($request->input('user_id'));

        $this->authorize('createWatcher', [$ticket, $user]);

        $ticket->watchers()->attach($user);

        // Notify user about ticket update
        Mail::to($user)->send(new NewTicketComment($ticket, $user));

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('success', __('The user was successfully added to the ticket as a watcher and notified.'));
    }

    /**
     * @param Request $request
     * @param Ticket  $ticket
     * @param User    $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyWatcher(Request $request, Ticket $ticket, User $user)
    {
        $this->authorize('deleteWatcher', [$ticket, $user]);

        $ticket->watchers()->detach($user);

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('info', __('The user is no longer a watcher of the ticket.'));
    }

    /**
     * @param Request $request
     * @param Ticket  $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createTicketTag(Request $request, Ticket $ticket)
    {
        $request->validate([
            'ticket_tags'   => 'required|array',
            'ticket_tags.*' => 'required|integer|exists:ticket_tags,id',
        ]);

        foreach ($request->input('ticket_tags') as $ticketTagId) {
            $ticketTag = TicketTag::find($ticketTagId);

            $this->authorize('createTicketTag', [$ticket, $ticketTag]);

            $ticket->ticketTags()->attach($ticketTag);
        }

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('success', __('The Tag was successfully added to the ticket.'));
    }

    /**
     * @param Request   $request
     * @param Ticket    $ticket
     * @param TicketTag $ticketTag
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyTicketTag(Request $request, Ticket $ticket, TicketTag $ticketTag)
    {
        $this->authorize('deleteTicketTag', [$ticket, $ticketTag]);

        $ticket->ticketTags()->detach($ticketTag);

        return redirect()->action('App\TicketController@show', $ticket)
            ->with('info', __('The Tag was successfully removed from the ticket.'));
    }
}
