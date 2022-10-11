<?php

namespace App\Policies;

use App\Models\ApiApplicationToken;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiApplicationTokenPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any application tokens.
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
     * Determine whether the user can create application tokens.
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
     * Determine whether the user can revoke the application token.
     *
     * @param \App\Models\User                $user
     * @param \App\Models\ApiApplicationToken $apiApplicationToken
     *
     * @return mixed
     */
    public function revoke(User $user, ApiApplicationToken $apiApplicationToken)
    {
        // You can't revoke a token that's already revoked
        if (!is_null($apiApplicationToken->revoked_at)) {
            return false;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
