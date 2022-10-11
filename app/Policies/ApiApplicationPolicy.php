<?php

namespace App\Policies;

use App\Models\ApiApplication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any applications.
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
     * Determine whether the user can view the application.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\ApiApplication $apiApplication
     *
     * @return mixed
     */
    public function view(User $user, ApiApplication $apiApplication)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create applications.
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
     * Determine whether the user can update the application.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\ApiApplication $apiApplication
     *
     * @return mixed
     */
    public function update(User $user, ApiApplication $apiApplication)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the application.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\ApiApplication $apiApplication
     *
     * @return mixed
     */
    public function delete(User $user, ApiApplication $apiApplication)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the application.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\ApiApplication $apiApplication
     *
     * @return mixed
     */
    public function restore(User $user, ApiApplication $apiApplication)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the application.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\ApiApplication $apiApplication
     *
     * @return mixed
     */
    public function forceDelete(User $user, ApiApplication $apiApplication)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
