<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole(User::ROLE_REPORTING)) {
            $tickets = [];
        } else {
            $ticketsAwaitingAgent = Ticket::select('tickets.*', 'ticket_priorities.order as order')
                ->join('ticket_priorities', 'ticket_priorities.id', 'tickets.priority_id')
                ->join(
                    DB::raw('(SELECT MAX(ticket_comments.id) max_id, ticket_comments.ticket_id
                            FROM ticket_comments
                            GROUP BY  ticket_comments.ticket_id) tc_max'),
                    'tickets.id',
                    'tc_max.ticket_id'
                )
                ->join('ticket_comments', 'ticket_comments.id', 'tc_max.max_id')
                ->where('tickets.status', Ticket::STATUS_OPEN)
                ->where('tickets.user_id', $user->id)
                ->orderBy('order')
                ->orderBy('tickets.due_at', 'ASC');

            // Clone query
            $ticketsAwaitingEndUser = clone $ticketsAwaitingAgent;

            // Build agent ticket list
            $tickets[__("Ticket's that need your attention")] = $ticketsAwaitingAgent
                ->where('ticket_comments.user_id', '!=', $user->id)
                ->get();

            // Build requester ticket list
            $tickets[__("Ticket's that wait on the requester")] = $ticketsAwaitingEndUser
                ->where('ticket_comments.user_id', $user->id)
                ->get();
        }

        return view('app.dashboard.show')->with([
            'tickets' => $tickets,
        ]);
    }
}
