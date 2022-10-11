@extends('app.layouts.app')

@section('title', __('All guides'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Guides') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All guides') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Guide::class)
                        <a href="{{ action('App\GuideController@create') }}" class="btn btn-primary">
                            {{ __('Create Guide') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["guide-title", "guide-author_id"]}'>
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
                            <a href="#" class="text-muted sort" data-sort="guide-title">
                                {{ __('Title') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="guide-author_id">
                                {{ __('Author') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($guides as $guide)
                        <tr>
                            <td class="guide-title">
                                @can('view', $guide)
                                    <a href="{{ action('App\GuideController@show', $guide) }}">
                                        {{ $guide->title }}
                                    </a>
                                @else
                                    {{ $guide->title }}
                                @endcan
                            </td>
                            <td class="guide-author_id">
                                @can('update', $guide->author)
                                    <a href="{{ action('App\UserController@edit', $guide->author) }}">
                                        {{ $guide->author->name }}
                                    </a>
                                @else
                                    {{ $guide->author->name }}
                                @endcan
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $guide)
                                            <a href="{{ action('App\GuideController@edit', $guide) }}" class="dropdown-item">
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
            {{ $guides->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
