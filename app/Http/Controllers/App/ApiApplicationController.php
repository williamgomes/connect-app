<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ApiApplication\ApiApplicationCreateRequest;
use App\Http\Requests\App\ApiApplication\ApiApplicationUpdateRequest;
use App\Models\ApiApplication;
use App\Models\ModelAccess;
use Illuminate\Http\Request;

class ApiApplicationController extends Controller
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
        $this->authorize('viewAny', ApiApplication::class);

        $apiApplicationQuery = ApiApplication::query();

        if ($request->has('search')) {
            $apiApplicationQuery->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.api-applications.index')->with([
            'apiApplications' => $apiApplicationQuery->paginate(25),
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
        $this->authorize('create', ApiApplication::class);

        return view('app.api-applications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApiApplicationCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ApiApplicationCreateRequest $request)
    {
        $this->authorize('create', ApiApplication::class);

        $apiApplication = ApiApplication::create($request->all());

        return redirect()->action('App\ApiApplicationController@show', $apiApplication)
            ->with('success', __('The application was successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param ApiApplication $apiApplication
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(ApiApplication $apiApplication)
    {
        $this->authorize('view', $apiApplication);

        $apiApplicationTokens = $apiApplication->tokens()
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('app.api-applications.show')->with([
            'apiApplication'       => $apiApplication,
            'apiApplicationTokens' => $apiApplicationTokens,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ApiApplication $apiApplication
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(ApiApplication $apiApplication)
    {
        $this->authorize('update', $apiApplication);

        $modelAccesses = ModelAccess::with('abilities')->get();
        $apiApplicationModelAccesses = $apiApplication->modelAccesses()->pluck('model_accesses.id')->toArray();
        $apiApplicationModelAccessAbilities = $apiApplication->modelAccessAbilities()->pluck('model_access_abilities.id')->toArray();

        return view('app.api-applications.edit')->with([
            'apiApplication'                     => $apiApplication,
            'modelAccesses'                      => $modelAccesses,
            'apiApplicationModelAccesses'        => $apiApplicationModelAccesses,
            'apiApplicationModelAccessAbilities' => $apiApplicationModelAccessAbilities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApiApplicationUpdateRequest $request
     * @param ApiApplication              $apiApplication
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApiApplicationUpdateRequest $request, ApiApplication $apiApplication)
    {
        $this->authorize('update', $apiApplication);

        $apiApplication->update(array_merge($request->only('name'), [
            'x_data' => $request->only(['model_accesses', 'model_access_abilities']),
        ]));

        return redirect()->action('App\ApiApplicationController@show', $apiApplication)
            ->with('success', __('The application was successfully updated.'));
    }
}
