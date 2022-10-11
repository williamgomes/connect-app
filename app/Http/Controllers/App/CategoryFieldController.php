<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\CategoryField\CategoryFieldCreateRequest;
use App\Http\Requests\App\CategoryField\CategoryFieldUpdateRequest;
use App\Models\Category;
use App\Models\CategoryField;

class CategoryFieldController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Category $category)
    {
        $this->authorize('create', CategoryField::class);

        return view('app.categories.fields.create')->with([
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryFieldCreateRequest $request
     * @param Category                   $category
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryFieldCreateRequest $request, Category $category)
    {
        $this->authorize('create', CategoryField::class);

        CategoryField::create(array_merge($request->only([
            'type',
            'title',
            'description',
            'placeholder',
            'options',
            'default_value',
            'required',
            'min',
            'max',
        ]), [
            'category_id' => $category->id,
        ]));

        return redirect()->action('App\CategoryController@edit', $category)
            ->with('success', __('The Category Field was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category                  $category
     * @param \App\Models\CategoryField $categoryField
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Category $category, CategoryField $categoryField)
    {
        $this->authorize('update', $categoryField);

        return view('app.categories.fields.edit')->with([
            'category'      => $category,
            'categoryField' => $categoryField,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryFieldUpdateRequest $request
     * @param Category                   $category
     * @param \App\Models\CategoryField  $categoryField
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryFieldUpdateRequest $request, Category $category, CategoryField $categoryField)
    {
        $this->authorize('update', $categoryField);

        $categoryField->update($request->only([
            'type',
            'title',
            'description',
            'placeholder',
            'options',
            'default_value',
            'required',
            'min',
            'max',
        ]));

        return redirect()->action('App\CategoryController@edit', $category)
            ->with('success', __('The Category Field was successfully updated.'));
    }

    /**
     * @param Category      $category
     * @param CategoryField $categoryField
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category, CategoryField $categoryField)
    {
        $this->authorize('delete', $categoryField);

        $categoryField->delete();

        return redirect()->action('App\CategoryController@edit', $category)
            ->with('info', __('The Category Field was successfully deleted.'));
    }
}
