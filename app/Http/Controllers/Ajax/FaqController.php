<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Update order for all resources.
     *
     * @param Request     $request
     * @param FaqCategory $faqCategory
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        // Validate the input
        $this->validate($request, [
            'items' => 'required|array',
        ]);

        Faq::sort($request->all());

        return response()->json(['order' => $request->input('items')]);
    }
}
