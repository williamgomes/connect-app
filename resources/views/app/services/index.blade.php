@extends('app.layouts.app')

@section('title', __('All services'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Services') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All services') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Service::class)
                        <a href="{{ action('App\ServiceController@create') }}" class="btn btn-primary">
                            {{ __('New service') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["service-name", "service-identifier"]}'>
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
                            <a href="#" class="text-muted sort" data-sort="service-name">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="service-identifier">
                                {{ __('Identifier') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="service-active">
                                {{ __('Active') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($services as $service)
                        <tr>
                            <td class="service-name">
                                @can('update', $service)
                                    <a href="{{ action('App\ServiceController@edit', $service) }}">
                                        {{ $service->name }}
                                    </a>
                                @else
                                    {{ $service->name }}
                                @endcan
                            </td>
                            <td class="service-identifier">
                                {{ $service->identifier }}
                            </td>
                            <td class="service-active">
                                @if ($service->active)
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
                                        @can('update', $service)
                                            <a href="{{ action('App\ServiceController@edit', $service) }}" class="dropdown-item">
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
            {{ $services->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
