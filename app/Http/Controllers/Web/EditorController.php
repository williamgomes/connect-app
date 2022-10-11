<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    /**
     * @param string $path
     * @param string $fileName
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $path, string $fileName)
    {
        $fullPath = $path . '/' . $fileName;

        if (!Storage::disk('s3')->has($fullPath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $file = Storage::disk('s3')->get($fullPath);
        $mimeType = Storage::disk('s3')->mimeType($fullPath);

        return response()->make($file, 200)->header('Content-Type', $mimeType);
    }
}
