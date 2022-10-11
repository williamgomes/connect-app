<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Ticket;
use App\Models\TicketTag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->hasPermission(Permission::TYPE_TICKETS)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view any personal models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAnyPersonal(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        if ($user->hasPermission(Permission::TYPE_TICKETS)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return $user->id == $ticket->requester->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can reply to the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function reply(User $user, Ticket $ticket)
    {
        if ($ticket->status == Ticket::STATUS_CLOSED) {
            return false;
        }

        if ($user->hasPermission(Permission::TYPE_TICKETS)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return $user->id == $ticket->requester->id;
    }

    /**
     * Determine whether the user can mark the model as solved.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function markAsSolved(User $user, Ticket $ticket)
    {
        if ($ticket->status != Ticket::STATUS_OPEN) {
            return false;
        }

        if (is_null($ticket->user_id)) {
            return false;
        }

        if ($user->hasPermission(Permission::TYPE_TICKETS)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return $user->id == $ticket->requester->id;
    }

    /**
     * Determine whether the user can remind the model's requester.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function remindRequester(User $user, Ticket $ticket)
    {
        if ($ticket->status != Ticket::STATUS_OPEN) {
            return false;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
        if ($ticket->status != Ticket::STATUS_OPEN) {
            return false;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function restore(User $user, Ticket $ticket)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return mixed
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        return false;
    }

    /**
     * Determine whether the user can create ticket watcher.
     *
     * @param User   $currentUser
     * @param Ticket $ticket
     * @param User   $user
     *
     * @return mixed
     */
    public function createWatcher(User $currentUser, Ticket $ticket, User $user)
    {
        if ($ticket->status == Ticket::STATUS_CLOSED) {
            return false;
        }

        if ($currentUser->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($currentUser->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return $currentUser->id == $ticket->requester->id;
    }

    /**
     * Determine whether the user can delete ticket watcher.
     *
     * @param User   $currentUser
     * @param Ticket $ticket
     * @param User   $user
     *
     * @return mixed
     */
    public function deleteWatcher(User $currentUser, Ticket $ticket, User $user)
    {
        if ($ticket->status == Ticket::STATUS_CLOSED) {
            return false;
        }

        if ($currentUser->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($currentUser->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return $currentUser->id == $ticket->requester->id;
    }

    /**
     * Determine whether the user can create ticket tag.
     *
     * @param User      $user
     * @param Ticket    $ticket
     * @param TicketTag $ticketTag
     *
     * @return mixed
     */
    public function createTicketTag(User $user, Ticket $ticket, TicketTag $ticketTag)
    {
        if ($ticketTag->active == TicketTag::NOT_ACTIVE) {
            return false;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete ticket tag.
     *
     * @param User      $user
     * @param Ticket    $ticket
     * @param TicketTag $ticketTag
     *
     * @return mixed
     */
    public function deleteTicketTag(User $user, Ticket $ticket, TicketTag $ticketTag)
    {
        if ($ticketTag->active == TicketTag::NOT_ACTIVE) {
            return false;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return false;
    }
}
