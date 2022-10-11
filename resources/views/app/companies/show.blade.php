@extends('app.layouts.app')

@section('title', __('View') . ' ' . $company->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\CompanyController@index') }}">{{ __('Companies') }}</a> /
                        {{ $company->name }} /
                        {{ __('View') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('View') }} {{ $company->name }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-xl-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        {{ __('Roles') }}
                    </h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                        <tr>
                            <th>
                                <a href="#" class="text-muted">
                                    {{ __('Name') }}
                                </a>
                            </th>
                            <th class="text-right">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($roles as $role)
                            <tr>
                                <td>
                                    @can('update', $company)
                                        <a href="{{ action('App\CompanyController@editRole', [$company, $role]) }}">
                                            {{ $role->name }}
                                        </a>
                                    @else
                                        {{ $role->name }}
                                    @endcan
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $company)
                                                <a href="{{ action('App\CompanyController@editRole', [$company, $role]) }}" class="dropdown-item">
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
            </div>
        </div>
    </div>
@endsection
