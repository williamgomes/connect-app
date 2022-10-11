<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->hasPermission(Permission::TYPE_ISSUES)) {
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
     * @param User  $user
     * @param Issue $issue
     *
     * @return mixed
     */
    public function view(User $user, Issue $issue)
    {
        if ($user->hasPermission(Permission::TYPE_ISSUES)) {
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
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->hasPermission(Permission::TYPE_ISSUES)) {
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
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return mixed
     */
    public function update(User $user, Issue $issue)
    {
        if ($user->hasPermission(Permission::TYPE_ISSUES)) {
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
     * Determine whether the user can add a comment to the model.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return mixed
     */
    public function addComment(User $user, Issue $issue)
    {
        if ($user->hasPermission(Permission::TYPE_ISSUES)) {
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
}
