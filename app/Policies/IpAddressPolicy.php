<?php

namespace App\Policies;

use App\Models\IpAddress;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IpAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create the model.
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
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\IpAddress $ipAddress
     *
     * @return mixed
     */
    public function update(User $user, IpAddress $ipAddress)
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
     * @param \App\Models\IpAddress $ipAddress
     *
     * @return mixed
     */
    public function delete(User $user, IpAddress $ipAddress)
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
