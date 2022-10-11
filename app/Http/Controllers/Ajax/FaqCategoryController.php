<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FaqCategoryController extends Controller
{
    /**
     * @param Request $request
     *
     * @throws ValidationException
     *
     * @return JsonResponse
     */
    public function sort(Request $request)
    {
        // Validate the input
        $this->validate($request, [
            'items' => 'required|array',
        ]);

        FaqCategory::sort($request->all());

        return response()->json(['order' => $request->input('items')]);
    }
}
