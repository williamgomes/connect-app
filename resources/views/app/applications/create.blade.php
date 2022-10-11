@extends('app.layouts.app')

@section('title', __('Create application'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\ApplicationController@index') }}">{{ __('Applications') }}</a> /
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
    <form class="mb-4" method="POST" action="{{ action('App\ApplicationController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Directory') }}</label>

            <select class="form-control" data-toggle="select" name="directory_id" id="directory_id">
                @foreach($directories as $directory)
                    <option value="{{ $directory->id }}" {{ old('directory_id') == $directory->id ? 'selected' : '' }}>{{ $directory->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('directory_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('directory_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>
                {{ __('OneLogin App ID') }}
                <small>
                    <a target="_blank" class="create-app-link">
                        ({{ __('Create app') }})
                    </a>
                </small>
            </label>

            <input id="onelogin_app_id" type="text" class="form-control {{ $errors->has('onelogin_app_id') ? 'is-invalid' : '' }}" name="onelogin_app_id" value="{{ old('onelogin_app_id') }}" placeholder="{{ __('Enter OneLogin App ID') }}" required autofocus>

            @if ($errors->has('onelogin_app_id'))
                <span class="invalid-feedback" app="alert">
                    <strong>{{ $errors->first('onelogin_app_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter name') }}" required>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="sso" value="0">
                <input type="checkbox" class="custom-control-input{{ $errors->has('sso') ? ' is-invalid' : '' }}" name="sso" id="sso" value="1" {{ old('sso') ? 'checked' : '' }}>
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
                <input type="checkbox" class="custom-control-input{{ $errors->has('provisioning') ? ' is-invalid' : '' }}" name="provisioning" id="provisioning" value="1" {{ old('provisioning') ? 'checked' : '' }}>
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

            <input id="signup_url" type="text" class="form-control {{ $errors->has('signup_url') ? 'is-invalid' : '' }}" name="signup_url" value="{{ old('signup_url') }}" placeholder="{{ __('Enter Sign Up Url') }}">

            @if ($errors->has('signup_url'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('signup_url') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create application') }}
        </button>

        <a href="{{ action('App\ApplicationController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $('#directory_id').on('change', function () {
            let directoryId = $(this).val();
            let getDirectoryEndpoint = "{{ action('Ajax\DirectoryController@show', 'DIRECTORY_ID') }}";
            let getDirectoryUrl = getDirectoryEndpoint.replace('DIRECTORY_ID', directoryId);

            $.ajax({
                url: getDirectoryUrl,
                method: 'GET',
            }).done(function (response) {
                if (response.data) {
                    let directory = response.data;
console.log(directory);
                    $('.create-app-link').attr('href', directory.onelogin_tenant_url + '/apps/find');
                }
            });
        }).trigger('change');
    </script>
@append