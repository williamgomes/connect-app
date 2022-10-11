@extends('app.layouts.app')

@section('title', __('User Emails'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a>/
                        {{ __('Emails') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Emails') }}
                    </h1>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        <li class="nav-item">
                            <a href="{{ action('App\UserController@show', $user) }}" class="nav-link">
                                {{ __('Overview') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\UserController@tickets', $user) }}" class="nav-link">
                                {{ __('Tickets') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\UserEmailController@index', $user) }}" class="nav-link active">
                                {{ __('Emails') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            @include('app.users.emails.show-all')
        </div>
    </div>
@endsection