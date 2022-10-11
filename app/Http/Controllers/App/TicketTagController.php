<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\TicketTag\TicketTagCreateRequest;
use App\Http\Requests\App\TicketTag\TicketTagUpdateRequest;
use App\Models\TicketTag;
use Illuminate\Http\Request;

class TicketTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', TicketTag::class);

        $ticketTagQuery = TicketTag::query();

        if ($request->has('search')) {
            $ticketTagQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.ticket-tags.index')->with([
            'ticketTags' => $ticketTagQuery->paginate(25),
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
        $this->authorize('create', TicketTag::class);

        return view('app.ticket-tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketTagCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TicketTagCreateRequest $request)
    {
        $this->authorize('create', TicketTag::class);

        TicketTag::create($request->only(['name', 'description', 'active']));

        return redirect()->action('App\TicketTagController@index')
            ->with('success', __('The Ticket Tag was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TicketTag $ticketTag
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketTag $ticketTag)
    {
        $this->authorize('update', $ticketTag);

        return view('app.ticket-tags.edit')->with([
            'ticketTag' => $ticketTag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketTagUpdateRequest $request
     * @param \App\Models\TicketTag  $ticketTag
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TicketTagUpdateRequest $request, TicketTag $ticketTag)
    {
        $this->authorize('update', $ticketTag);

        $ticketTag->update($request->only(['name', 'description', 'active']));

        return redirect()->action('App\TicketTagController@index')
            ->with('success', __('The Ticket Tag was successfully updated.'));
    }

    /**
     * @param TicketTag $ticketTag
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TicketTag $ticketTag)
    {
        $this->authorize('delete', $ticketTag);

        $ticketTag->delete();

        return redirect()->action('App\TicketTagController@index')
            ->with('info', __('The Ticket Tag was successfully deleted.'));
    }
}
