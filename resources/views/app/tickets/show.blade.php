@extends('app.layouts.app')

@section('title', __('Ticket') . ': ' . $ticket->title)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\TicketController@index') }}">{{ __('Tickets') }}</a> /
                        {{ $ticket->title }}
                    </h6>
                    <h1 class="header-title">
                        {{ $ticket->title }}
                    </h1>
                </div>
                <div class="col-12 col-md-auto mt-2 mt-md-0 mb-md-3">
                    @can('markAsSolved', $ticket)
                        <form id="mark-solved-form" method="POST" action="{{ action('App\TicketController@markAsSolved', $ticket) }}" hidden>
                            @csrf
                        </form>
                        <a class="btn btn-primary btn-md" onclick="event.preventDefault(); document.getElementById('mark-solved-form').submit();">{{ __('Mark as solved') }}</a>
                    @endcan
                    @can('update', $ticket)
                        <a href="{{ action('App\TicketController@edit', $ticket) }}" class="btn btn-white btn-md">{{ __('Edit') }}</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body pb-3">
            <div class="row">
                <div class="col-xl-6 mr-auto">
                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Status') }}:</dt>
                        <dd class="text-black-50">
                            {{ __(App\Models\Ticket::$statuses[$ticket->status]) }}
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('SLA') }}:</dt>
                        <dd class="text-black-50">
                            {{ $ticket->due_at ?? 'Unset' }}
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Country') }}:</dt>
                        <dd class="text-black-50">
                            {{ $ticket->country->name }} ({{ $ticket->country->identifier }})
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Service') }}:</dt>
                        <dd class="text-black-50">
                            {{ $ticket->service->name }} ({{ $ticket->service->identifier }})
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Priority') }}:</dt>
                        <dd class="text-black-50">
                            {{ $ticket->priority->name }}
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Tags') }}:</dt>
                        <dd class="text-black-50">
                            <form id="deleteTicketTagForm" role="form" method="POST">
                                @csrf

                                <input type="hidden" name="_method" value="DELETE">
                            </form>

                            @forelse($ticket->ticketTags as $ticketTag)
                                <a href="#" data-action="{{ action('App\TicketController@destroyTicketTag', [$ticket, $ticketTag]) }}" class="badge badge-light delete-tag">{{ $ticketTag->name }} @can('deleteTicketTag', [$ticket, $ticketTag])<i class="fe fe-trash-2 smallest text-danger ml-1 d-none"></i>@endcan</a>
                            @empty
                                <i class="text-muted"> {{ __('N/A') }}</i>
                            @endforelse

                            <a href="#" data-toggle="modal" data-target="#add-tag-modal" class="add-tag ml-2">{{ __('Add tag') }}</a>
                        </dd>
                    </dl>
                </div>
                <div class="col-xl-6 mr-auto">
                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Assigned user') }}:</dt>
                        <dd class="text-black-50">
                            {{ $ticket->user->name ?? 'Unassigned' }}
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Requested by') }}:</dt>
                        <dd class="text-black-50">
                            {{ $ticket->requester->name }} ({{ $ticket->requester->synega_id }})
                            @can('remindRequester', $ticket)
                                <form id="remind-requester-form" method="POST" action="{{ action('App\TicketController@remindRequester', $ticket) }}" hidden>
                                    @csrf
                                </form>
                                -
                                <a href="#" onclick="event.preventDefault(); document.getElementById('remind-requester-form').submit();">{{ __('Send SMS Reminder') }}</a>
                            @endcan
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Watchers') }}:</dt>
                        <dd class="text-black-50">
                            <form id="deleteForm" role="form" method="POST">
                                @csrf

                                <input type="hidden" name="_method" value="DELETE">
                            </form>

                            @forelse($ticket->watchers as $ticketWatcher)
                                <a href="#" data-action="{{ action('App\TicketController@destroyWatcher', [$ticket, $ticketWatcher]) }}" class="badge badge-light delete-watcher">{{ $ticketWatcher->name }} @can('deleteWatcher', [$ticket, $ticketWatcher])<i class="fe fe-trash-2 smallest text-danger ml-1 d-none"></i>@endcan</a>
                            @empty
                                <i class="text-muted"> {{ __('none') }}</i>
                            @endforelse

                            <a href="#" data-toggle="modal" data-target="#add-watcher-modal" class="add-watcher ml-2">{{ __('Add watcher') }}</a>
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Category') }}:</dt>
                        <dd class="text-black-50">
                            @if($ticket->category->parentCategory)
                                {{ $ticket->category->parentCategory->name }} <i class="fe fe-arrow-right small"></i>
                            @endif
                            {{ $ticket->category->name }}
                        </dd>
                    </dl>

                    <dl class="row mb-0">
                        <dt class="col-auto">{{ __('Issues') }}:</dt>
                        <dd class="text-black-50">
                            @forelse($ticket->issues as $issue)
                                <a href="{{ action('App\IssueController@show', $issue) }}" class="d-block">{{ $issue->title }}</a>
                            @empty
                                <i class="text-muted">{{ __('N/A') }}</i>
                            @endforelse
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <hr class="mt-0">

        <div class="card-body">
            @if($ticket->status != App\Models\Ticket::STATUS_CLOSED)
                <form method="POST" action="{{ action('App\TicketController@reply', $ticket) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <textarea class="wysiwyg" name="content">{!! old('content') !!}</textarea>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="dragupload d-flex align-items-center justify-content-center">
                                <input type="file" id="attachments" name="attachments[]" multiple/>
                                <span class="text-muted">{{ __('Drag your file(s) or click here to upload') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($ticket->status == App\Models\Ticket::STATUS_SOLVED)
                        <div class="col-md-12 alert alert-info" role="alert">
                            {{ __('This ticket will automatically be re-opened when you reply') }}.
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <span>
                                    <input type="submit" class="btn btn-primary send" name="public" value="{{ __('Add as public reply') }}"/>
                                    <input type="submit" disabled class="btn btn-primary loading" value="{{ __('Processing...') }}" style="display:none"/>
                                </span>
                                <span>
                                    <input type="submit" class="btn btn-warning send" value="{{ __('Add as internal note') }}"/>
                                    <input type="submit" disabled class="btn btn-warning loading" value="{{ __('Processing...') }}" style="display:none"/>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-header-title">
                {{ __('Conversation') }}
            </h4>
        </div>
        <div class="card-body pt-0">
            @foreach($comments as $comment)
                <div class="media-body my-4 position-relative">
                    <div class="mb-4">
                        @if ($comment->user->hasRole(\App\Models\User::ROLE_REGULAR))
                            <span class="btn btn-outline-primary btn-sm">
                        @else
                            <span class="btn btn-outline-secondary btn-sm">
                        @endif
                            {{ $comment->user->name}}
                            <small>
                                <span title="{{ $comment->created_at->format('d. M Y, h:i T') }}">
                                    - {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </small>
                        </span>
                    </div>
                    @if($comment->private)
                        <div class="ticket-private-message">
                    @endif

                    {!! $comment->content !!}

                    @if($comment->private)
                        </div>
                        <span class="help-block mt-0">
                            <small class="text-muted">
                                <i>{{ __('This is an internal note. Internal notes are not visible to end users.') }}</i>
                            </small>
                        </span>
                    @endif

                    @if($comment->attachments->count())
                        <div class="mt-4">
                            <small class="text-muted">
                                {{ __('Attachments') }}:
                            </small>
                            @foreach($comment->attachments as $attachment)
                                <br>
                                <a href="{{ action('App\TicketController@downloadAttachment', $attachment) }}">
                                    {{ $attachment->original_filename }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    
    @include('app.tickets.add-watcher')
    @include('app.tickets.add-tag')
@endsection
@section('script')
    <script type="text/javascript">
        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files.length + " files selected");
        });

        $('.send').click(function () {
            $(this).hide();
            $(this).siblings('.loading').show();
        });

        let deleteWatcher = $('.delete-watcher');

        deleteWatcher.on('mouseover', function(){
            $(this).find('i').removeClass('d-none');
        });

        deleteWatcher.on('mouseout', function(){
            $(this).find('i').addClass('d-none');
        });

        deleteWatcher.find('i').on('click', function(e) {
           let deleteForm = $('#deleteForm');

           deleteForm.attr('action', $(this).closest('a').attr('data-action'));
           deleteForm.submit();
        });

        let deleteTag = $('.delete-tag');

        deleteTag.on('mouseover', function () {
            $(this).find('i').removeClass('d-none');
        });

        deleteTag.on('mouseout', function () {
            $(this).find('i').addClass('d-none');
        });

        deleteTag.find('i').on('click', function (e) {
            let deleteTicketTagForm = $('#deleteTicketTagForm');

            deleteTicketTagForm.attr('action', $(this).closest('a').attr('data-action'));
            deleteTicketTagForm.submit();
        });
    </script>
@append
