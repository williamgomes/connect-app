@extends('app.layouts.app')

@section('title', __('All Directories'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Directories') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Directories') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Directory::class)
                        <a href="{{ action('App\DirectoryController@create') }}" class="btn btn-primary">
                            {{ __('Create Directory') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-nowrap card-table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($directories as $directory)
                        <tr>
                            <td>
                                <a href="{{ action('App\DirectoryController@edit', $directory) }}">
                                    {{ $directory->name }}
                                </a>
                            </td>
                            <td>{{ $directory->slug }}</td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $directory)
                                            <a href="{{ action('App\DirectoryController@edit', $directory) }}" class="dropdown-item">
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
            {{ $directories->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
