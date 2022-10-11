<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\ApiApplicationToken as ApiApplicationTokenResource;
use Illuminate\Http\Request;

class ApiApplicationController extends Controller
{
    /**
     * ApiApplicationController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Identify the specified resource.
     *
     * @return ApiApplicationTokenResource $apiApplication
     */
    public function identify(Request $request)
    {
        return new ApiApplicationTokenResource($request->user());
    }
}
