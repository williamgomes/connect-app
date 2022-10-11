@extends('app.layouts.app')

@section('title', __('Add Provision Script'))

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
                        <a href="{{ action('App\InventoryController@show', $inventory) }}">{{ __('Provision Scripts') }}</a> /
                        {{ __('Add') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Add Provision Script') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\InventoryController@storeProvisionScript', $inventory) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Provision Script') }}</label>
            <select class="form-control" data-toggle="select" name="provision_script_id" id="provision_script_id">
                @foreach($provisionScripts as $provisionScript)
                    <option value="{{ $provisionScript->id }}" {{ old('provision_scripts') == $provisionScript->id ? 'selected' : '' }}>{{ $provisionScript->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('provision_script_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('provision_script_id') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Add Provision Script') }}
        </button>

        <a href="{{ action('App\InventoryController@show', $inventory) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel') }}
        </a>
    </form>
@endsection
