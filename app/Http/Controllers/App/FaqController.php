<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Faq\FaqCreateRequest;
use App\Http\Requests\App\Faq\FaqUpdateRequest;
use App\Models\Company;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\User;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param FaqCategory              $faqCategory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request, FaqCategory $faqCategory)
    {
        // Authorize request
        $this->authorize('create', Faq::class);

        return view('app.faq.create')->with([
            'faqCategory' => $faqCategory,
        ]);
    }

    /**
     * Create the specified resource in storage.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FaqCreateRequest $request, FaqCategory $faqCategory)
    {
        // Authorize request
        $this->authorize('create', Faq::class);

        Faq::create(array_merge($request->only([
            'title',
            'content',
            'active',
        ]), [
            'category_id' => $faqCategory->id,
            'user_id'     => $request->user()->id,
        ]));

        return redirect()->action('App\FaqCategoryController@show', $faqCategory)
            ->with('success', __('FAQ was successfully created.'));
    }

    /**
     * Show the edit form for a Faq entity.
     *
     * @param \Illuminate\Http\Request $request
     * @param FaqCategory              $faqCategory
     * @param Faq                      $faq
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request, FaqCategory $faqCategory, Faq $faq)
    {
        // Authorize request
        $this->authorize('update', $faq);

        $users = User::all();
        $authors = User::whereIn('role', [User::ROLE_AGENT, User::ROLE_ADMIN])->get();
        $companies = Company::all();

        return view('app.faq.edit')->with([
            'faq'       => $faq,
            'users'     => $users,
            'authors'   => $authors,
            'companies' => $companies,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FaqUpdateRequest $request
     * @param FaqCategory      $faqCategory
     * @param Faq              $faq
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FaqUpdateRequest $request, FaqCategory $faqCategory, Faq $faq)
    {
        // Authorize request
        $this->authorize('update', $faq);

        $faq->update(array_merge($request->only([
            'title',
            'content',
            'user_id',
            'active',
        ]), [
            'x_data' => [
                'users'     => $request->input('users') ?? [],
                'companies' => $request->input('companies') ?? [],
            ],
        ]));

        return redirect()->action('App\FaqCategoryController@show', $faqCategory)
            ->with('success', __('FAQ was successfully updated.'));
    }
}
