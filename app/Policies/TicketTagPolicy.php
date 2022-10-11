<?php

namespace App\Policies;

use App\Models\TicketTag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketTagPolicy
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
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
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
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\TicketTag $ticketTag
     *
     * @return mixed
     */
    public function update(User $user, TicketTag $ticketTag)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\TicketTag $ticketTag
     *
     * @return mixed
     */
    public function delete(User $user, TicketTag $ticketTag)
    {
        // Do not allow deletion if it's linked with a ticket
        if ($ticketTag->tickets()->exists()) {
            return false;
        }

        if ($user->hasrole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
