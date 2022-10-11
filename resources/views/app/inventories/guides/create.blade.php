@extends('app.layouts.app')

@section('title', __('Add Guide'))

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
                        <a href="{{ action('App\InventoryController@show', $inventory) }}">{{ __('Guides') }}</a> /
                        {{ __('Add') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Add Guide') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\InventoryController@storeGuide', $inventory) }}">
        @csrf
        
        <div class="form-group">
            <label>{{ __('Guide') }}</label>
            <select class="form-control" data-toggle="select" name="guide_id" id="guide_id">
                @foreach($guides as $guide)
                    <option value="{{ $guide->id }}" {{ old('guide_id') == $guide->id ? 'selected' : '' }}>{{ $guide->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('guide_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('guide_id') }}</strong>
                </span>
            @endif
        </div>
        
        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Add Guide') }}
        </button>
        
        <a href="{{ action('App\InventoryController@show', $inventory) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel') }}
        </a>
    </form>
@endsection
