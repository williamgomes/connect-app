@extends('app.layouts.app')

@section('title', __('All Networks'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Networks') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Networks') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Network::class)
                        <a href="{{ action('App\NetworkController@create') }}" class="btn btn-primary">
                            {{ __('Create Network') }}
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
            <table class="table table-sm card-table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Network') }}</th>
                        <th>{{ __('CIDR Notation') }}</th>
                        <th>{{ __('VLAN ID') }}</th>
                        <th>{{ __('Gateway / Broadcast') }}</th>
                        <th>{{ __('Hosts Range') }}</th>
                        <th>{{ __('Total Hosts') }}</th>
                        <th>{{ __('Usable Hosts') }}</th>
                        <th>{{ __('Datacenters') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($networks as $network)
                        <tr>
                            <td>
                                @can('view', $network)
                                    <a href="{{ action('App\NetworkController@show', $network) }}">
                                        {{ $network->name }}
                                    </a>
                                @else
                                    {{ $network->name }}
                                @endcan
                            </td>
                            <td>
                                {{ $network->ip_address }}
                            </td>
                            <td>
                                /{{ $network->cidr }}
                            </td>
                            <td>
                                {{ $network->vlan_id }}
                            </td>
                            <td>
                                {{ $network->gateway }} / {{ $network->broadcast }}
                            </td>
                            <td>
                                {{ $network->address_from }} - {{ $network->address_to }}
                            </td>
                            <td>
                                {{ $network->total_hosts }}
                            </td>
                            <td>
                                {{ $network->usable_hosts }}
                            </td>
                            <td>
                                @foreach($network->datacenters as $datacenter)
                                    {{ $datacenter->country . '-' .  $datacenter->location . $datacenter->location_id }}@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $network)
                                            <a href="{{ action('App\NetworkController@edit', $network) }}" class="dropdown-item">
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
            {{ $networks->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
