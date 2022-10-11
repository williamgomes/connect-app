<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Return subcategories of the category.
     *
     * @param Request  $request
     * @param Category $category
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subcategories(Request $request, Category $category)
    {
        $this->authorize('viewAnySubcategory', $category);

        return response()->json([
            'data' => $category->subcategories,
        ]);
    }

    /**
     * @param Request  $request
     * @param Category $category
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fields(Request $request, Category $category)
    {
        $html = view('web.tickets.partials.category-fields', [
            'category' => $category,
        ])->render();

        return response()->json([
            'html' => $html,
        ]);
    }
}
