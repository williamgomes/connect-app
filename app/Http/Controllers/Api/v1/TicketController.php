<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Ticket\TicketCreateRequest;
use App\Http\Requests\Api\v1\Ticket\TicketIndexRequest;
use App\Http\Requests\Api\v1\Ticket\TicketReplyRequest;
use App\Http\Requests\Api\v1\Ticket\TicketUpdateRequest;
use App\Http\Resources\Api\v1\Ticket as TicketResource;
use App\Http\Resources\Api\v1\TicketComment as TicketCommentResource;
use App\Lib\ApiApplicationAccess\Facades\ApiApplicationAccess;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(TicketIndexRequest $request)
    {
        $ticketsQuery = Ticket::query();

        if ($request->has('title')) {
            $ticketsQuery->where('title', $request->input('title'));
        }

        return TicketResource::collection($ticketsQuery->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketCreateRequest $request
     *
     * @return TicketResource
     */
    public function store(TicketCreateRequest $request)
    {
        // Authorize request
        ApiApplicationAccess::authorize('create', Ticket::class);

        $ticket = Ticket::create(array_merge($request->only([
            'title',
            'user_id',
            'requester_id',
            'category_id',
            'service_id',
            'country_id',
        ]), [
            'x_data'  => $request->only([
                'comment_user_id',
                'subcategory_id',
                'comment',
                'issues',
                'attachments',
            ]),
        ]));

        return new TicketResource($ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Ticket  $ticket
     *
     * @return TicketResource
     */
    public function show(Request $request, Ticket $ticket)
    {
        // Authorize request
        ApiApplicationAccess::authorize('view', $ticket);

        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketUpdateRequest $request
     * @param Ticket              $ticket
     *
     * @return TicketResource
     */
    public function update(TicketUpdateRequest $request, Ticket $ticket)
    {
        // Authorize request
        ApiApplicationAccess::authorize('update', $ticket);

        $ticket->update(array_merge($request->only([
            'title',
            'user_id',
            'requester_id',
            'category_id',
            'service_id',
            'country_id',
        ]), [
            'x_data' => $request->only([
                'subcategory_id',
                'comment',
                'issues',
            ]),
        ]));

        return new TicketResource($ticket);
    }

    /**
     * @param TicketReplyRequest $request
     * @param Ticket             $ticket
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return TicketCommentResource
     */
    public function reply(TicketReplyRequest $request, Ticket $ticket)
    {
        // Authorize request
        ApiApplicationAccess::authorize('reply', $ticket);

        $ticketComment = $ticket->reply($request->only([
            'content',
            'attachments',
            'user_id',
            'private',
        ]));

        return new TicketCommentResource($ticketComment);
    }

    /**
     * @param Request $request
     * @param Ticket  $ticket
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return TicketResource
     */
    public function markAsSolved(Request $request, Ticket $ticket)
    {
        // Authorize request
        ApiApplicationAccess::authorize('markAsSolved', $ticket);

        $ticket->update([
            'status' => Ticket::STATUS_SOLVED,
        ]);

        return new TicketResource($ticket);
    }
}
