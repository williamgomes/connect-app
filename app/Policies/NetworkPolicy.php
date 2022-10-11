<?php

namespace App\Policies;

use App\Models\Network;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NetworkPolicy
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
        if ($user->hasPermission(Permission::TYPE_IT_INFRASTRUCTURE)) {
            return true;
        }

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
        if ($user->hasPermission(Permission::TYPE_IT_INFRASTRUCTURE)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Network $network
     *
     * @return mixed
     */
    public function view(User $user, Network $network)
    {
        if ($user->hasPermission(Permission::TYPE_IT_INFRASTRUCTURE)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Network $network
     *
     * @return mixed
     */
    public function update(User $user, Network $network)
    {
        if ($user->hasPermission(Permission::TYPE_IT_INFRASTRUCTURE)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Network $network
     *
     * @return mixed
     */
    public function delete(User $user, Network $network)
    {
        if ($user->hasPermission(Permission::TYPE_IT_INFRASTRUCTURE)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
