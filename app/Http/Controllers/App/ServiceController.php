<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Service\ServiceCreateRequest;
use App\Http\Requests\App\Service\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Service::class);

        $serviceQuery = Service::query();

        if ($request->has('search')) {
            $serviceQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('identifier', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.services.index')->with([
            'services' => $serviceQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Service::class);

        return view('app.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceCreateRequest $request)
    {
        $this->authorize('create', Service::class);

        Service::create($request->only(['name', 'identifier', 'active']));

        return redirect()->action('App\ServiceController@index')
            ->with('success', __('The service was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Service $service
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $this->authorize('update', $service);

        return view('app.services.edit')->with([
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceUpdateRequest $request
     * @param \App\Models\Service  $service
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceUpdateRequest $request, Service $service)
    {
        $this->authorize('update', $service);

        $service->update($request->only(['name', 'identifier', 'active']));

        return redirect()->action('App\ServiceController@index')
            ->with('success', __('The service was successfully updated.'));
    }

    /**
     * @param Service $service
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        $service->delete();

        return redirect()->action('App\ServiceController@index')
            ->with('info', __('The service was successfully deleted.'));
    }
}
