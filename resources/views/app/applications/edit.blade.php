@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $application->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\ApplicationController@index') }}">{{ __('Applications') }}</a> /
                        {{ $application->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit application') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $application)
                        <form role="form" method="POST" action="{{ action('App\ApplicationController@destroy', $application) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete application') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ApplicationController@update', $application) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Directory') }}</label>

            @if($application->directory)
                <input type="text" class="form-control text-muted" value="{{ $application->directory->name }}" readonly>
            @else
                <select class="form-control" data-toggle="select" name="directory_id" id="directory_id">
                    @foreach($directories as $directory)
                        <option value="{{ $directory->id }}" {{ old('directory_id', $application->directory_id) == $directory->id ? 'selected' : '' }}>{{ $directory->name }}</option>
                    @endforeach
                </select>
            @endif

            @if ($errors->has('directory_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('directory_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $application->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="sso" value="0">
                <input type="checkbox" class="custom-control-input{{ $errors->has('sso') ? ' is-invalid' : '' }}" name="sso" id="sso" value="1" {{ old('sso', $application->sso) ? 'checked' : '' }}>
                <label class="custom-control-label" for="sso">{{ __('SSO') }}</label>
            </div>

            @if ($errors->has('sso'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sso') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="provisioning" value="0">
                <input type="checkbox" class="custom-control-input{{ $errors->has('provisioning') ? ' is-invalid' : '' }}" name="provisioning" id="provisioning" value="1" {{ old('provisioning', $application->provisioning) ? 'checked' : '' }}>
                <label class="custom-control-label" for="provisioning">{{ __('Provisioning') }}</label>
            </div>

            @if ($errors->has('provisioning'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('provisioning') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Sign Up URL') }}</label>

            <input id="signup_url" type="text" class="form-control {{ $errors->has('signup_url') ? 'is-invalid' : '' }}" name="signup_url" value="{{ old('signup_url', $application->signup_url) }}" placeholder="{{ __('Enter Sign Up Url') }}">

            @if ($errors->has('signup_url'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('signup_url') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update application') }}
        </button>

        <a href="{{ action('App\ApplicationController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection
