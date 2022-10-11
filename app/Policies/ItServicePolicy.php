<?php

namespace App\Policies;

use App\Models\ItService;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItServicePolicy
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
     * @param \App\Models\User      $user
     * @param \App\Models\ItService $itService
     *
     * @return mixed
     */
    public function view(User $user, ItService $itService)
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
     * @param \App\Models\ItService $itService
     *
     * @return mixed
     */
    public function update(User $user, ItService $itService)
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
     * @param \App\Models\User      $user
     * @param \App\Models\ItService $itService
     *
     * @return mixed
     */
    public function delete(User $user, ItService $itService)
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
