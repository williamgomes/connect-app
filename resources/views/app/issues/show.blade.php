@extends('app.layouts.app')

@section('title', $issue->title)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\IssueController@index') }}">{{ __('Issues') }}</a> /
                        {{ $issue->title }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Issues') }}
                    </h1>
                </div>
                @can('update', $issue)
                    <div class="col-auto">
                        <a href="{{ action('App\IssueController@edit', $issue) }}" class="btn btn-primary">
                            {{ __('Edit') }}
                        </a>
                    </div>
                @endcan
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        <li class="nav-item">
                            <a href="{{ action('App\IssueController@show', $issue) }}" class="nav-link active">
                                {{ __('Overview') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Title') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted">
                            {{ $issue->title }}
                        </small>
                    </div>
                </div>

                @if($issue->key)
                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Key') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                <button class="btn btn-white btn-sm copy-to-clipboard" data-clipboard-text="{{ $issue->key }}" title="{{ __('Click to copy') }}">
                                    <span class="fe fe-copy"></span>
                                    {{ $issue->key }}
                                </button>
                            </small>
                        </div>
                    </div>
                @endif

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Type') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted">
                            @if($issue->type == \App\Models\Issue::TYPE_BUG)
                                <span class="badge badge-soft-danger">{{ __('Bug') }}</span>
                            @elseif($issue->type == \App\Models\Issue::TYPE_FEATURE)
                                <span class="badge badge-soft-primary">{{ __('Feature') }}</span>
                            @endif
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Status') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted">
                            @if($issue->status == \App\Models\Issue::STATUS_AWAITING_SPECIFICATION)
                                <span class="badge badge-soft-warning">{{ __('Awaiting Specification') }}</span>
                            @elseif($issue->status == \App\Models\Issue::STATUS_BACKLOG)
                                <span class="badge badge-soft-dark">{{ __('Backlog') }}</span>
                            @elseif($issue->status == \App\Models\Issue::STATUS_DECLINED)
                                <span class="badge badge-soft-danger">{{ __('Declined') }}</span>
                            @elseif($issue->status == \App\Models\Issue::STATUS_DONE)
                                <span class="badge badge-soft-success">{{ __('Done') }}</span>
                            @elseif($issue->status == \App\Models\Issue::STATUS_IN_PROGRESS)
                                <span class="badge badge-soft-primary">{{ __('In progress') }}</span>
                            @elseif($issue->status == \App\Models\Issue::STATUS_QUALITY_ASSURANCE)
                                <span class="badge badge-soft-secondary">{{ __('Quality Assurance') }}</span>
                            @endif
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Author') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted">
                            <a href="{{ action('App\UserController@show', $issue->author) }}">{{ $issue->author->name }}</a>
                        </small>
                    </div>
                </div>

                @if($issue->attachments->count())
                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Attachments') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="text-right">
                                @foreach($issue->attachments as $attachment)
                                    <a href="{{ action('App\IssueController@showAttachment', $attachment) }}" target="_blank">
                                        {{ $attachment->original_filename }}
                                    </a>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if($issue->tickets->count())
                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Tickets') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="text-right">
                                @foreach($issue->tickets as $ticket)
                                    <a href="{{ action('App\TicketController@show', $ticket) }}" target="_blank">
                                        {{ $ticket->title }}
                                    </a>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-header">
               <h4 class="card-header-title">{{ __('Description') }}</h4>
            </div>
            <div class="card-body">
                {!! $issue->description !!}
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">
                    {{ __('Comments') }}
                </h4>
            </div>
            <div class="card-body">
                @forelse ($comments as $comment)
                    <div class="comment mb-3 chat-message">
                        <div class="comment-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="comment-title">
                                        <strong>
                                            <a href="{{ action('App\UserController@show', $comment->user) }}">{{ $comment->user->name }}</a>
                                        </strong>
                                    </h5>
                                </div>
                                <div class="col-auto">
                                    <time class="comment-time" title="{{ $comment->created_at->format('d. M Y, h:i T') }}">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </time>
                                </div>
                            </div>
                            <div class="comment-text">
                                {!! $comment->content !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <i class="text-muted">{{ __('No Comments') }}</i>
                    </div>
                @endforelse
                <hr>
                <div class="row">
                    <div class="col">
                        <form class="mt-1" method="POST" action="{{ action('App\IssueController@addComment', $issue) }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label class="sr-only">{{ __('Leave a comment...') }}</label>
                                    <textarea class="form-control form-control-flush wysiwyg" name="content" data-toggle="autosize" rows="1" placeholder="{{ __('Leave a comment') }}" style="overflow: hidden; overflow-wrap: break-word; height: 40px;">{{ old('content') }}</textarea>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-block btn-white" type="submit">
                                        {{ __('Post') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        new ClipboardJS('.copy-to-clipboard');
    </script>
@append
