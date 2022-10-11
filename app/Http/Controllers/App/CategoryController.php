<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Category\CategoryCreateRequest;
use App\Http\Requests\App\Category\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Category::class);

        $categoryQuery = Category::query();

        if ($request->has('search')) {
            $categoryQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('parentCategory', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
                });
        }

        return view('app.categories.index')->with([
            'categories' => $categoryQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Category::class);

        $users = User::whereIn('role', [User::ROLE_AGENT, User::ROLE_ADMIN])->get();

        $primaryCategories = Category::active()
            ->whereNull('parent_id')
            ->get();

        return view('app.categories.create')->with([
            'primaryCategories' => $primaryCategories,
            'users'             => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $this->authorize('create', Category::class);

        Category::create($request->only(['name', 'parent_id', 'user_id', 'sla_hours', 'active']));

        return redirect()->action('App\CategoryController@index')
            ->with('success', __('The category was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        $users = User::whereIn('role', [User::ROLE_AGENT, User::ROLE_ADMIN])->get();

        $primaryCategories = Category::active()
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('app.categories.edit')->with([
            'primaryCategories' => $primaryCategories,
            'category'          => $category,
            'users'             => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param \App\Models\Category  $category
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $category->update($request->only(['name', 'parent_id', 'user_id', 'sla_hours', 'active']));

        return redirect()->action('App\CategoryController@index')
            ->with('success', __('The category was successfully updated.'));
    }

    /**
     * @param Category $category
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->action('App\CategoryController@index')
            ->with('info', __('The category was successfully deleted.'));
    }
}
