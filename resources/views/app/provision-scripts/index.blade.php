@extends('app.layouts.app')

@section('title', __('Provision Scripts'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Provision Scripts') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Provision Scripts') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\ProvisionScript::class)
                        <a href="{{ action('App\ProvisionScriptController@create') }}" class="btn btn-primary">
                            {{ __('Create Provision Script') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["provision-script-title", "provision-script-it-service-name"]}'>
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
            <table class="table table-sm card-table">
                <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="provision-script-title">
                                {{ __('Title') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="provision-script-it-service">
                                {{ __('IT Service') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($provisionScripts as $provisionScript)
                        <tr>
                            <td class="provision-script-title">
                                @can('update', $provisionScript)
                                    <a href="{{ action('App\ProvisionScriptController@edit', $provisionScript) }}">
                                        {{ $provisionScript->title }}
                                    </a>
                                @else
                                    {{ $provisionScript->title }}
                                @endcan
                            </td>
                            <td class="provision-script-it-service">
                                <a href="{{ action('App\ItServiceController@edit', $provisionScript->itService) }}">
                                    {{ $provisionScript->itService->name }}
                                </a>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $provisionScript)
                                            <a href="{{ action('App\ProvisionScriptController@edit', $provisionScript) }}" class="dropdown-item">
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
            {{ $provisionScripts->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
