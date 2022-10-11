<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Directory\DirectoryCreateRequest;
use App\Http\Requests\App\Directory\DirectoryUpdateRequest;
use App\Models\Directory;
use Illuminate\Http\Request;

class DirectoryController extends Controller
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
        $this->authorize('viewAny', Directory::class);

        return view('app.directories.index')->with([
            'directories' => Directory::paginate(25),
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
        $this->authorize('create', Directory::class);

        return view('app.directories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DirectoryCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DirectoryCreateRequest $request)
    {
        $this->authorize('create', Directory::class);

        Directory::create($request->only([
            'name',
            'slug',
            'onelogin_tenant_url',
            'onelogin_api_url',
            'onelogin_client_id',
            'onelogin_secret_key',
            'onelogin_default_role',
            'duo_integration_key',
            'duo_secret_key',
            'duo_api_url',
            'saml_entity_id',
            'saml_sso_url',
            'saml_slo_url',
            'saml_cfi',
            'saml_contact_name',
            'saml_contact_email',
            'saml_organization_name',
            'saml_website_url',
        ]));

        return redirect()->action('App\DirectoryController@index')
            ->with('success', __('The directory was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Directory $directory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Directory $directory)
    {
        $this->authorize('update', $directory);

        return view('app.directories.edit')->with([
            'directory' => $directory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DirectoryUpdateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DirectoryUpdateRequest $request, Directory $directory)
    {
        $this->authorize('update', $directory);

        $directory->update($request->only([
            'name',
            'slug',
            'onelogin_tenant_url',
            'onelogin_api_url',
            'onelogin_client_id',
            'onelogin_secret_key',
            'onelogin_default_role',
            'duo_integration_key',
            'duo_secret_key',
            'duo_api_url',
            'saml_entity_id',
            'saml_sso_url',
            'saml_slo_url',
            'saml_cfi',
            'saml_contact_name',
            'saml_contact_email',
            'saml_organization_name',
            'saml_website_url',
        ]));

        return redirect()->action('App\DirectoryController@index')
            ->with('success', __('The directory was successfully updated.'));
    }

    /**
     * @param Directory $directory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Directory $directory)
    {
        $this->authorize('delete', $directory);

        $directory->delete();

        return redirect()->action('App\DirectoryController@index')
            ->with('info', __('The directory was successfully deleted.'));
    }
}
