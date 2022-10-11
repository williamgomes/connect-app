@extends('app.layouts.app')

@section('title', __('Create TMS Instance'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\TmsInstanceController@index') }}">{{ __('TMS Instances') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create TMS Instance') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\TmsInstanceController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            <label>{{ __('Identifier') }}</label>

            <input id="identifier" type="text" class="form-control {{ $errors->has('identifier') ? 'is-invalid' : '' }}" name="identifier" value="{{ old('identifier') }}" placeholder="{{ __('Enter identifier') }}" required>

            @if ($errors->has('identifier'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('identifier') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            <label>{{ __('Base Url') }}</label>

            <input id="base_url" type="text" class="form-control {{ $errors->has('base_url') ? 'is-invalid' : '' }}" name="base_url" value="{{ old('base_url') }}" placeholder="{{ __('Enter base URL') }}" required>

            @if ($errors->has('base_url'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('base_url') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            <label>{{ __('Bearer API Token') }}</label>

            <input id="bearer_token" type="text" class="form-control {{ $errors->has('bearer_token') ? 'is-invalid' : '' }}" name="bearer_token" value="{{ old('bearer_token') }}" placeholder="{{ __('Enter bearer token') }}" required>

            @if ($errors->has('bearer_token'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('bearer_token') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create TMS Instance') }}
        </button>
        
        <a href="{{ action('App\TmsInstanceController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Creation') }}
        </a>
    </form>
@endsection
