@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $user->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a> /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit user') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mb-4">
        @include('app.users.partials.profile-picture')
    </div>

    <form class="mb-4" method="POST" action="{{ action('App\UserController@update', $user) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('First Name') }}</label>

            <input id="first_name" type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="{{ __('Enter first name') }}" required autofocus>

            @if ($errors->has('first_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Last Name') }}</label>

            <input id="last_name" type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="{{ __('Enter last name') }}" required>

            @if ($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Directory Username') }}</label>

            <input id="default_username" type="text" class="form-control {{ $errors->has('default_username') ? 'is-invalid' : '' }}" name="default_username" value="{{ old('default_username', $user->default_username) }}" placeholder="{{ __('Enter username') }}" required>

            @if ($errors->has('default_username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('default_username') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Private Email Address') }}</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ __('Enter email address') }}">

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Private Phone Number') }}</label>

            <input id="phone_number" type="text" class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="{{ __('Enter last name') }}" required>

            @if ($errors->has('phone_number'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Slack Webhook Url') }}</label>

            <input id="slack_webhook_url" type="text" class="form-control {{ $errors->has('slack_webhook_url') ? 'is-invalid' : '' }}" name="slack_webhook_url" value="{{ old('slack_webhook_url', $user->slack_webhook_url) }}" placeholder="{{ __('Enter Slack webhook url') }}">

            @if ($errors->has('slack_webhook_url'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('slack_webhook_url') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Connect Role') }}</label>

            <select class="form-control" data-toggle="select" name="role" id="role">
                @foreach(\App\Models\User::$roles as $key => $value)
                    <option value="{{ $key }}" {{ (old('role', $user->role) == $key) ? ' selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('role'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Status') }}</label>

            <select class="form-control" data-toggle="select" name="active" id="active">
                <option value="{{ \App\Models\User::IS_ACTIVE }}" {{ (old('active', $user->active) == \App\Models\User::IS_ACTIVE) ? ' selected' : '' }}>
                    {{ __('Active') }}
                </option>
                <option value="{{ \App\Models\User::NOT_ACTIVE }}" {{ (old('active', $user->active) == \App\Models\User::NOT_ACTIVE) ? ' selected' : '' }}>
                    {{ __('Deactivated') }}
                </option>
            </select>

            @if ($errors->has('active'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('active') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Blog Notifications') }}</label>

            <select class="form-control" data-toggle="select" name="blog_notifications" id="blog_notifications">
                <option value="{{ \App\Models\User::ENABLE_BLOG_NOTIFICATIONS }}" {{ (old('blog_notifications', $user->blog_notifications) == \App\Models\User::ENABLE_BLOG_NOTIFICATIONS) ? ' selected' : '' }}>
                    {{ __('Enabled') }}
                </option>
                <option value="{{ \App\Models\User::DISABLE_BLOG_NOTIFICATIONS }}" {{ (old('blog_notifications', $user->blog_notifications) == \App\Models\User::DISABLE_BLOG_NOTIFICATIONS) ? ' selected' : '' }}>
                    {{ __('Disabled') }}
                </option>
            </select>

            @if ($errors->has('blog_notifications'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('blog_notifications') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Permissions') }}</label>
            <select class="form-control" data-toggle="select" name="permissions[]" id="permissions" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}" {{ collect(old('permissions', $user->permissions->pluck('id')))->contains($permission->id) ? 'selected' : '' }}>{{ $permission->name }}</option>
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
            {{ __('Update user') }}
        </button>

        <a href="{{ action('App\UserController@show', $user) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>

    </form>
@endsection
