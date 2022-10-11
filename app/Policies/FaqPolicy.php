<?php

namespace App\Policies;

use App\Models\Faq;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        if ($user->hasPermission(Permission::TYPE_FAQ)) {
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
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->hasPermission(Permission::TYPE_FAQ)) {
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
     * @param User $user
     * @param Faq  $faq
     *
     * @return bool
     */
    public function update(User $user, Faq $faq)
    {
        if ($user->hasPermission(Permission::TYPE_FAQ)) {
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
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Faq  $faq
     *
     * @return bool
     */
    public function view(User $user, Faq $faq)
    {
        if ($faq->users()->count()) {
            // Allow if the user is among the allowed ones
            if ($faq->users()->where('users.id', $user->id)->exists()) {
                return true;
            }

            // Disallow if not
            return false;
        }

        if ($faq->companies()->count()) {
            // Allow if the user has companies which are among the allowed ones
            if ($faq->companies()->whereIn('companies.id', $user->roleUsers()->pluck('company_id')->toArray())->exists()) {
                return true;
            }

            // Disallow if not
            return false;
        }

        // Allow if no user/company restrictions are set for the FAQ
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Faq  $faq
     *
     * @return bool
     */
    public function delete(User $user, Faq $faq)
    {
        if ($user->hasPermission(Permission::TYPE_FAQ)) {
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
     * @param User $user
     *
     * @return bool
     */
    public function sort(User $user)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_AGENT)) {
            return true;
        }

        return false;
    }
}
