@extends('app.layouts.app')

@section('title', __('All applications'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Applications') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All applications') }}
                    </h1>
                </div>
                @can('create', \App\Models\ApiApplication::class)
                    <div class="col-auto">
                        <a href="{{ action('App\ApiApplicationController@create') }}" class="btn btn-primary">
                            {{ __('New application') }}
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["api-application-name"]}'>
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
                            <a href="#" class="text-muted">
                                {{ __('ID') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="api-application-name">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($apiApplications as $apiApplication)
                        <tr>
                            <td>
                                #{{ $apiApplication->id }}
                            </td>
                            <td class="api-application-name">
                                @can('view', $apiApplication)
                                    <a href="{{ action('App\ApiApplicationController@show', $apiApplication) }}">
                                        {{ $apiApplication->name }}
                                    </a>
                                @else
                                    {{ $apiApplication->name }}
                                @endcan
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('view', $apiApplication)
                                            <a href="{{ action('App\ApiApplicationController@show', $apiApplication) }}" class="dropdown-item">
                                                {{ __('Show') }}
                                            </a>
                                        @endcan
                                        @can('update', $apiApplication)
                                            <a href="{{ action('App\ApiApplicationController@edit', $apiApplication) }}" class="dropdown-item">
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
            {{ $apiApplications->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
