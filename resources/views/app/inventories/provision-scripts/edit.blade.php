@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $provisionScript->title)

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
                        {{ $provisionScript->title }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Provision Script') }} {{ $provisionScript->title }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\InventoryController@updateProvisionScript', [$inventory, $provisionScript]) }}">
        @csrf

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            <textarea class="form-control" name="content">{{ old('content', $content) }}</textarea>

            @if ($errors->has('content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <small>{{ __('The following specific variables are available') }}:
                <strong>[[identifier]]</strong>,
                <strong>[[hostname]]</strong>,
                <strong>[[primary_ip]]</strong>,
                <strong>[[primary_ip_with_subnet]]</strong>,
                <strong>[[primary_subnet]]</strong>,
                <strong>[[primary_gateway]]</strong>,
                <strong>[[note]]</strong>
            </small>
            <br>
            <small>
                {{ __('Please replace all custom [[variables]] with actual values.') }}
            </small>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Provision Script') }}
        </button>

        <a href="{{ action('App\InventoryController@show', $inventory) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection
