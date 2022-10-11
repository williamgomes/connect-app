<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Role\RoleCreateRequest;
use App\Http\Requests\App\Role\RoleUpdateRequest;
use App\Models\Application;
use App\Models\Directory;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $roleQuery = Role::query();

        if ($request->has('search')) {
            $roleQuery->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.roles.index')->with([
            'roles' => $roleQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $directories = Directory::all();

        return view('app.roles.create')->with([
            'directories' => $directories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleCreateRequest $request)
    {
        $this->authorize('create', Role::class);

        Role::create($request->only(['directory_id', 'name']));

        return redirect()->action('App\RoleController@index')
            ->with('success', __('The role was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Role $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $applications = Application::where('directory_id', $role->directory_id)->get();
        $directories = Directory::all();

        return view('app.roles.edit')->with([
            'role'         => $role,
            'applications' => $applications,
            'directories'  => $directories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleUpdateRequest $request
     * @param \App\Models\Role  $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->update(array_merge($request->only('directory_id', 'name'), [
            'x_data' => $request->only('applications'),
        ]));

        return redirect()->action('App\RoleController@index')
            ->with('success', __('The role was successfully updated.'));
    }

    /**
     * @param Role $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        $role->delete();

        return redirect()->action('App\RoleController@index')
            ->with('info', __('The role was successfully deleted.'));
    }
}
