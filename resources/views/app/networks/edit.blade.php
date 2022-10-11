@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $network->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\NetworkController@index') }}">{{ __('Networks') }}</a> /
                        <a href="{{ action('App\NetworkController@show', $network) }}">{{ $network->name }}</a> /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Network') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $network)
                        <form role="form" method="POST" action="{{ action('App\NetworkController@destroy', $network) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete Network') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\NetworkController@update', $network) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $network->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Network') }}</label>

            <input id="ip_address" type="text" class="form-control {{ $errors->has('ip_address') ? 'is-invalid' : '' }}" name="ip_address" value="{{ old('ip_address', $network->ip_address) }}" placeholder="{{ __('Enter Network') }}" required>

            @if ($errors->has('ip_address'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('ip_address') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('CIDR Notation') }}</label>

            <select class="form-control" data-toggle="select" name="cidr" id="cidr">
                @for($i=1; $i<=32; $i++)
                    <option value="{{ $i }}" {{ old('cidr', $network->cidr) == $i ? 'selected' : '' }}>/{{ $i }}</option>
                @endfor
            </select>

            @if ($errors->has('cidr'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cidr') }}</strong>
                </span>
            @endif
        </div> 
        
        <div class="form-group">
            <label>{{ __('VLAN ID') }}</label>

            <input id="vlan_id" type="number" class="form-control {{ $errors->has('vlan_id') ? 'is-invalid' : '' }}" name="vlan_id" value="{{ old('vlan_id', $network->vlan_id) }}" placeholder="{{ __('Enter VLAN ID') }}" required>

            @if ($errors->has('vlan_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('vlan_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Datacenters') }}</label>
            <select class="form-control" data-toggle="select" name="datacenters[]" id="datacenters" multiple>
                @foreach($datacenters as $datacenter)
                    <option value="{{ $datacenter->id }}" {{ collect(old('datacenters', $network->datacenters->pluck('id')))->contains($datacenter->id) ? 'selected' : '' }}>{{ $datacenter->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('datacenters'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('datacenters') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Network') }}
        </button>
        
        <a href="{{ action('App\NetworkController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
