@extends('app.layouts.app')

@section('title', __('All categories'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Categories') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All categories') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Category::class)
                        <a href="{{ action('App\CategoryController@create') }}" class="btn btn-primary">
                            {{ __('New category') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["category-name", "category-parent", "category-user", "category-sla-hours"]}'>
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
            <table class="table table-sm table-nowrap card-table">
                <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="category-name">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="category-parent">
                                {{ __('Parent Category') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="category-user">
                                {{ __('Default User') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="category-sla-hours">
                                {{ __('SLA Hours') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="category-active">
                                {{ __('Active') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($categories as $category)
                        <tr>
                            <td class="category-name">
                                @can('update', $category)
                                    <a href="{{ action('App\CategoryController@edit', $category) }}">
                                        {{ $category->name }}
                                    </a>
                                @else
                                    {{ $category->name }}
                                @endcan
                            </td>
                            <td class="category-parent">
                                @if($category->parentCategory)
                                    {{ $category->parentCategory->name }}
                                @else
                                    <i class="text-muted">{{ __('no parent') }}</i>
                                @endif
                            </td>
                            <td class="category-user">
                                <a href="{{ action('App\UserController@show', $category->user) }}">{{ $category->user->name }}</a>
                            </td>
                            <td class="category-sla-hours">
                                {{ $category->sla_hours }}
                            </td>
                            <td class="category-active">
                                @if ($category->active)
                                    <span class="text-success">●</span>
                                    {{ __('Yes') }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ __('No') }}
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $category)
                                            <a href="{{ action('App\CategoryController@edit', $category) }}" class="dropdown-item">
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
            {{ $categories->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
