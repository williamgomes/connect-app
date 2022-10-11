@extends('app.layouts.app')

@section('title', __('Tickets'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Tickets') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All tickets') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Ticket::class)
                        <a href="{{ action('App\TicketController@create') }}" class="btn btn-primary">
                            {{ __('New ticket') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <form>
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <span class="fe fe-search text-muted"></span>
                            </div>
                            <div class="col">
                                    <input type="text" name="search" class="form-control form-control-flush" value="{{ app('request')->input('search') }}" placeholder="{{ __('Search') }}" autofocus>
                            </div>
                        </div>
                    </form>
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
                            {{ __('Requested By') }}
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
                        <th>
                            {{ __('Tags') }}
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
                                {{ $ticket->requester->name }}
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
                                    <i class="text-muted">{{ __('n/a') }}</i>
                                @endif
                            </td>
                            <td>
                                @forelse($ticket->ticketTags as $ticketTag)
                                    <span class="badge badge-light">{{ $ticketTag->name }}</span>
                                @empty
                                    <i class="text-muted"> {{ __('n/a') }}</i>
                                @endforelse
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
@endsection
