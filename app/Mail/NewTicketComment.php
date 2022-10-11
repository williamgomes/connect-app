<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTicketComment extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * The ticket instance.
     *
     * @var ticket
     */
    public $ticket;

    /**
     * The user instance.
     *
     * @var user
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Ticket $ticket
     * @param User   $user
     */
    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->ticket->title . ' (#' . $this->ticket->id . ') ' . __('has been updated'))
                ->view('emails.tickets.updated')
                ->text('emails.tickets.updated_plain');
    }
}
