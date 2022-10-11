@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $ticketTag->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\TicketTagController@index') }}">{{ __('Ticket Tags') }}</a> /
                        {{ $ticketTag->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Ticket Tag') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $ticketTag)
                        <form role="form" method="POST" action="{{ action('App\TicketTagController@destroy', $ticketTag) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete Ticket Tag') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\TicketTagController@update', $ticketTag) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $ticketTag->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Description') }}</label>
            <textarea name="description" placeholder="Description" class="form-control">{{ old('description', $ticketTag->description) }}</textarea>
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="active" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="active" name="active" {{ old('active', $ticketTag->active) ? 'checked' : '' }}>
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
            {{ __('Update Ticket Tag') }}
        </button>
        
        <a href="{{ action('App\TicketTagController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
