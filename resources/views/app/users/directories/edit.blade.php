@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $directoryUser->directory->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $directoryUser->user) }}">{{ $directoryUser->user->name }}</a> /
                        <a href="{{ action('App\UserController@show', $directoryUser->user) }}">{{ __('Directories') }}</a> /
                        {{ $directoryUser->directory->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Directory') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\DirectoryUserController@update', $directoryUser) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Directory') }}</label>
            <input class="form-control text-muted" value="{{ $directoryUser->directory->name }}" disabled>
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>
            <input class="form-control text-muted" value="{{ $directoryUser->user->name }}" disabled>
        </div>

        <div class="form-group">
            <label>{{ __('Username') }}</label>

            <input id="username" type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username', $directoryUser->username) }}" placeholder="{{ __('Enter username') }}" required>

            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Directory') }}
        </button>

        <a href="{{ action('App\UserController@show', $directoryUser->user) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
