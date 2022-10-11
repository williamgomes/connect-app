@extends('app.layouts.app')

@section('title', __('View') . ' ' . $guide->title)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        @if($inventory)
                            <a href="{{ action('App\InventoryController@index') }}">{{ __('Inventories') }}</a> /
                            <a href="{{ action('App\InventoryController@show', $inventory) }}">{{ $inventory->identifier }}</a> /
                            <a href="{{ action('App\InventoryController@show', $inventory) }}">{{ __('Guides') }}</a> /
                        @else
                            <a href="{{ action('App\GuideController@index') }}">{{ __('Guides') }}</a> /
                        @endif
                            {{ $guide->title }} /
                        {{ __('View') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('View Guide') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {!! $guide->content !!}
        </div>
    </div>
@endsection
