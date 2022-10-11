<?php

namespace App\Policies;

use App\Models\FaqCategory;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqCategoryPolicy
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
     * Determine whether the user can view the model.
     *
     * @param User        $user
     * @param FaqCategory $faqCategory
     *
     * @return bool
     */
    public function view(User $user, FaqCategory $faqCategory)
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
     * @param User        $user
     * @param FaqCategory $faqCategory
     *
     * @return bool
     */
    public function update(User $user, FaqCategory $faqCategory)
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
     * Determine whether the user can delete the model.
     *
     * @param User        $user
     * @param FaqCategory $faqCategory
     *
     * @return bool
     */
    public function delete(User $user, FaqCategory $faqCategory)
    {
        if ($faqCategory->categories()->count()) {
            return false;
        }

        if ($faqCategory->faqs()->count()) {
            return false;
        }

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
