<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $faqCategories = FaqCategory::main()->orderBy('order')->active()->get();

        return view('web.faq.categories.index')->with([
            'faqCategories' => $faqCategories,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request     $request
     * @param FaqCategory $faqCategory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, FaqCategory $faqCategory)
    {
        $faqs = $faqCategory->faqs()->where('active', Faq::IS_ACTIVE)->get();
        $faqCategories = $faqCategory->categories()->active()->get();

        return view('web.faq.categories.show')->with([
            'faqCategory'   => $faqCategory,
            'faqCategories' => $faqCategories,
            'faqs'          => $faqs,
        ]);
    }
}
