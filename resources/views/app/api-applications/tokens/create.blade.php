@extends('app.layouts.app')

@section('title', __('Generate token'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ApiApplicationController@index') }}">{{ __('Applications') }}</a> /
                        <a href="{{ action('App\ApiApplicationController@show', $apiApplication) }}">{{ $apiApplication->name }}</a> /
                        {{ __('Tokens') }} /
                        {{ __('Generate') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Generate token') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ApiApplicationTokenController@store', $apiApplication) }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>{{ __('Identifier') }}</label>

            <input id="identifier" type="text" class="form-control {{ $errors->has('identifier') ? 'is-invalid' : '' }}" name="identifier" value="{{ old('identifier') }}" placeholder="{{ __('Enter identifier') }}" required autofocus>
            <span class="feedback">
                <small class="text-muted">{{ __('Only alpha-numeric characters, underscores and dashes') }}.</small>
            </span>

            @if ($errors->has('identifier'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('identifier') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Access Token') }}</label>

            <input type="text" class="form-control" value="{{ $token }}" readonly>
            <span class="feedback">
                <small class="text-muted">{{ __('Please copy this token, you will not to see it again') }}.</small>
            </span>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Generate token') }}
        </button>

        <a href="{{ action('App\ApiApplicationController@show', $apiApplication) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection
