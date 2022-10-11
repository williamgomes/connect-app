<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ItService\ItServiceCreateRequest;
use App\Http\Requests\App\ItService\ItServiceUpdateRequest;
use App\Models\ItService;
use Illuminate\Http\Request;

class ItServiceController extends Controller
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
        $this->authorize('viewAny', ItService::class);

        $itServiceQuery = ItService::query();

        if ($request->has('search')) {
            $itServiceQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('identifier', 'LIKE', '%' . $request->search . '%')
                ->orWhere('note', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.it-services.index')->with([
            'itServices' => $itServiceQuery->paginate(25),
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
        $this->authorize('create', ItService::class);

        return view('app.it-services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ItServiceCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ItServiceCreateRequest $request)
    {
        $this->authorize('create', ItService::class);

        ItService::create($request->only(['name', 'identifier', 'note']));

        return redirect()->action('App\ItServiceController@index')
            ->with('success', __('The IT Service was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ItService $itService
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ItService $itService)
    {
        $this->authorize('update', $itService);

        return view('app.it-services.edit')->with([
            'itService' => $itService,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ItServiceUpdateRequest $request
     * @param \App\Models\ItService  $itService
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ItServiceUpdateRequest $request, ItService $itService)
    {
        $this->authorize('update', $itService);

        $itService->update($request->only(['name', 'identifier', 'note']));

        return redirect()->action('App\ItServiceController@index')
            ->with('success', __('The IT Service was successfully updated.'));
    }

    /**
     * @param ItService $itService
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ItService $itService)
    {
        $this->authorize('delete', $itService);

        $itService->delete();

        return redirect()->action('App\ItServiceController@index')
            ->with('info', __('The IT Service was successfully deleted.'));
    }
}
