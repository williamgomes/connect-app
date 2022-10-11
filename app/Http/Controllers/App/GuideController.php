<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Guide\GuideCreateRequest;
use App\Http\Requests\App\Guide\GuideUpdateRequest;
use App\Models\Guide;
use App\Models\Inventory;
use Illuminate\Http\Request;

class GuideController extends Controller
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
        $this->authorize('viewAny', Guide::class);

        $guideQuery = Guide::query();

        if ($request->has('search')) {
            $guideQuery->where('title', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.guides.index')->with([
            'guides' => $guideQuery->paginate(25),
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
        $this->authorize('create', Guide::class);

        return view('app.guides.create')->with([
            'inventories' => Inventory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GuideCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GuideCreateRequest $request)
    {
        $this->authorize('create', Guide::class);

        Guide::create(array_merge($request->only(['title', 'content']), [
            'author_id' => $request->user()->id,
            'x_data'    => [
                'inventories' => $request->input('inventories') ?? [],
            ],
        ]));

        return redirect()->action('App\GuideController@index')
            ->with('success', __('The Guide was successfully created.'));
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param \App\Models\Guide $guide
     * @param                   $inventoryId
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Guide $guide, $inventoryId = null)
    {
        $this->authorize('view', $guide);

        return view('app.guides.show')->with([
            'guide'     => $guide,
            'inventory' => Inventory::find($inventoryId),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Guide $guide
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Guide $guide)
    {
        $this->authorize('update', $guide);

        return view('app.guides.edit')->with([
            'guide'       => $guide,
            'inventories' => Inventory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GuideUpdateRequest $request
     * @param \App\Models\Guide  $guide
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GuideUpdateRequest $request, Guide $guide)
    {
        $this->authorize('update', $guide);

        $guide->update(array_merge($request->only(['title', 'content']), [
            'author_id' => $request->user()->id,
            'x_data'    => [
                'inventories' => $request->input('inventories') ?? [],
            ],
        ]));

        return redirect()->action('App\GuideController@index')
            ->with('success', __('The Guide was successfully updated.'));
    }

    /**
     * @param Guide $guide
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Guide $guide)
    {
        $this->authorize('delete', $guide);

        $guide->delete();

        return redirect()->action('App\GuideController@index')
            ->with('info', __('The Guide was successfully deleted.'));
    }
}
