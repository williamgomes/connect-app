@extends('app.layouts.app')

@section('title', __('All countries'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Countries') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All countries') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Country::class)
                        <a href="{{ action('App\CountryController@create') }}" class="btn btn-primary">
                            {{ __('New country') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["country-name", "country-identifier"]}'>
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
                            <a href="#" class="text-muted sort" data-sort="country-name">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="country-identifier">
                                {{ __('Identifier') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="country-active">
                                {{ __('Active') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($countries as $country)
                        <tr>
                            <td class="country-name">
                                @can('update', $country)
                                    <a href="{{ action('App\CountryController@edit', $country) }}">
                                        {{ $country->name }}
                                    </a>
                                @else
                                    {{ $country->name }}
                                @endcan
                            </td>
                            <td class="country-identifier">
                                {{ $country->identifier }}
                            </td>
                            <td class="country-active">
                                @if ($country->active)
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
                                        @can('update', $country)
                                            <a href="{{ action('App\CountryController@edit', $country) }}" class="dropdown-item">
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
            {{ $countries->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
