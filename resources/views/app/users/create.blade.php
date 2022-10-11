@extends('app.layouts.app')

@section('title', __('Create user'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create user') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\UserController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('First Name') }}</label>

            <input id="first_name" type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('Enter first name') }}" required autofocus>

            @if ($errors->has('first_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Last Name') }}</label>

            <input id="last_name" type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('Enter last name') }}" required>

            @if ($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Private Email Address') }}</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter email address') }}">

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Private Phone Number') }}</label>

            <div class="input-group input-group-merge">
                <input id="phone_number" type="number" class="form-control form-control-prepended {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" placeholder="{{ __('Enter phone number') }}" required>

                <div class="input-group-prepend">
                    <div class="input-group-text">
                        +
                    </div>
                </div>
            </div>

            @if ($errors->has('phone_number'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Permissions') }}</label>
            <select class="form-control" data-toggle="select" name="permissions[]" id="permissions" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}" {{ collect(old('permissions'))->contains($permission->id) ? 'selected' : '' }}>{{ $permission->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('permissions'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('permissions') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create user') }}
        </button>
        
        <a href="{{ action('App\UserController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection
