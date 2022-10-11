@extends('app.layouts.app')

@section('title', __('Ticket Tags'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Ticket Tags') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Ticket Tags') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\TicketTag::class)
                        <a href="{{ action('App\TicketTagController@create') }}" class="btn btn-primary">
                            {{ __('Create Ticket Tag') }}
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
            <table class="table table-sm card-table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Active') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($ticketTags as $ticketTag)
                        <tr>
                            <td>
                                @can('update', $ticketTag)
                                    <a href="{{ action('App\TicketTagController@edit', $ticketTag) }}">
                                        {{ $ticketTag->name }}
                                    </a>
                                @else
                                    {{ $ticketTag->name }}
                                @endcan
                            </td>
                            <td>
                                @if($ticketTag->description)
                                    {!! \Illuminate\Support\Str::limit($ticketTag->description ?? '', 200, '...') !!}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($ticketTag->active)
                                    <span class="text-success">●</span>
                                    {{ __('Yes') }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ __('No') }}
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $ticketTag)
                                            <a href="{{ action('App\TicketTagController@edit', $ticketTag) }}" class="dropdown-item">
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
        <div class="row justify-content-center">
            {{ $ticketTags->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
