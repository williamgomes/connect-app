@extends('app.layouts.app')

@section('title', __('Create service'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ServiceController@index') }}">{{ __('Services') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create service') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ServiceController@store') }}">
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
            <div class="custom-control custom-switch">
                <input type="hidden" name="active" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="active" name="active" {{ old('active', 1) ? 'checked' : '' }}>
                <label class="custom-control-label" for="active">{{ __('Active') }}</label>
            </div>

            @if ($errors->has('active'))
                <div class="invalid-feedback">
                    {{ $errors->first('active') }}
                </div>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create service') }}
        </button>
        
        <a href="{{ action('App\ServiceController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection
