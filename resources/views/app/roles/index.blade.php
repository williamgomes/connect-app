@extends('app.layouts.app')

@section('title', __('All roles'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Roles') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All roles') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Role::class)
                        <a href="{{ action('App\RoleController@create') }}" class="btn btn-primary">
                            {{ __('New role') }}
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
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                {{ $role->directory->name ?? '' }}
                            </td>
                            <td>
                                @can('update', $role)
                                    <a href="{{ action('App\RoleController@edit', $role) }}">
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
                                        @can('update', $role)
                                            <a href="{{ action('App\RoleController@edit', $role) }}" class="dropdown-item">
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
            <div class="row justify-content-center">
                {{ $roles->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
