@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $inventory->identifier)

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
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Inventory') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $inventory)
                        <form role="form" method="POST" action="{{ action('App\InventoryController@destroy', $inventory) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete Inventory') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\InventoryController@update', $inventory) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Status') }}</label>

            <select class="form-control" data-toggle="select" name="status" id="status">
                <option value="{{ \App\Models\Inventory::STATUS_PRODUCTION }}" {{ (old('status', $inventory->status) == \App\Models\Inventory::STATUS_PRODUCTION) ? ' selected' : '' }}>
                    {{ __('Production') }}
                </option>
                <option value="{{ \App\Models\Inventory::STATUS_DEVELOPMENT }}" {{ (old('status', $inventory->status) == \App\Models\Inventory::STATUS_DEVELOPMENT) ? ' selected' : '' }}>
                    {{ __('Development') }}
                </option>
                <option value="{{ \App\Models\Inventory::STATUS_STAGING }}" {{ (old('status', $inventory->status) == \App\Models\Inventory::STATUS_STAGING) ? ' selected' : '' }}>
                    {{ __('Staging') }}
                </option>
            </select>

            @if ($errors->has('status'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Type') }}</label>

            <select class="form-control" data-toggle="select" name="type" id="type">
                <option value="{{ \App\Models\Inventory::TYPE_HARDWARE }}" {{ (old('type', $inventory->type) == \App\Models\Inventory::TYPE_HARDWARE) ? ' selected' : '' }}>
                    {{ __('Hardware') }}
                </option>
                <option value="{{ \App\Models\Inventory::TYPE_SOFTWARE }}" {{ (old('type', $inventory->type) == \App\Models\Inventory::TYPE_SOFTWARE) ? ' selected' : '' }}>
                    {{ __('Software') }}
                </option>
            </select>

            @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            <label>{{ __('Datacenter') }}</label>

            <select class="form-control" data-toggle="select" name="datacenter_id" id="datacenter_id">
                @foreach($datacenters as $datacenter)
                    <option value="{{ $datacenter->id }}" {{ old('datacenter_id', $inventory->datacenter_id) == $datacenter->id ? 'selected' : '' }}>{{ $datacenter->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('datacenter_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('datacenter_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('IT Service') }}</label>

            <select class="form-control" data-toggle="select" name="it_service_id" id="it_service_id">
                @foreach($itServices as $itService)
                    <option value="{{ $itService->id }}" {{ old('it_service_id', $inventory->it_service_id) == $itService->id ? 'selected' : '' }}>{{ $itService->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('it_service_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('it_service_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Note') }}</label>
            <textarea name="note" placeholder="Note" class="form-control"> {{ old('note', $inventory->note) }}</textarea>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Inventory') }}
        </button>
        
        <a href="{{ action('App\InventoryController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
