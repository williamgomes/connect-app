<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\TicketPriority\TicketPriorityCreateRequest;
use App\Http\Requests\App\TicketPriority\TicketPriorityUpdateRequest;
use App\Models\TicketPriority;
use Illuminate\Http\Request;

class TicketPriorityController extends Controller
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
        $this->authorize('viewAny', TicketPriority::class);

        return view('app.ticket-priorities.index')->with([
            'ticketPriorities' => TicketPriority::orderBy('order')->get(),
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
        $this->authorize('create', TicketPriority::class);

        return view('app.ticket-priorities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketPriorityCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TicketPriorityCreateRequest $request)
    {
        $this->authorize('create', TicketPriority::class);

        TicketPriority::create($request->only(['order', 'name', 'description']));

        return redirect()->action('App\TicketPriorityController@index')
            ->with('success', __('The ticket priority was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TicketPriority $ticketPriority
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(TicketPriority $ticketPriority)
    {
        $this->authorize('update', $ticketPriority);

        return view('app.ticket-priorities.edit')->with([
            'ticketPriority' => $ticketPriority,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketPriorityUpdateRequest $request
     * @param \App\Models\TicketPriority  $ticketPriority
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TicketPriorityUpdateRequest $request, TicketPriority $ticketPriority)
    {
        $this->authorize('update', $ticketPriority);

        $ticketPriority->update($request->only(['order', 'name', 'description']));

        return redirect()->action('App\TicketPriorityController@index')
            ->with('success', __('The ticket priority was successfully updated.'));
    }

    /**
     * @param TicketPriority $ticketPriority
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TicketPriority $ticketPriority)
    {
        $this->authorize('delete', $ticketPriority);

        $ticketPriority->delete();

        return redirect()->action('App\TicketPriorityController@index')
            ->with('info', __('The ticket priority was successfully deleted.'));
    }
}
