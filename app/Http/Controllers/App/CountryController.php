<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Country\CountryCreateRequest;
use App\Http\Requests\App\Country\CountryUpdateRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
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
        $this->authorize('viewAny', Country::class);

        $countryQuery = Country::query();

        if ($request->has('search')) {
            $countryQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('identifier', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.countries.index')->with([
            'countries' => $countryQuery->paginate(25),
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
        $this->authorize('create', Country::class);

        return view('app.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CountryCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CountryCreateRequest $request)
    {
        $this->authorize('create', Country::class);

        Country::create($request->only(['name', 'identifier', 'active']));

        return redirect()->action('App\CountryController@index')
            ->with('success', __('The country was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Country $country
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        $this->authorize('update', $country);

        return view('app.countries.edit')->with([
            'country' => $country,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountryUpdateRequest $request
     * @param \App\Models\Country  $country
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CountryUpdateRequest $request, Country $country)
    {
        $this->authorize('update', $country);

        $country->update($request->only(['name', 'identifier', 'active']));

        return redirect()->action('App\CountryController@index')
            ->with('success', __('The country was successfully updated.'));
    }

    /**
     * @param Country $country
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Country $country)
    {
        $this->authorize('delete', $country);

        $country->delete();

        return redirect()->action('App\CountryController@index')
            ->with('info', __('The country was successfully deleted.'));
    }
}
