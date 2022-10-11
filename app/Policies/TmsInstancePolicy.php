<?php

namespace App\Policies;

use App\Models\TmsInstance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TmsInstancePolicy
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
        if ($user->hasRole(User::ROLE_ADMIN)) {
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
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User        $user
     * @param TmsInstance $tmsInstance
     *
     * @return mixed
     */
    public function update(User $user, TmsInstance $tmsInstance)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User        $user
     * @param TmsInstance $tmsInstance
     *
     * @return mixed
     */
    public function delete(User $user, TmsInstance $tmsInstance)
    {
        if ($tmsInstance->companies()->count()) {
            return false;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view any model report.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAnyReport(User $user)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_REPORTING)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the specific model report.
     *
     * @param User        $user
     * @param TmsInstance $tmsInstance
     *
     * @return mixed
     */
    public function viewReport(User $user, TmsInstance $tmsInstance)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        if ($user->hasRole(User::ROLE_REPORTING)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update budget values.
     *
     * @param User        $user
     * @param TmsInstance $tmsInstance
     *
     * @return bool
     */
    public function updateBudget(User $user, TmsInstance $tmsInstance)
    {
        if ($this->viewReport($user, $tmsInstance)) {
            return true;
        }

        return false;
    }
}
