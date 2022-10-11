@extends('app.layouts.app')

@section('title', __('All blog posts'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Blog posts') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All blog posts') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\BlogPost::class)
                        <a href="{{ action('App\BlogPostController@create') }}" class="btn btn-primary">
                            {{ __('New blog post') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["blog-post-title", "blog-post-category", "blog-post-user-name", "blog-post-status"]}'>
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <form>
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <span class="fe fe-search text-muted"></span>
                            </div>
                            <div class="col">
                                <input type="text" name="search" class="form-control form-control-flush" value="{{ app('request')->input('search') }}" placeholder="{{ __('Search') }}" autofocus>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm card-table">
                <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="blog-post-title">
                                {{ __('Title') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="blog-post-category">
                                {{ __('Category') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="blog-post-user-name">
                                {{ __('User') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="blog-post-status">
                                {{ __('Status') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($blogPosts as $blogPost)
                        <tr>
                            <td class="blog-post-title">
                                @can('update', $blogPost)
                                    <a href="{{ action('App\BlogPostController@edit', $blogPost) }}">
                                        {{ $blogPost->title }}
                                    </a>
                                @else
                                    {{ $blogPost->title }}
                                @endcan
                            </td>
                            <td class="blog-post-category">
                                {{ $blogPost->category }}
                            </td>
                            <td class="blog-post-user-name">
                                <a href="{{ action('App\UserController@show', $blogPost->user) }}">
                                    {{ $blogPost->user->name }}
                                </a>
                            </td>
                            <td class="blog-post-status">
                                @if($blogPost->status == \App\Models\BlogPost::STATUS_VISIBLE)
                                    <span class="text-success">●</span>
                                    {{ __('Visible') }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ __('Draft') }}
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $blogPost)
                                            <a href="{{ action('App\BlogPostController@edit', $blogPost) }}" class="dropdown-item">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row justify-content-center">
            {{ $blogPosts->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
