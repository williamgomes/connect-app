@extends('app.layouts.app')

@section('title', __('All companies'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Companies') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All companies') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Company::class)
                        <a href="{{ action('App\CompanyController@create') }}" class="btn btn-primary">
                            {{ __('New company') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
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
                                {{ __('Directory') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted">
                                {{ __('Country') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted">
                                {{ __('Service') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted">
                                {{ __('TMS Instance') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($companies as $company)
                        <tr>
                            <td>
                                {{ $company->directory->name ?? '-' }}
                            </td>
                            <td class="company-name">
                                @can('view', $company)
                                    <a href="{{ action('App\CompanyController@show', $company) }}">
                                        {{ $company->name }}
                                    </a>
                                @else
                                    {{ $company->name }}
                                @endcan
                            </td>
                            <td>
                                {{ $company->country->name }}
                            </td>
                            <td>
                                {{ $company->service->name }}
                            </td>
                            <td>
                                {{ $company->tmsInstance->name ?? '-' }}
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $company)
                                            <a href="{{ action('App\CompanyController@edit', $company) }}" class="dropdown-item">
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
            {{ $companies->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
