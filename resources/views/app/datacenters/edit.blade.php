@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $datacenter->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\DatacenterController@index') }}">{{ __('Datacenters') }}</a> /
                        {{ $datacenter->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Datacenter') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $datacenter)
                        <form role="form" method="POST" action="{{ action('App\DatacenterController@destroy', $datacenter) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete Datacenter') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\DatacenterController@update', $datacenter) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $datacenter->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Country') }}</label>

            <input id="country" type="text" class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country" value="{{ old('country', $datacenter->country) }}" placeholder="{{ __('Enter country') }}" required>

            @if ($errors->has('country'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('country') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Location') }}</label>

            <input id="location" type="text" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" name="location" value="{{ old('location', $datacenter->location) }}" placeholder="{{ __('Enter location') }}" required>

            @if ($errors->has('location'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('location') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            <label>{{ __('Location ID') }}</label>

            <input id="location_id" type="number" class="form-control {{ $errors->has('location_id') ? 'is-invalid' : '' }}" name="location_id" value="{{ old('location_id', $datacenter->location_id) }}" placeholder="{{ __('Enter location_id') }}" required>

            @if ($errors->has('location_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('location_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Note') }}</label>
            <textarea name="note" placeholder="Note" class="form-control"> {{ old('note', $datacenter->note) }}</textarea>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Datacenter') }}
        </button>
        
        <a href="{{ action('App\DatacenterController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
