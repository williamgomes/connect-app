@extends('app.layouts.app')

@section('title', __('All Ticket Priorities'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Ticket Priorities') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Ticket Priorities') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\TicketPriority::class)
                        <a href="{{ action('App\TicketPriorityController@create') }}" class="btn btn-primary">
                            {{ __('Create Ticket Priority') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["ticket-priority-name", "ticket-priority-order", "ticket-priority-description"]}'>
        <div class="table-responsive">
            <table class="table table-sm table-nowrap card-table">
                <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="ticket-priority-name">
                                {{ __('Name') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="ticket-priority-order">
                                {{ __('Order') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="ticket-priority-description">
                                {{ __('Description') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($ticketPriorities as $ticketPriority)
                        <tr>
                            <td class="ticket-priority-name">
                                @can('update', $ticketPriority)
                                    <a href="{{ action('App\TicketPriorityController@edit', $ticketPriority) }}">
                                        {{ $ticketPriority->name }}
                                    </a>
                                @else
                                    {{ $ticketPriority->name }}
                                @endcan
                            </td>
                            <td class="ticket-priority-parent">
                                {{ $ticketPriority->order }}
                            </td>
                            <td class="ticket-priority-user">
                                {!! \Illuminate\Support\Str::limit($ticketPriority->description ?? '', 70, '...') !!}
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $ticketPriority)
                                            <a href="{{ action('App\TicketPriorityController@edit', $ticketPriority) }}" class="dropdown-item">
                                                {{ __('Edit') }}
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
    </div>
@endsection
