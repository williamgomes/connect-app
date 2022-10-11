@extends('app.layouts.app')

@section('title', __('Create role'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\RoleController@index') }}">{{ __('Roles') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create role') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\RoleController@store') }}">
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
            {{ __('Create role') }}
        </button>

        <a href="{{ action('App\RoleController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection
