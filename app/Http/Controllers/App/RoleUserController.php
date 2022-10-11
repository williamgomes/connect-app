<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    /**
     * Display role users.
     *
     * @param Request $request
     * @param User    $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request, User $user)
    {
        $this->authorize('create', RoleUser::class);

        $roles = Role::all();
        $roleDirectoryIds = $roles->pluck('directory_id', 'id');

        return view('app.users.roles.create')->with([
            'user'             => $user,
            'companies'        => Company::all(),
            'roles'            => $roles,
            'roleDirectoryIds' => $roleDirectoryIds,
        ]);
    }

    /**
     * Display role users.
     *
     * @param Request $request
     * @param User    $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', RoleUser::class);

        RoleUser::create(array_merge($request->only([
            'role_id',
            'company_id',
        ]), [
            'user_id' => $user->id,
        ]));

        return redirect()->action('App\UserController@show', $user)
            ->with('success', __('The role was successfully added'));
    }

    /**
     * @param RoleUser $roleUser
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RoleUser $roleUser)
    {
        $this->authorize('delete', $roleUser);

        $roleUser->delete();

        return redirect()->action('App\UserController@show', $roleUser->user)
            ->with('info', __('The role was successfully unassigned.'));
    }
}
