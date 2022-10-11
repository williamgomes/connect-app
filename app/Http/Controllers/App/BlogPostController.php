<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\BlogPost\BlogPostCreateRequest;
use App\Http\Requests\App\BlogPost\BlogPostUpdateRequest;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', BlogPost::class);

        $blogPostQuery = BlogPost::query();

        if ($request->has('search')) {
            $blogPostQuery->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
                });
        }

        return view('app.blog-posts.index')->with([
            'blogPosts' => $blogPostQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', BlogPost::class);

        return view('app.blog-posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogPostCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostCreateRequest $request)
    {
        $this->authorize('create', BlogPost::class);

        BlogPost::create(array_merge([
            'user_id' => $request->user()->id,
        ], $request->only(['title', 'category', 'content', 'status'])));

        return redirect()->action('App\BlogPostController@index')
            ->with('success', __('The blog post was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\BlogPost $blogPost
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $blogPost)
    {
        $this->authorize('update', $blogPost);

        return view('app.blog-posts.edit')->with([
            'blogPost' => $blogPost,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogPostUpdateRequest $request
     * @param \App\Models\BlogPost  $blogPost
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostUpdateRequest $request, BlogPost $blogPost)
    {
        $this->authorize('update', $blogPost);

        $blogPost->update($request->only(['title', 'category', 'content', 'status']));

        return redirect()->action('App\BlogPostController@index')
            ->with('success', __('The blog post was successfully updated.'));
    }

    /**
     * @param BlogPost $blogPost
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BlogPost $blogPost)
    {
        $this->authorize('delete', $blogPost);

        $blogPost->delete();

        return redirect()->action('App\BlogPostController@index')
            ->with('info', __('The blog post was successfully deleted.'));
    }
}
