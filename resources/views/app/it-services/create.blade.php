@extends('app.layouts.app')

@section('title', __('Create IT Service'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ItServiceController@index') }}">{{ __('IT Services') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create IT Service') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ItServiceController@store') }}">
        @csrf

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
            <label>{{ __('Identifier') }}</label>

            <input id="identifier" type="text" class="form-control {{ $errors->has('identifier') ? 'is-invalid' : '' }}" name="identifier" value="{{ old('identifier') }}" placeholder="{{ __('Enter identifier') }}" required>

            @if ($errors->has('identifier'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('identifier') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Note') }}</label>
            <textarea name="note" placeholder="Note" class="form-control"></textarea>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create IT Service') }}
        </button>
        
        <a href="{{ action('App\ItServiceController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Creation') }}
        </a>
    </form>
@endsection
