@extends('app.layouts.app')

@section('title', __('Create Provision Script'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\ProvisionScriptController@index') }}">{{ __('Provision Scripts') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create Provision Script') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ProvisionScriptController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('IT Service') }}</label>

            <select class="form-control" data-toggle="select" name="it_service_id" id="it_service_id">
                @foreach($itServices as $itService)
                    <option value="{{ $itService->id }}" {{ old('it_service_id') == $itService->id ? 'selected' : '' }}>{{ $itService->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('it_service_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('it_service_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Title') }}</label>

            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="{{ __('Enter title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            <textarea class="form-control" name="content">{{ old('content') }}</textarea>

            @if ($errors->has('content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <small>{{ __('The following specific variables are available') }}:
                <strong>[[identifier]]</strong>,
                <strong>[[hostname]]</strong>,
                <strong>[[primary_ip]]</strong>,
                <strong>[[primary_ip_with_subnet]]</strong>,
                <strong>[[primary_subnet]]</strong>,
                <strong>[[primary_gateway]]</strong>,
                <strong>[[note]]</strong>
            </small>
            <br>
            <small>
                {{ 'You can also add any other custom variable wrapping it into [[...]].' }}
            </small>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create Provision Script') }}
        </button>

        <a href="{{ action('App\ProvisionScriptController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection
