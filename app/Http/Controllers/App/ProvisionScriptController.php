<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ProvisionScript\ProvisionScriptCreateRequest;
use App\Http\Requests\App\ProvisionScript\ProvisionScriptUpdateRequest;
use App\Models\ItService;
use App\Models\ProvisionScript;
use Illuminate\Http\Request;

class ProvisionScriptController extends Controller
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
        $this->authorize('viewAny', ProvisionScript::class);

        $provisionScriptQuery = ProvisionScript::query();

        if ($request->has('search')) {
            $provisionScriptQuery->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('itService', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('identifier', 'LIKE', '%' . $request->search . '%');
                });
        }

        return view('app.provision-scripts.index')->with([
            'provisionScripts' => $provisionScriptQuery->paginate(25),
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
        $this->authorize('create', ProvisionScript::class);

        return view('app.provision-scripts.create')->with([
            'itServices' => ItService::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProvisionScriptCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProvisionScriptCreateRequest $request)
    {
        $this->authorize('create', ProvisionScript::class);

        ProvisionScript::create($request->only([
            'it_service_id',
            'title',
            'content',
        ]));

        return redirect()->action('App\ProvisionScriptController@index')
            ->with('success', __('The Provision Script was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProvisionScript $provisionScript
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ProvisionScript $provisionScript)
    {
        $this->authorize('update', $provisionScript);

        return view('app.provision-scripts.edit')->with([
            'provisionScript' => $provisionScript,
            'itServices'      => ItService::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProvisionScriptUpdateRequest $request
     * @param \App\Models\ProvisionScript  $provisionScript
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProvisionScriptUpdateRequest $request, ProvisionScript $provisionScript)
    {
        $this->authorize('update', $provisionScript);

        $provisionScript->update($request->only([
            'it_service_id',
            'title',
            'content',
        ]));

        return redirect()->action('App\ProvisionScriptController@index')
            ->with('success', __('The Provision Script was successfully updated.'));
    }

    /**
     * @param ProvisionScript $provisionScript
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProvisionScript $provisionScript)
    {
        $this->authorize('delete', $provisionScript);

        $provisionScript->delete();

        return redirect()->action('App\ProvisionScriptController@index')
            ->with('info', __('The Provision Script was successfully deleted.'));
    }
}
