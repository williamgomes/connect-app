@extends('app.layouts.app')

@section('title', __('View') . ' ' . $inventory->identifier)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\InventoryController@index') }}">{{ __('Inventories') }}</a> /
                        {{ $inventory->identifier }} /
                        {{ __('View') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('View Inventory') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('update', $inventory)
                        <a href="{{ action('App\InventoryController@edit', $inventory) }}" class="btn btn-primary">
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
                                {{ __('Identifier') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $inventory->identifier }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Company') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $inventory->company }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Status') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ ucfirst($inventory->status) }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Type') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ ucfirst($inventory->type) }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Datacenter') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                <a href="{{ action('App\DatacenterController@edit', $inventory->datacenter) }}">
                                    {{ $inventory->datacenter->name }}
                                </a>
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('IT Service') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                <a href="{{ action('App\ItServiceController@edit', $inventory->itService) }}">
                                    {{ $inventory->itService->name }}
                                </a>
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Note') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                {{ $inventory->note }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-header-title">
                                {{ __('Guides') }}
                            </h4>
                        </div>
                        <div class="col-auto">
                            @can('update', $inventory)
                                <a href="{{ action('App\InventoryController@addGuide', $inventory) }}" class="btn btn-sm btn-primary">{{ __('Add Guide') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th class="text-right">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inventory->guides as $guide)
                            <tr>
                                <td>
                                    @can('view', $guide)
                                        <a href="{{ action('App\GuideController@show', [$guide, $inventory]) }}">
                                            {{ $guide->title }}
                                        </a>
                                    @else
                                        {{ $guide->title }}
                                    @endcan
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $inventory)
                                                <a href="{{ action('App\GuideController@edit', $guide) }}" class="dropdown-item">
                                                    {{ __('Edit') }}
                                                </a>
                                                <form action="{{ action('App\InventoryController@destroyGuide', [$inventory, $guide]) }}" method="POST">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                    <button class="dropdown-item delete-group">{{ __('Remove') }}</button>
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
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-header-title">
                                {{ __('Provision Scripts') }}
                            </h4>
                        </div>
                        <div class="col-auto">
                            @can('update', $inventory)
                                <a href="{{ action('App\InventoryController@createProvisionScript', $inventory) }}" class="btn btn-sm btn-primary">{{ __('Add Provision Script') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th class="text-right">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($inventory->provisionScripts as $provisionScript)
                            <tr>
                                <td>
                                    @can('update', $provisionScript)
                                        <a href="{{ action('App\InventoryController@editProvisionScript', [$inventory, $provisionScript]) }}">
                                            {{ $provisionScript->title }}
                                        </a>
                                    @else
                                        {{ $provisionScript->title }}
                                    @endcan
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $inventory)
                                                <a href="{{ action('App\InventoryController@editProvisionScript', [$inventory, $provisionScript]) }}" class="dropdown-item">
                                                    {{ __('Edit') }}
                                                </a>

                                                <form action="{{ action('App\InventoryController@destroyProvisionScript', [$inventory, $provisionScript]) }}" method="POST">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                    <button class="dropdown-item delete-group">{{ __('Remove') }}</button>
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
                                <a href="#" data-toggle="modal" data-target="#select-network-modal" class="btn btn-sm btn-primary">{{ __('Add IP Address') }}</a>
                                @include('app.inventories.modals.select-network')
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                            <tr>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Network') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th class="text-right">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($inventory->ipAddresses as $ipAddress)
                                <tr>
                                    <td>
                                        @can('update', $ipAddress)
                                            <a href="{{ action('App\IpAddressController@edit', [$ipAddress, 'ref' => 'inventory']) }}">
                                                {{ $ipAddress->address }}
                                            </a>
                                        @else
                                            {{ $ipAddress->address }}
                                        @endcan
                                        @if($ipAddress->primary)
                                            <span class="badge badge-primary ml-1">{{ __('Primary') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ipAddress->network)
                                            @can('view', $ipAddress->network)
                                                <a href="{{ action('App\NetworkController@show', $ipAddress->network) }}">
                                                    {{ $ipAddress->network->name }}
                                                </a>
                                            @else
                                                {{ $ipAddress->network->name }}
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
                                                    <a href="{{ action('App\IpAddressController@edit', [$ipAddress, 'ref' => 'inventory']) }}" class="dropdown-item">
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
