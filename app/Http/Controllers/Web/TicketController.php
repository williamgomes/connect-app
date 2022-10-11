<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Ticket\TicketCreateRequest;
use App\Http\Requests\App\TicketComment\TicketCommentCreateRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\TicketCommentAttachment;
use App\Models\TicketPriority;
use Illuminate\Http\Request;
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
        $this->authorize('viewAnyPersonal', Ticket::class);

        $tickets = $request->user()->tickets()->select('tickets.*', 'ticket_priorities.order as order')
            ->join('ticket_priorities', 'ticket_priorities.id', 'tickets.priority_id');

        if ($status) {
            $tickets->where('status', $status);
        }

        // Handle any search present
        if ($request->has('search')) {
            $search = $request->search;
            $tickets->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }

        // Order by updated_at
        $tickets->orderBy('order')->orderBy('updated_at', 'DESC');

        return view('web.tickets.index')->with([
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

        $categories = Category::active()->whereNull('parent_id')->get();
        $services = Service::active()->get();
        $countries = Country::active()->get();
        $priorities = TicketPriority::orderBy('order')->get();
        $priorityDescriptions = $priorities->pluck('description', 'id');

        return view('web.tickets.create')->with([
            'categories'           => $categories,
            'services'             => $services,
            'countries'            => $countries,
            'priorities'           => $priorities,
            'priorityDescriptions' => $priorityDescriptions,
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
            'category_id',
            'service_id',
            'country_id',
            'priority_id',
        ]), [
            'user_id'      => $request->user()->id,
            'requester_id' => $request->user()->id,
            'x_data'       => array_merge([
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

        return redirect()->action('Web\TicketController@show', $ticket)
            ->with('success', __('The ticket was successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return view('web.tickets.show')->with([
            'ticket'   => $ticket,
            'comments' => $ticket->comments()->orderBy('id', 'ASC')->get(),
        ]);
    }

    /**
     * Reply to the specified resource from storage.
     *
     * @param TicketCommentCreateRequest $request
     * @param Ticket                     $ticket
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function reply(TicketCommentCreateRequest $request, Ticket $ticket)
    {
        $this->authorize('reply', $ticket);

        $ticket->reply(array_merge($request->only([
            'content',
            'attachments',
        ]), [
            'user_id' => $request->user()->id,
            'private' => TicketComment::NOT_PRIVATE,
        ]));

        return redirect()->action('Web\TicketController@show', $ticket)
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

        return redirect()->action('Web\TicketController@show', $ticket)
            ->with('success', __('The ticket was successfully marked as solved.'));
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
}
