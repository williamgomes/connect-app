@extends('app.layouts.app')

@section('title', __('Dashboard'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Dashboard') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Dashboard') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @foreach($tickets as $header => $tickets)
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-header-title">
                            {{ $header}}
                        </h4>
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
                                {{ __('Requested By') }}
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
                        @forelse($tickets as $ticket)
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
                                    {{ $ticket->requester->name }}
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
                        @empty
                            <tr>
                                <td colspan="5">
                                    <i class="text-muted">{{ __('No tickets found.') }}</i>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endsection