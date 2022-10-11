<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Directory;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    /**
     * Return object of the model.
     *
     * @param Request   $request
     * @param Directory $directory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Directory $directory)
    {
        $this->authorize('view', $directory);

        return response()->json([
            'data' => $directory,
        ]);
    }

    /**
     * Return companies of the directory.
     *
     * @param Request   $request
     * @param Directory $directory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function companies(Request $request, Directory $directory)
    {
        $this->authorize('view', $directory);

        return response()->json([
            'data' => $directory->companies,
        ]);
    }
}
