@extends('app.layouts.app')

@section('title', __('Add IP Address'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\InventoryController@index') }}">{{ __('Inventories') }}</a> /
                        <a href="{{ action('App\InventoryController@show', $inventory) }}">{{ $inventory->identifier }}</a> /
                        <a href="{{ action('App\InventoryController@show', $inventory) }}">{{ __('IP Addresses') }}</a> /
                        {{ __('Add') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Add IP Address') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\IpAddressController@store') }}">
        @csrf

        <input type="hidden" name="ref" value="inventory">
        <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
        <input type="hidden" name="network_id" value="{{ $network->id }}">

        <div class="form-group">
            <label>{{ __('IP Address') }}</label>

            <select class="form-control" data-toggle="select" name="address" id="address">
                @foreach($availableIpAddresses as $ipAddress)
                    <option value="{{ $ipAddress }}" {{ old('address') == $ipAddress ? 'selected' : '' }}>{{ $ipAddress }}</option>
                @endforeach
            </select>

            @if ($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="primary" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="primary" name="primary" {{ old('primary') ? 'checked' : '' }}>
                <label class="custom-control-label" for="primary">{{ __('Primary') }}</label>
            </div>

            @if ($errors->has('primary'))
                <div class="invalid-feedback">
                    {{ $errors->first('primary') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Description') }}</label>
            <textarea name="description" placeholder="Description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Add IP Address') }}
        </button>
        
        <a href="{{ action('App\InventoryController@show', $inventory) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel') }}
        </a>
    </form>
@endsection
