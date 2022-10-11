@extends('app.layouts.app')

@section('title', __('Create category'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\CategoryController@index') }}">{{ __('Categories') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create category') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\CategoryController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Parent Category') }}</label>

            <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5", "allowClear": true, "placeholder": "{{ __('No parent category') }}"}' name="parent_id" id="parent_id">
                <option></option>
                @foreach($primaryCategories as $primaryCategory)
                    <option value="{{ $primaryCategory->id }}" {{ (old('parent_id') == $primaryCategory->id) ? ' selected' : '' }}>{{ $primaryCategory->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('parent_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('parent_id') }}</strong>
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

        <div class="form-group">
            <label>{{ __('User') }}</label>

            <select class="form-control" data-toggle="select" name="user_id" id="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('user_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('SLA Hours') }}</label>

            <input id="sla_hours" type="number" class="form-control {{ $errors->has('sla_hours') ? 'is-invalid' : '' }}" name="sla_hours" value="{{ old('sla_hours') }}" placeholder="{{ __('Enter SLA hours') }}" required>

            @if ($errors->has('sla_hours'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sla_hours') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="active" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="active" name="active" {{ old('active', 1) ? 'checked' : '' }}>
                <label class="custom-control-label" for="active">{{ __('Active') }}</label>
            </div>

            @if ($errors->has('active'))
                <div class="invalid-feedback">
                    {{ $errors->first('active') }}
                </div>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create category') }}
        </button>

        <a href="{{ action('App\CategoryController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection
