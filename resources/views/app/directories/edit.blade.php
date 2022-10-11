@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $directory->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\DirectoryController@index') }}">{{ __('Directories') }}</a> /
                        {{ $directory->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Directory') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $directory)
                        <form role="form" method="POST" action="{{ action('App\DirectoryController@destroy', $directory) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete directory') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\DirectoryController@update', $directory) }}">
        @csrf

        <div class="row">
            <div class="form-group col-md-6">
                <label>{{ __('Name') }}</label>

                <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       name="name" value="{{ old('name', $directory->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('Slug') }}</label>

                <input id="slug" type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                       name="slug" value="{{ old('slug', $directory->slug) }}" placeholder="{{ __('Enter slug') }}" required autofocus>

                @if ($errors->has('slug'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="form-group col-md-6">
                <label>{{ __('Onelogin Tenant URL') }}</label>

                <input id="onelogin_tenant_url" type="text" class="form-control {{ $errors->has('onelogin_tenant_url') ? 'is-invalid' : '' }}" name="onelogin_tenant_url" value="{{ old('onelogin_tenant_url', $directory->onelogin_tenant_url) }}" placeholder="{{ __('Enter Onelogin tenant URL') }}">

                @if ($errors->has('onelogin_tenant_url'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('onelogin_tenant_url') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('Onelogin API URL') }}</label>

                <input id="onelogin_api_url" type="text" class="form-control {{ $errors->has('onelogin_api_url') ? 'is-invalid' : '' }}" name="onelogin_api_url" value="{{ old('onelogin_api_url', $directory->onelogin_api_url) }}" placeholder="{{ __('Enter Onelogin API URL') }}">

                @if ($errors->has('onelogin_api_url'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('onelogin_api_url') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('Onelogin Client ID') }}</label>

                <input id="onelogin_client_id" type="text" class="form-control {{ $errors->has('onelogin_client_id') ? 'is-invalid' : '' }}" name="onelogin_client_id" value="{{ old('onelogin_client_id', $directory->onelogin_client_id) }}" placeholder="{{ __('Enter Onelogin client ID') }}">

                @if ($errors->has('onelogin_client_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('onelogin_client_id') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('Onelogin Secret Key') }}</label>

                <input id="onelogin_secret_key" type="text" class="form-control {{ $errors->has('onelogin_secret_key') ? 'is-invalid' : '' }}" name="onelogin_secret_key" value="{{ old('onelogin_secret_key', $directory->onelogin_secret_key) }}" placeholder="{{ __('Enter Onelogin secret key') }}">

                @if ($errors->has('onelogin_secret_key'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('onelogin_secret_key') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group col-md-6">
                <label>{{ __('Onelogin Default Role') }}</label>

                <input id="onelogin_default_role" type="text" class="form-control {{ $errors->has('onelogin_default_role') ? 'is-invalid' : '' }}" name="onelogin_default_role" value="{{ old('onelogin_default_role', $directory->onelogin_default_role) }}" placeholder="{{ __('Enter Onelogin default role') }}">

                @if ($errors->has('onelogin_default_role'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('onelogin_default_role') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="form-group col-md-6">
                <label>{{ __('DUO Integration Key') }}</label>

                <input id="duo_integration_key" type="text" class="form-control {{ $errors->has('duo_integration_key') ? 'is-invalid' : '' }}" name="duo_integration_key" value="{{ old('duo_integration_key', $directory->duo_integration_key) }}" placeholder="{{ __('Enter DUO integration key') }}">

                @if ($errors->has('duo_integration_key'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('duo_integration_key') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('DUO Secret Key') }}</label>

                <input id="duo_secret_key" type="text" class="form-control {{ $errors->has('duo_secret_key') ? 'is-invalid' : '' }}" name="duo_secret_key" value="{{ old('duo_secret_key', $directory->duo_secret_key) }}" placeholder="{{ __('Enter DUO secret key') }}">

                @if ($errors->has('duo_secret_key'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('duo_secret_key') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('DUO API URL') }}</label>

                <input id="duo_api_url" type="text" class="form-control {{ $errors->has('duo_api_url') ? 'is-invalid' : '' }}" name="duo_api_url" value="{{ old('duo_api_url', $directory->duo_api_url) }}" placeholder="{{ __('Enter DUO API URL') }}">

                @if ($errors->has('duo_api_url'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('duo_api_url') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="form-group col-md-6">
                <label>{{ __('SAML Entity ID') }}</label>

                <input id="saml_entity_id" type="text" class="form-control {{ $errors->has('saml_entity_id') ? 'is-invalid' : '' }}" name="saml_entity_id" value="{{ old('saml_entity_id', $directory->saml_entity_id) }}" placeholder="{{ __('Enter SAML entity ID') }}">

                @if ($errors->has('saml_entity_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_entity_id') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('SAML SSO URL') }}</label>

                <input id="saml_sso_url" type="text" class="form-control {{ $errors->has('saml_sso_url') ? 'is-invalid' : '' }}" name="saml_sso_url" value="{{ old('saml_sso_url', $directory->saml_sso_url) }}" placeholder="{{ __('Enter SAML SSO URL') }}">

                @if ($errors->has('saml_sso_url'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_sso_url') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('SAML SLO URL') }}</label>

                <input id="saml_slo_url" type="text" class="form-control {{ $errors->has('saml_slo_url') ? 'is-invalid' : '' }}" name="saml_slo_url" value="{{ old('saml_slo_url', $directory->saml_slo_url) }}" placeholder="{{ __('Enter SAML SLO URL') }}">

                @if ($errors->has('saml_slo_url'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_slo_url') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('SAML Certificate Fingerprint (CFI)') }}</label>

                <input id="saml_cfi" type="text" class="form-control {{ $errors->has('saml_cfi') ? 'is-invalid' : '' }}" name="saml_cfi" value="{{ old('saml_cfi', $directory->saml_cfi) }}" placeholder="{{ __('Enter SAML CFI') }}">

                @if ($errors->has('saml_cfi'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_cfi') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('SAML Contact Name') }}</label>

                <input id="saml_contact_name" type="text" class="form-control {{ $errors->has('saml_contact_name') ? 'is-invalid' : '' }}" name="saml_contact_name" value="{{ old('saml_contact_name', $directory->saml_contact_name) }}" placeholder="{{ __('Enter SAML contact name') }}">

                @if ($errors->has('saml_contact_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_contact_name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('SAML Contact Email') }}</label>

                <input id="saml_contact_email" type="text" class="form-control {{ $errors->has('saml_contact_email') ? 'is-invalid' : '' }}" name="saml_contact_email" value="{{ old('saml_contact_email', $directory->saml_contact_email) }}" placeholder="{{ __('Enter SAML contact email') }}">

                @if ($errors->has('saml_contact_email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_contact_email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('SAML Organization Name') }}</label>

                <input id="saml_organization_name" type="text" class="form-control {{ $errors->has('saml_organization_name') ? 'is-invalid' : '' }}" name="saml_organization_name" value="{{ old('saml_organization_name', $directory->saml_organization_name) }}" placeholder="{{ __('Enter SAML organization name') }}">

                @if ($errors->has('saml_organization_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_organization_name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label>{{ __('SAML Website URL') }}</label>

                <input id="saml_website_url" type="text" class="form-control {{ $errors->has('saml_website_url') ? 'is-invalid' : '' }}" name="saml_website_url" value="{{ old('saml_website_url', $directory->saml_website_url) }}" placeholder="{{ __('Enter SAML website URL') }}">

                @if ($errors->has('saml_website_url'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('saml_website_url') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Directory') }}
        </button>

        <a href="{{ action('App\DirectoryController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
