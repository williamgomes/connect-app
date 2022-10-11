@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $ticketPriority->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\TicketPriorityController@index') }}">{{ __('Ticket Priorities') }}</a> /
                        {{ $ticketPriority->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Ticket Priority') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $ticketPriority)
                        <form role="form" method="POST" action="{{ action('App\TicketPriorityController@destroy', $ticketPriority) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete Ticket Priority') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\TicketPriorityController@update', $ticketPriority) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Order') }}</label>

            <input id="order" type="number" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order" value="{{ old('order', $ticketPriority->order) }}" placeholder="{{ __('Enter order') }}" required autofocus>

            @if ($errors->has('order'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('order') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $ticketPriority->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Description') }}</label>

            <textarea id="description" type="text" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="{{ __('Enter description') }}">{{ old('description', $ticketPriority->description) }}</textarea>

            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Ticket Priority') }}
        </button>

        <a href="{{ action('App\TicketPriorityController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection
