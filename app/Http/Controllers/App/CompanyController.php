<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Company\CompanyCreateRequest;
use App\Http\Requests\App\Company\CompanyUpdateRequest;
use App\Models\Application;
use App\Models\ApplicationRole;
use App\Models\Company;
use App\Models\Country;
use App\Models\Directory;
use App\Models\Role;
use App\Models\Service;
use App\Models\TmsInstance;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $this->authorize('viewAny', Company::class);

        $companyQuery = Company::query();

        if ($request->has('search')) {
            $companyQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('country', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhereHas('service', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhereHas('tmsInstance', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhereHas('directory', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                });
        }

        return view('app.companies.index')->with([
            'companies' => $companyQuery->paginate(25),
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
        $this->authorize('create', Company::class);

        $services = Service::active()->get();
        $countries = Country::active()->get();
        $tmsInstances = TmsInstance::all();
        $directories = Directory::all();

        return view('app.companies.create')->with([
            'services'     => $services,
            'countries'    => $countries,
            'tmsInstances' => $tmsInstances,
            'directories'  => $directories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CompanyCreateRequest $request)
    {
        $this->authorize('create', Company::class);

        Company::create($request->only([
            'directory_id',
            'name',
            'country_id',
            'service_id',
            'tms_instance_id',
        ]));

        return redirect()->action('App\CompanyController@index')
            ->with('success', __('The company was successfully created.'));
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\Company $company
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return view('app.companies.show')->with([
            'company' => $company,
            'roles'   => Role::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {
        $this->authorize('update', $company);

        $services = Service::active()->get();
        $countries = Country::active()->get();
        $tmsInstances = TmsInstance::all();
        $directories = Directory::all();

        return view('app.companies.edit')->with([
            'company'      => $company,
            'services'     => $services,
            'countries'    => $countries,
            'tmsInstances' => $tmsInstances,
            'directories'  => $directories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyUpdateRequest $request
     * @param \App\Models\Company  $company
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $company->update($request->only([
            'directory_id',
            'name',
            'country_id',
            'service_id',
            'tms_instance_id',
        ]));

        return redirect()->action('App\CompanyController@index')
            ->with('success', __('The company was successfully updated.'));
    }

    /**
     * @param Company $company
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return redirect()->action('App\CompanyController@index')
            ->with('info', __('The company was successfully deleted.'));
    }

    /**
     * @param Request $request
     * @param Company $company
     * @param Role    $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function editRole(Request $request, Company $company, Role $role)
    {
        $this->authorize('update', $company);

        $rootApplicationIds = ApplicationRole::whereNull('company_id')
            ->where('role_id', $role->id)
            ->pluck('application_id');

        $applicationIds = ApplicationRole::where('company_id', $company->id)
            ->where('role_id', $role->id)
            ->pluck('application_id');

        return view('app.companies.roles.edit')->with([
            'company'            => $company,
            'role'               => $role,
            'applications'       => Application::all(),
            'rootApplicationIds' => $rootApplicationIds,
            'applicationIds'     => $applicationIds,
        ]);
    }

    /**
     * @param Request $request
     * @param Company $company
     * @param Role    $role
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRole(Request $request, Company $company, Role $role)
    {
        $this->authorize('update', $company);

        $company->update([
            'x_data' => array_merge($request->only(['applications']), [
                'role_id' => $role->id,
            ]),
        ]);

        return redirect()->action('App\CompanyController@show', $company)
            ->with('success', __('The role was successfully updated.'));
    }
}
