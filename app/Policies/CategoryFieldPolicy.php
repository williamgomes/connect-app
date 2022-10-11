<?php

namespace App\Policies;

use App\Models\CategoryField;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryFieldPolicy
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
     * @param \App\Models\User          $user
     * @param \App\Models\CategoryField $categoryField
     *
     * @return mixed
     */
    public function update(User $user, CategoryField $categoryField)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User          $user
     * @param \App\Models\CategoryField $categoryField
     *
     * @return mixed
     */
    public function delete(User $user, CategoryField $categoryField)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
