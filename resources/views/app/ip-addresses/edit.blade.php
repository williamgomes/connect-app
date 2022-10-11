@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $ipAddress->address)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        @if(app('request')->input('ref') == 'inventory')
                            <a href="{{ action('App\InventoryController@index') }}">{{ __('Inventories') }}</a> /
                            <a href="{{ action('App\InventoryController@show', $ipAddress->inventory) }}">{{ $ipAddress->inventory->identifier }}</a> /
                        @else
                            <a href="{{ action('App\NetworkController@index') }}">{{ __('Networks') }}</a> /
                            <a href="{{ action('App\NetworkController@show', $ipAddress->network) }}">{{ $ipAddress->network->name }}</a> /
                        @endif
                        {{ $ipAddress->address }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit IP Address') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $ipAddress)
                        <form role="form" method="POST" action="{{ action('App\IpAddressController@destroy', $ipAddress) }}">
                            @csrf

                            <input type="hidden" name="ref" value="{{ app('request')->input('ref') }}">
                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete IP Address') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\IpAddressController@update', $ipAddress) }}">
        @csrf

        <input type="hidden" name="ref" value="{{ app('request')->input('ref') }}">

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="primary" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="primary" name="primary" {{ old('primary', $ipAddress->primary) ? 'checked' : '' }}>
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
            <textarea name="description" placeholder="Description" class="form-control">{{ old('description', $ipAddress->description) }}</textarea>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update IP Address') }}
        </button>
        
        <a href="{{ app('request')->input('ref') == 'inventory' ? action('App\InventoryController@show', $ipAddress->inventory) : action('App\NetworkController@show', $ipAddress->network) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
