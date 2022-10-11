<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Datacenter\DatacenterCreateRequest;
use App\Http\Requests\App\Datacenter\DatacenterUpdateRequest;
use App\Models\Datacenter;
use Illuminate\Http\Request;

class DatacenterController extends Controller
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
        $this->authorize('viewAny', Datacenter::class);

        $datacenterQuery = Datacenter::query();

        if ($request->has('search')) {
            $datacenterQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('identifier', 'LIKE', '%' . $request->search . '%')
                ->orWhere('note', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.datacenters.index')->with([
            'datacenters' => $datacenterQuery->paginate(25),
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
        $this->authorize('create', Datacenter::class);

        return view('app.datacenters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DatacenterCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DatacenterCreateRequest $request)
    {
        $this->authorize('create', Datacenter::class);

        Datacenter::create($request->only(['name', 'country', 'location', 'location_id', 'note']));

        return redirect()->action('App\DatacenterController@index')
            ->with('success', __('The Datacenter was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Datacenter $datacenter
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Datacenter $datacenter)
    {
        $this->authorize('update', $datacenter);

        return view('app.datacenters.edit')->with([
            'datacenter' => $datacenter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DatacenterUpdateRequest $request
     * @param \App\Models\Datacenter  $datacenter
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(DatacenterUpdateRequest $request, Datacenter $datacenter)
    {
        $this->authorize('update', $datacenter);

        $datacenter->update($request->only(['name', 'country', 'location', 'location_id', 'note']));

        return redirect()->action('App\DatacenterController@index')
            ->with('success', __('The Datacenter was successfully updated.'));
    }

    /**
     * @param Datacenter $datacenter
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Datacenter $datacenter)
    {
        $this->authorize('delete', $datacenter);

        $datacenter->delete();

        return redirect()->action('App\DatacenterController@index')
            ->with('info', __('The Datacenter was successfully deleted.'));
    }
}
