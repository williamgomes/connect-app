<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Application\ApplicationCreateRequest;
use App\Http\Requests\App\Application\ApplicationUpdateRequest;
use App\Jobs\OneLogin\DeleteOneLoginApplicationAndRole;
use App\Models\Application;
use App\Models\Directory;
use Illuminate\Http\Request;

class ApplicationController extends Controller
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
        $this->authorize('viewAny', Application::class);

        $applicationQuery = Application::query();
        if ($request->has('search')) {
            $applicationQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('signup_url', 'LIKE', '%' . $request->search . '%')
                ->orWhere('onelogin_role_id', 'LIKE', '%' . $request->search . '%')
                ->orWhere('onelogin_app_id', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.applications.index')->with([
            'applications' => $applicationQuery->paginate(25),
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
        $this->authorize('create', Application::class);

        $directories = Directory::all();

        return view('app.applications.create')->with([
            'directories'  => $directories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApplicationCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ApplicationCreateRequest $request)
    {
        $this->authorize('create', Application::class);

        $application = Application::create($request->only([
            'directory_id',
            'onelogin_app_id',
            'name',
            'sso',
            'provisioning',
            'signup_url',
        ]));

        return redirect()->action('App\ApplicationController@index')
            ->with('success', __('The application was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Application $application
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Application $application)
    {
        $this->authorize('update', $application);

        $directories = Directory::all();

        return view('app.applications.edit')->with([
            'application'  => $application,
            'directories'  => $directories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApplicationUpdateRequest $request
     * @param \App\Models\Application  $application
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApplicationUpdateRequest $request, Application $application)
    {
        $this->authorize('update', $application);

        $application->update($request->only([
            'directory_id',
            'name',
            'sso',
            'provisioning',
            'signup_url',
        ]));

        return redirect()->action('App\ApplicationController@index')
            ->with('success', __('The application was successfully updated.'));
    }

    /**
     * @param Application $application
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);

        // Delete OneLogin Role and App
        DeleteOneLoginApplicationAndRole::dispatch($application);

        return redirect()->action('App\ApplicationController@index')
            ->with('info', __('The application was successfully deleted.'));
    }
}
