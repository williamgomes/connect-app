@extends('web.layouts.app')

@section('title', __('Issue:') . ' ' . $issue->title)

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\IssueController@index') }}">
                                {{ __('Issues') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $issue->title }}
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
                        {{ $issue->title }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        #{{ $issue->id }}
                    </p>
                </div>
                @can('markAsSolved', $issue)
                    <div class="col-auto">
                        <form id="mark-solved-form" method="POST" action="{{ action('Web\IssueController@markAsSolved', $issue) }}" hidden>
                            @csrf
                        </form>
                        <a href="#" class="btn btn-sm btn-gray-300-20" onclick="event.preventDefault(); document.getElementById('mark-solved-form').submit();">
                            {{ __('Mark as solved') }}
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
                    <div class="card shadow-light-lg">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-uppercase">
                                {{ __('Status') }}
                            </h6>
                            <small>
                                @if($issue->status == \App\Models\Issue::STATUS_AWAITING_SPECIFICATION)
                                    <span class="text-warning">{{ __('Awaiting Specification') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_BACKLOG)
                                    <span class="text-black">{{ __('Backlog') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_DECLINED)
                                    <span class="text-danger">{{ __('Declined') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_DONE)
                                    <span class="text-success">{{ __('Done') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_IN_PROGRESS)
                                    <span class="text-info">{{ __('In progress') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_QUALITY_ASSURANCE)
                                    <span class="text-secondary">{{ __('Quality Assurance') }}</span>
                                @endif
                            </small>

                            <hr>

                            <h6 class="font-weight-bold text-uppercase">
                                {{ __('Key') }}
                            </h6>
                            <small>
                                {{ $issue->key }}
                            </small>

                            <hr>

                            <h6 class="font-weight-bold text-uppercase">
                                {{ __('Type') }}
                            </h6>
                            <small>
                                @if($issue->type == \App\Models\Issue::TYPE_BUG)
                                    <span class="text-danger">{{ __('Bug') }}</span>
                                @elseif($issue->type == \App\Models\Issue::TYPE_FEATURE)
                                    <span class="text-info">{{ __('Feature') }}</span>
                                @endif
                            </small>

                            <hr>

                            <h6 class="font-weight-bold text-uppercase">
                                {{ __('Connected Tickets') }}
                            </h6>
                            <small>
                                @forelse($issue->tickets()->where('requester_id', auth()->user()->id)->get() as $ticket)
                                    <a href="{{ action('Web\TicketController@show', $ticket) }}">
                                        {{ $ticket->title }}
                                    </a>
                                    <br>
                                @empty
                                    <i class="text-muted">-</i>
                                @endforelse
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card shadow-light-lg">
                        <div class="card-body">
                            {!! $issue->description !!}

                            @if($issue->attachments->count())
                                <hr>

                                <h5 class="mb-0">
                                    {{ __('Attachments') }}
                                </h5>
                                @foreach($issue->attachments as $attachment)
                                    <a href="{{ action('App\IssueController@showAttachment', $attachment) }}" target="_blank">
                                        {{ $attachment->original_filename }}
                                    </a>
                                    <br>
                                @endforeach
                            @endif
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
