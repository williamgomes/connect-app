<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogPosts = BlogPost::where('status', BlogPost::STATUS_VISIBLE)
            ->latest()
            ->get();

        return view('web.blog.index')->with([
            'blogPosts' => $blogPosts,
        ]);
    }

    /**
     * Display a specific resource.
     *
     * @param Request  $request
     * @param BlogPost $blogPost
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BlogPost $blogPost)
    {
        return view('web.blog.show')->with([
            'blogPost' => $blogPost,
        ]);
    }
}
