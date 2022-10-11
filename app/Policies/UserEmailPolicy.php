<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserEmail;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserEmailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can mark emails as read.
     *
     * @param User      $user
     * @param UserEmail $userEmail
     *
     * @return mixed
     */
    public function markAsRead(User $user, UserEmail $userEmail)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return $userEmail->user->id == $user->id;
    }

    /**
     * Determine whether the user can mark emails as unread.
     *
     * @param User      $user
     * @param UserEmail $userEmail
     *
     * @return mixed
     */
    public function markAsUnread(User $user, UserEmail $userEmail)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return $userEmail->user->id == $user->id;
    }
}
