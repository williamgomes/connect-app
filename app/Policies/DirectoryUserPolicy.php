<?php

namespace App\Policies;

use App\Models\DirectoryUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DirectoryUserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * @param User          $user
     * @param DirectoryUser $directoryUser
     *
     * @return bool
     */
    public function update(User $user, DirectoryUser $directoryUser)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
