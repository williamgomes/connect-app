@extends('app.layouts.app')

@section('title', __('All Inventories'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Inventories') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Inventories') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Inventory::class)
                        <a href="{{ action('App\InventoryController@create') }}" class="btn btn-primary">
                            {{ __('Create Inventory') }}
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
                        <th>{{ __('Identifier') }}</th>
                        <th>{{ __('Hostname') }}</th>
                        <th>{{ __('IP Addresses') }}</th>
                        <th>{{ __('Note') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($inventories as $inventory)
                        <tr>
                            <td class="text-nowrap">
                                @can('view', $inventory)
                                    <a href="{{ action('App\InventoryController@show', $inventory) }}">
                                        {{ $inventory->identifier }}
                                    </a>
                                @else
                                    {{ $inventory->identifier }}
                                @endcan

                                <a href="#" class="text-dark px-1 copy-to-clipboard" data-clipboard-text="{{ $inventory->identifier }}" data-toggle="tooltip" title="{{ __('Click to copy') }}">
                                    <span class="fe fe-copy"></span>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="copy-to-clipboard text-dark underline-on-hover" data-clipboard-text="{{ $inventory->hostname }}.{{ env('INVENTORY_DOMAIN') }}" data-toggle="tooltip" title="{{ __('Click to copy') }}">
                                    {{ $inventory->hostname }}.{{ env('INVENTORY_DOMAIN') }}
                                </a>
                            </td>
                            <td>
                                @foreach($inventory->ipAddresses as $ipAddress)
                                    <a href="#" class="copy-to-clipboard text-dark underline-on-hover" data-clipboard-text="{{ $ipAddress->address }}" data-toggle="tooltip" title="{{ __('Click to copy') }}">{{ $ipAddress->address }}</a>@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>
                                @if($inventory->note)
                                    {!! \Illuminate\Support\Str::limit($inventory->note ?? '', 100, '...') !!}
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
                                        @can('update', $inventory)
                                            <a href="{{ action('App\InventoryController@edit', $inventory) }}" class="dropdown-item">
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
            {{ $inventories->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        new ClipboardJS('.copy-to-clipboard');
    </script>
@append