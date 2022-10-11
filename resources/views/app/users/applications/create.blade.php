@extends('app.layouts.app')

@section('title', __('Add Application'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ __('Applications') }}</a> /
                        {{ __('Add') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Add Application') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ApplicationUserController@store', $user) }}">
        @csrf

        <label>{{ __('Application') }}</label>

        <select class="form-control" data-toggle="select" name="application_id" id="application_id">
            @foreach($applications as $application)
                <option value="{{ $application->id }}" {{ old('application_id') == $application->id ? 'selected' : '' }}>{{ $application->name }}</option>
            @endforeach
        </select>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Add application') }}
        </button>

        <a href="{{ action('App\UserController@show', $user) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel') }}
        </a>
    </form>
@endsection
