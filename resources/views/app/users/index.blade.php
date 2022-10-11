@extends('app.layouts.app')

@section('title', __('All users'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Users') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All users') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\User::class)
                        <a href="{{ action('App\UserController@create') }}" class="btn btn-primary">
                            {{ __('New user') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["user-name", "user-email", "user-role", "user-status"]}'>
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
                        <th>{{ __('Synega ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Default Username') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Permissions') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->synega_id }}
                            </td>
                            <td>
                                @can('view', $user)
                                    <a href="{{ action('App\UserController@show', $user) }}">
                                        {{ $user->name }}
                                    </a>
                                @else
                                    {{ $user->name }}
                                @endcan
                            </td>
                            <td>
                                {{ $user->default_username }}
                            </td>
                            <td>
                                @if($user->hasRole(\App\Models\User::ROLE_ADMIN))
                                    {{ __('Administrator') }}
                                @elseif($user->hasRole(\App\Models\User::ROLE_REGULAR))
                                    {{ __('Regular') }}
                                @elseif($user->hasRole(\App\Models\User::ROLE_DEVELOPER))
                                    {{ __('Developer') }}
                                @elseif($user->hasRole(\App\Models\User::ROLE_REPORTING))
                                    {{ __('Reporting') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @foreach($user->permissions as $permission)
                                    {{ $permission->name }}@if(!$loop->last),@endif
                                @endforeach
                            </td>
                            <td>
                                @if($user->active)
                                    <span class="text-success">●</span>
                                    {{ __('Active') }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ __('Deactivated') }}
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('view', $user)
                                            <a href="{{ action('App\UserController@show', $user) }}" class="dropdown-item">
                                                {{ __('Show') }}
                                            </a>
                                        @endcan
                                        @can('update', $user)
                                            <a href="{{ action('App\UserController@edit', $user) }}" class="dropdown-item">
                                                {{ __('Edit') }}
                                            </a>
                                            <form action="{{ $user->active ? action('App\UserController@deactivate', $user) : action('App\UserController@activate', $user) }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item">
                                                        {{ $user->active ? __('Deactivate') : __('Activate') }}
                                                </button>
                                            </form>
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
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
