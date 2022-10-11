@extends('app.layouts.app')

@section('title', __('View') . ' ' . $network->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\NetworkController@index') }}">{{ __('Networks') }}</a> /
                        {{ $network->name }} /
                        {{ __('View') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('View Network') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('update', $network)
                        <a href="{{ action('App\NetworkController@edit', $network) }}" class="btn btn-primary">
                            {{ __('Edit') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Name') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $network->name }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Network') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $network->ip_address }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('CIDR Notation') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                /{{ $network->cidr }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('VLAN ID') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $network->vlan_id }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Gateway / Broadcast') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $network->gateway }} / {{ $network->broadcast }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Hosts Range') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $network->address_from }} - {{ $network->address_to }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Total Hosts') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $network->total_hosts }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Usable Hosts') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $network->usable_hosts }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Datacenters') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                @foreach($network->datacenters as $datacenter)
                                    {{ $datacenter->country . '-' .  $datacenter->location . $datacenter->location_id }}@if(!$loop->last), @endif
                                @endforeach
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-header-title">
                                {{ __('IP Addresses') }}
                            </h4>
                        </div>
                        <div class="col-auto">
                            @can('create', \App\Models\IpAddress::class)
                                <a href="{{ action('App\NetworkController@createIpAddress', $network) }}" class="btn btn-sm btn-primary">
                                    {{ __('Add IP Address') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                            <tr>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Inventory') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th class="text-right">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($network->ipAddresses as $ipAddress)
                                <tr>
                                    <td>
                                        @can('update', $ipAddress)
                                            <a href="{{ action('App\IpAddressController@edit', [$ipAddress, 'ref' => 'network']) }}">
                                                {{ $ipAddress->address }}
                                            </a>
                                        @else
                                            {{ $ipAddress->address }}
                                        @endcan
                                    </td>
                                    <td>
                                        @if($ipAddress->inventory)
                                            @can('view', $ipAddress->inventory)
                                                <a href="{{ action('App\InventoryController@show', $ipAddress->inventory) }}">
                                                    {{ $ipAddress->inventory->identifier }}
                                                </a>
                                            @else
                                                {{ $ipAddress->inventory->identifier }}
                                            @endcan
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($ipAddress->description)
                                            {!! \Illuminate\Support\Str::limit($ipAddress->description ?? '', 70, '...') !!}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('update', $ipAddress)
                                                    <a href="{{ action('App\IpAddressController@edit', [$ipAddress, 'ref' => 'network']) }}" class="dropdown-item">
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
