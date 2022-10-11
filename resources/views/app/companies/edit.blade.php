@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $company->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\CompanyController@index') }}">{{ __('Companies') }}</a> /
                        <a href="{{ action('App\CompanyController@show', $company->id) }}">{{ $company->name }}</a> /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit company') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $company)
                        <form role="form" method="POST" action="{{ action('App\CompanyController@destroy', $company) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete company') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\CompanyController@update', $company) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Directory') }}</label>

            @if($company->directory)
                <input type="text" class="form-control text-muted" value="{{ $company->directory->name }}" readonly>
            @else
                <select class="form-control" data-toggle="select" name="directory_id" id="directory_id">
                    @foreach($directories as $directory)
                        <option value="{{ $directory->id }}" {{ old('directory_id', $company->directory_id) == $directory->id ? 'selected' : '' }}>{{ $directory->name }}</option>
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

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $company->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Country') }}</label>

            <select class="form-control" data-toggle="select" name="country_id" id="country_id">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id', $company->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('country_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('country_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Service') }}</label>

            <select class="form-control" data-toggle="select" name="service_id" id="service_id">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id', $company->service_id) == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('service_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('service_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('TMS Instance') }}</label>

            <select class="form-control" data-toggle="select" name="tms_instance_id" id="tms_instance_id">
                <option></option>
                @foreach($tmsInstances as $tmsInstance)
                    <option value="{{ $tmsInstance->id }}" {{ old('tms_instance_id', $company->tms_instance_id) == $tmsInstance->id ? 'selected' : '' }}>{{ $tmsInstance->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('tms_instance_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('tms_instance_id') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update company') }}
        </button>

        <a href="{{ action('App\CompanyController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection
