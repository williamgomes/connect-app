@extends('web.layouts.app')

@section('title', __('Tickets'))

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('Tickets') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="font-weight-bold text-white mb-2">
                        {{ __('Ticket Overview') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ __('Keep track of your tickets.')}}                        
                    </p>
                </div>
                @can('create', \App\Models\Ticket::class)
                    <div class="col-auto">
                        <a href="{{ action('Web\TicketController@create') }}" class="btn btn-sm btn-gray-300-20">
                            {{ __('Create a new ticket') }}
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    </header>
    <main class="pb-8 pb-md-11 mt-md-n6">
        <div class="container-md">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="card card-bleed border-bottom border-bottom-md-0 shadow-light-lg">
                        <div class="collapse d-md-block" id="sidenavCollapse">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-uppercase mb-3">
                                    {{ __('Status') }}
                                </h6>
                                <ul class="card-list list text-gray-700">
                                    <li class="list-item {{ Request::is('tickets') ? 'active' : '' }}">
                                        <a class="list-link text-reset" href="{{ action('Web\TicketController@index') }}">
                                            {{ __('All') }}
                                        </a>
                                    </li>
                                    <li class="list-item {{ Request::is('tickets/open') ? 'active' : '' }}">
                                        <a class="list-link text-reset" href="{{ action('Web\TicketController@index', 'open') }}">
                                            {{ __('Open') }}
                                        </a>
                                    </li>
                                    <li class="list-item {{ Request::is('tickets/solved') ? 'active' : '' }}">
                                        <a class="list-link text-reset" href="{{ action('Web\TicketController@index', 'solved') }}">
                                            {{ __('Solved') }}
                                        </a>
                                    </li>
                                    <li class="list-item {{ Request::is('tickets/closed') ? 'active' : '' }}">
                                        <a class="list-link text-reset" href="{{ action('Web\TicketController@index', 'closed') }}">
                                            {{ __('Closed') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card card-bleed shadow-light-lg mb-6">
                        <div class="card-header">
                            <h4 class="mb-0">
                                {{ __('Your tickets') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @forelse($tickets as $ticket)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="mb-0">
                                                    @can('view', $ticket)
                                                        <a href="{{ action('Web\TicketController@show', $ticket) }}">
                                                            {{ $ticket->title }}
                                                        </a>
                                                    @endcan
                                                </p>
                                                <small class="text-gray-700">
                                                    {{ __(\App\Models\Ticket::$statuses[$ticket->status]) }}
                                                </small>

                                            </div>
                                            @can('view', $ticket)
                                                <div class="col-auto">
                                                    <a href="{{ action('Web\TicketController@show', $ticket) }}" class="btn btn-xs btn-outline-white">
                                                        {{ __('Show ticket') }}
                                                    </a>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                @empty
                                    <i class=text-muted>{{ __('No tickets found.') }}</i>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <section>
        <div class="container mb-10">
            <div class="row">

                <div class="col-12 text-center mb-4">
                    <hr class="border-gray-300 mb-8">
                    <h2>{{ __('Did you want help with something else?') }}</h2>
                </div>
                @include('web.help-center.all-categories')
            </div>
        </div>
    </section>
@endsection
