@extends('app.layouts.app')

@section('title', __('All applications'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Applications') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All applications') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Application::class)
                        <a href="{{ action('App\ApplicationController@create') }}" class="btn btn-primary">
                            {{ __('New application') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["application-name", "application-onelogin_role_id", "application-onelogin_app_id", "application-sso", "application-provisioning", "application-signup_url"]}'>
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
                            <a href="#" class="text-muted sort" data-sort="application-directory">
                                {{ __('Directory') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="application-name">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="application-onelogin_role_id">
                                {{ __('OneLogin Role ID') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="application-onelogin_app_id">
                                {{ __('OneLogin App ID') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="application-sso">
                                {{ __('SSO') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="application-provisioning">
                                {{ __('Provisioning') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="application-signup_url">
                                {{ __('Sign Up URL') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($applications as $application)
                        <tr>
                            <td class="application-directory">
                                {{ $application->directory->name ?? '' }}
                            </td>
                            <td class="application-name">
                                @can('update', $application)
                                    <a href="{{ action('App\ApplicationController@edit', $application) }}">
                                        {{ $application->name }}
                                    </a>
                                @else
                                    {{ $application->name }}
                                @endcan
                            </td>
                            <td class="application-onelogin_role_id">
                                {{ $application->onelogin_role_id }}
                            </td>
                            <td class="application-onelogin_app_id">
                                {{ $application->onelogin_app_id }}
                            </td>
                            <td class="application-sso">
                                @if ($application->sso)
                                    <span class="text-success">●</span>
                                    {{ __('Yes') }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ __('No') }}
                                @endif
                            </td>
                            <td class="application-provisioning">
                                @if ($application->provisioning)
                                    <span class="text-success">●</span>
                                    {{ __('Yes') }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ __('No') }}
                                @endif
                            </td>
                            <td class="application-signup_url">
                                {{ $application->signup_url }}
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $application)
                                            <a href="{{ action('App\ApplicationController@edit', $application) }}" class="dropdown-item">
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
            {{ $applications->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
