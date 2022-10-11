<?php

namespace App\Http\Controllers\App;

use App\Helpers\PasswordHelper;
use App\Http\Controllers\Controller;
use App\Jobs\ActivateUserApplication;
use App\Jobs\DeactivateUserApplication;
use App\Models\Application;
use App\Models\ApplicationUser;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationUserController extends Controller
{
    /**
     * @param Request     $request
     * @param User        $user
     * @param Application $application
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function regeneratePasswordForm(Request $request, User $user, Application $application)
    {
        $this->authorize('view', $user);

        return view('app.users.applications.regenerate-password')->with([
            'user'        => $user,
            'application' => $application,
        ]);
    }

    /**
     * @param Request     $request
     * @param User        $user
     * @param Application $application
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function regeneratePassword(Request $request, User $user, Application $application)
    {
        $this->authorize('view', $user);

        $request->validate([
            'length'          => 'required|integer|min:8|max:255',
            'upper_case'      => 'required|boolean',
            'lower_case'      => 'required|boolean',
            'numbers'         => 'required|boolean',
            'special_symbols' => 'required|boolean',
        ]);

        $newPassword = PasswordHelper::generate($request->length, array_keys(array_filter($request->only([
            'upper_case',
            'lower_case',
            'numbers',
            'special_symbols',
        ]), function ($value) {
            // Filter out disabled checkboxes results
            return $value;
        })));

        $applicationUser = ApplicationUser::where('application_id', $application->id)
            ->where('user_id', $user->id)
            ->first();

        $applicationUser->update([
            'password' => $newPassword,
        ]);

        return redirect()->action('App\UserController@show', $user)
            ->with('success', __('Password successfully re-generated.'));
    }

    /**
     * @param Request $request
     * @param User    $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request, User $user)
    {
        $this->authorize('create', ApplicationUser::class);

        $directApplicationUserIds = $user->applicationUsers()
            ->where('direct', ApplicationUser::IS_DIRECT)
            ->where('active', ApplicationUser::IS_ACTIVE)
            ->pluck('application_id');

        $applications = Application::whereNotIn('id', $directApplicationUserIds)->get();

        return view('app.users.applications.create')->with([
            'user'         => $user,
            'applications' => $applications,
        ]);
    }

    /**
     * @param Request $request
     * @param User    $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'application_id' => 'required|integer|exists:applications,id',
        ]);

        $this->authorize('create', ApplicationUser::class);

        $application = Application::find($request->input('application_id'));

        ActivateUserApplication::dispatch($application, $user, ApplicationUser::IS_DIRECT);

        return redirect()->action('App\UserController@show', $user)
            ->with('success', __('Application successfully added.'));
    }

    /**
     * @param Request         $request
     * @param ApplicationUser $applicationUser
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, ApplicationUser $applicationUser)
    {
        $this->authorize('delete', $applicationUser);

        DeactivateUserApplication::dispatch($applicationUser, ApplicationUser::IS_DIRECT);

        return redirect()->action('App\UserController@show', $applicationUser->user)
            ->with('info', __('Application access successfully revoked.'));
    }
}
