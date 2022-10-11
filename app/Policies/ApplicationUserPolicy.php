<?php

namespace App\Policies;

use App\Models\ApplicationUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationUserPolicy
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
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * @param User            $user
     * @param ApplicationUser $applicationUser
     *
     * @return bool
     */
    public function delete(User $user, ApplicationUser $applicationUser)
    {
        if ($applicationUser->direct == ApplicationUser::NOT_DIRECT) {
            return false;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
