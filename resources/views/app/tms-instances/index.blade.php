@extends('app.layouts.app')

@section('title', __('All TMS Instances'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('TMS Instances') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All TMS Instances') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\TmsInstance::class)
                        <a href="{{ action('App\TmsInstanceController@create') }}" class="btn btn-primary">
                            {{ __('Create TMS Instance') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["tms-instance-name", "tms-instance-identifier"]}'>
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
                            <a href="#" class="text-muted sort" data-sort="tms-instance-name">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="tms-instance-identifier">
                                {{ __('Identifier') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="tms-instance-base-url">
                                {{ __('Base URL') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($tmsInstances as $tmsInstance)
                        <tr>
                            <td class="tms-instance-name">
                                @can('update', $tmsInstance)
                                    <a href="{{ action('App\TmsInstanceController@edit', $tmsInstance) }}">
                                        {{ $tmsInstance->name }}
                                    </a>
                                @else
                                    {{ $tmsInstance->name }}
                                @endcan
                            </td>
                            <td class="tms-instance-identifier">
                                {{ $tmsInstance->identifier }}
                            </td>
                            <td class="tms-instance-base-url">
                                <a href="{{ $tmsInstance->base_url }}" target="_blank">{{ $tmsInstance->base_url }}</a>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $tmsInstance)
                                            <a href="{{ action('App\TmsInstanceController@edit', $tmsInstance) }}" class="dropdown-item">
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
            {{ $tmsInstances->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
