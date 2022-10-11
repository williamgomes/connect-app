<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ApiApplicationToken\ApiApplicationTokenCreateRequest;
use App\Models\ApiApplication;
use App\Models\ApiApplicationToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiApplicationTokenController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\ApiApplication $apiApplication
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(ApiApplication $apiApplication)
    {
        $this->authorize('create', ApiApplicationToken::class);

        return view('app.api-applications.tokens.create')->with([
            'token'          => Str::random(100),
            'apiApplication' => $apiApplication,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApiApplicationTokenCreateRequest $request
     * @param \App\Models\ApiApplication       $apiApplication
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ApiApplicationTokenCreateRequest $request, ApiApplication $apiApplication)
    {
        $this->authorize('create', ApiApplicationToken::class);

        ApiApplicationToken::create([
            'api_application_id' => $apiApplication->id,
            'created_by'         => $request->user()->id,
            'identifier'         => strtolower($request->identifier),
            'api_token'          => hash('sha256', $request->token),
        ]);

        return redirect()->action('App\ApiApplicationController@show', $apiApplication)
            ->with('success', __('The application token was successfully created.'));
    }

    /**
     * Revoke the specified resource in storage.
     *
     * @param \Illuminate\Http\Request        $request
     * @param \App\Models\ApiApplication      $apiApplication
     * @param \App\Models\ApiApplicationToken $apiApplicationToken
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function revoke(Request $request, ApiApplication $apiApplication, ApiApplicationToken $apiApplicationToken)
    {
        $this->authorize('revoke', $apiApplicationToken);

        // Revoke application
        $apiApplicationToken->update([
            'revoked_by' => $request->user()->id,
            'revoked_at' => Carbon::now(),
        ]);

        return redirect()->action('App\ApiApplicationController@show', $apiApplication)
            ->with('success', __('The application token was successfully revoked.'));
    }
}
