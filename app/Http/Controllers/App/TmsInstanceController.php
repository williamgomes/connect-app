<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\TmsInstance\TmsInstanceCreateRequest;
use App\Http\Requests\App\TmsInstance\TmsInstanceUpdateRequest;
use App\Models\TmsInstance;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class TmsInstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', TmsInstance::class);

        $tmsInstanceQuery = TmsInstance::query();

        if ($request->has('search')) {
            $tmsInstanceQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('identifier', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.tms-instances.index')->with([
            'tmsInstances' => $tmsInstanceQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', TmsInstance::class);

        return view('app.tms-instances.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TmsInstanceCreateRequest $request
     *
     * @throws AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TmsInstanceCreateRequest $request)
    {
        $this->authorize('create', TmsInstance::class);

        TmsInstance::create($request->only(['name', 'identifier', 'base_url', 'bearer_token']));

        return redirect()->action('App\TmsInstanceController@index')
            ->with('success', __('The TMS instance was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TmsInstance $tmsInstance
     *
     * @throws AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(TmsInstance $tmsInstance)
    {
        $this->authorize('update', $tmsInstance);

        return view('app.tms-instances.edit')->with([
            'tmsInstance' => $tmsInstance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TmsInstanceUpdateRequest $request
     * @param TmsInstance              $tmsInstance
     *
     * @throws AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TmsInstanceUpdateRequest $request, TmsInstance $tmsInstance)
    {
        $this->authorize('update', $tmsInstance);

        $tmsInstance->update($request->only(['name', 'identifier', 'base_url', 'bearer_token']));

        return redirect()->action('App\TmsInstanceController@index')
            ->with('success', __('The TMS instance was successfully updated.'));
    }

    /**
     * @param TmsInstance $tmsInstance
     *
     * @throws AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TmsInstance $tmsInstance)
    {
        $this->authorize('delete', $tmsInstance);

        $tmsInstance->delete();

        return redirect()->action('App\TmsInstanceController@index')
            ->with('info', __('The TMS instance was successfully deleted.'));
    }
}
