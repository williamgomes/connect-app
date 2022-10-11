@extends('app.layouts.app')

@section('title', __('User Tickets'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a>/
                        {{ __('Tickets') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Tickets') }}
                    </h1>
                </div>
                @can('update', $user)
                    <div class="col-auto">
                        <a href="{{ action('App\UserController@edit', $user) }}" class="btn btn-primary">
                            {{ __('Edit') }}
                        </a>
                    </div>
                @endcan
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        <li class="nav-item">
                            <a href="{{ action('App\UserController@show', $user) }}" class="nav-link">
                                {{ __('Overview') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\UserController@tickets', $user) }}" class="nav-link active">
                                {{ __('Tickets') }}
                            </a>
                        </li>
                        @can('viewEmails', $user)
                            <li class="nav-item">
                                <a href="{{ action('App\UserEmailController@index', $user) }}" class="nav-link">
                                    {{ __('Emails') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form id="form">
        <div class="row">
            <div class="col-md-4">
                <select onchange="getElementById('form').submit()" class="form-control mb-3" data-toggle="select" name="status" id="status">
                    <option value="{{ \App\Models\Ticket::STATUS_OPEN }}" {{ (app('request')->input('status') == \App\Models\Ticket::STATUS_OPEN) ? ' selected' : '' }}>
                        {{ __('Open') }}
                    </option>
                    <option value="{{ \App\Models\Ticket::STATUS_SOLVED }}" {{ (app('request')->input('status') == \App\Models\Ticket::STATUS_SOLVED) ? ' selected' : '' }}>
                        {{ __('Solved') }}
                    </option>
                </select>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <span class="fe fe-search text-muted"></span>
                            </div>
                            <div class="col">
                                <input type="text" name="search" class="form-control form-control-flush" value="{{ app('request')->input('search') }}" placeholder="{{ __('Search') }}" autofocus>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table">
                    <thead>
                    <tr>
                        <th>
                            {{ __('ID') }}
                        </th>
                        <th>
                            {{ __('Title') }}
                        </th>
                        <th>
                            {{ __('Status') }}
                        </th>
                        <th>
                            {{ __('Assigned To') }}
                        </th>
                        <th>
                            {{ __('Last Comment By') }}
                        </th>
                        <th>
                            {{ __('SLA') }}
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>
                                #{{ $ticket->id }}
                            </td>
                            <td>
                                @can('view', $ticket)
                                    <a href="{{ action('App\TicketController@show', $ticket) }}">
                                        {{ $ticket->title }}
                                    </a>
                                @else
                                    {{ $ticket->title }}
                                @endcan
                            </td>
                            <td>
                                @if($ticket->status == \App\Models\Ticket::STATUS_OPEN)
                                    <span class="text-primary">●</span>
                                    {{ __('Open') }}
                                @elseif($ticket->status == \App\Models\Ticket::STATUS_SOLVED)
                                    <span class="text-success">●</span>
                                    {{ __('Solved') }}
                                @elseif($ticket->status == \App\Models\Ticket::STATUS_CLOSED)
                                    <span class="text-secondary">●</span>
                                    {{ __('Closed') }}
                                @endif
                            </td>
                            <td>
                                @if ($ticket->user)
                                    {{ $ticket->user->name }}
                                    @if ($ticket->user->id == auth()->user()->id)
                                        <span class="badge badge-soft-primary">
                                            {{ __('You')}}
                                        </span>
                                    @endif
                                @else
                                    <i>{{ __('Unassigned') }}</i>
                                @endif
                            </td>
                            <td>
                                {{ $ticket->lastCommenter->name }}
                                @if ($ticket->lastCommenter->hasRole(\App\Models\User::ROLE_REGULAR))
                                    <span class="badge badge-soft-danger">
                                        {{ __('End-user')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->status == \App\Models\Ticket::STATUS_OPEN)
                                    @if ($ticket->due_at > now())
                                        <span class="badge badge-soft-primary">
                                    @else
                                        <span class="badge badge-soft-danger">
                                    @endif
                                        {{ ucfirst($ticket->due_at->diffForHumans()) }}
                                    </span>
                                @else
                                    <i class="text-muted">{{ __('N/A') }}</i>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('view', $ticket)
                                            <a href="{{ action('App\TicketController@show', $ticket) }}" class="dropdown-item">
                                                {{ __('Show') }}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-center">
                {{ $tickets->appends(request()->query())->links() }}
            </div>
        </div>
    </form>
@endsection
