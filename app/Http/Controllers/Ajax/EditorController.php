<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    /**
     * @param Request $request
     * @param string  $path
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, string $path)
    {
        $file = $request->file('file');

        $uploadedFilePath = Storage::disk('s3')->putFile($path, $file);

        return response()->json([
            'location' => action('Web\EditorController@show', [$path, basename($uploadedFilePath)]),
        ]);
    }
}
