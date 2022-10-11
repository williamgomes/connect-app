<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\FaqCategory\FaqCategoryCreateRequest;
use App\Http\Requests\App\FaqCategory\FaqCategoryUpdateRequest;
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
        // Authorize request
        $this->authorize('viewAny', FaqCategory::class);

        $faqCategories = FaqCategory::main()->orderBy('order')->get();

        return view('app.faq.categories.index')->with([
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
        // Authorize request
        $this->authorize('view', $faqCategory);

        return view('app.faq.categories.show')->with([
            'faqCategory'   => $faqCategory,
            'faqCategories' => $faqCategory->categories,
            'faqs'          => $faqCategory->faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $request->validate([
            'category_id' => 'sometimes|integer|exists:faq_categories,id',
        ]);

        // Authorize request
        $this->authorize('create', FaqCategory::class);

        $faqCategory = null;
        if ($request->has('category_id')) {
            $faqCategory = FaqCategory::find($request->input('category_id'));
        }

        return view('app.faq.categories.create', [
            'faqCategory' => $faqCategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FaqCategoryCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FaqCategoryCreateRequest $request)
    {
        // Authorize request
        $this->authorize('create', FaqCategory::class);

        $faqCategory = FaqCategory::create($request->only([
            'category_id',
            'name',
            'active',
        ]));

        return redirect()->action('App\FaqCategoryController@show', $faqCategory)
            ->with('success', __('FAQ category was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FaqCategory $faqCategory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(FaqCategory $faqCategory)
    {
        // Authorize request
        $this->authorize('update', $faqCategory);

        return view('app.faq.categories.edit')->with([
            'faqCategory' => $faqCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FaqCategoryUpdateRequest $request
     * @param FaqCategory              $faqCategory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FaqCategoryUpdateRequest $request, FaqCategory $faqCategory)
    {
        // Authorize request
        $this->authorize('update', $faqCategory);

        $faqCategory->update($request->only(['name', 'active']));

        return redirect()->action('App\FaqCategoryController@show', $faqCategory)
            ->with('success', __('FAQ category was successfully updated.'));
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param Request     $request
     * @param FaqCategory $faqCategory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, FaqCategory $faqCategory)
    {
        // Authorize request
        $this->authorize('delete', $faqCategory);

        $faqCategory->delete();

        $message = __('FAQ category was successfully deleted.');

        if ($faqCategory->parent) {
            return redirect()
                ->action('App\FaqCategoryController@show', $faqCategory->parent)
                ->with('info', $message);
        }

        return redirect()
            ->action('App\FaqCategoryController@index')
            ->with('info', $message);
    }
}
