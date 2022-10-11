@extends('app.layouts.app')

@section('title', __('Create application'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ApiApplicationController@index') }}">{{ __('Applications') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create application') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ApiApplicationController@store') }}">
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

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create application') }}
        </button>

        <a href="{{ action('App\ApiApplicationController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection
