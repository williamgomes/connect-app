@extends('web.layouts.app')

@section('title', __('Ticket:') . ' ' . $ticket->title)

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\TicketController@index') }}">
                                {{ __('Tickets') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $ticket->title }}
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
                        {{ $ticket->title }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        #{{ $ticket->id }}
                    </p>
                </div>
                @can('markAsSolved', $ticket)
                    <div class="col-auto">
                        <form id="mark-solved-form" method="POST" action="{{ action('Web\TicketController@markAsSolved', $ticket) }}" hidden>
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
                                {{ __(\App\Models\Ticket::$statuses[$ticket->status]) }}
                            </small>

                            <hr>

                            @if($ticket->status == \App\Models\Ticket::STATUS_OPEN)
                                <h6 class="font-weight-bold text-uppercase">
                                    {{ __('SLA') }}
                                </h6>
                                @if ($ticket->due_at > now())
                                    <small>
                                @else
                                    <small class="text-danger">
                                @endif
                                {{ ucfirst($ticket->due_at->diffForHumans()) }}
                                </small>

                                <hr>
                            @endif                            

                            <h6 class="font-weight-bold text-uppercase">
                                {{ __('Assigned to') }}
                            </h6>
                            <small>
                                @if ($ticket->user)
                                    {{ $ticket->user->name }}
                                @else
                                    -
                                @endif
                            </small>

                            <hr>

                            <h6 class="font-weight-bold text-uppercase">
                                {{ __('Connected Issues') }}
                            </h6>
                            <small>
                                @forelse($ticket->issues as $issue)
                                    <a href="#" class="d-block show-issue" data-id="{{ $issue->id }}">{{ $issue->title }}</a>
                                @empty
                                    <i class="text-muted">-</i>
                                @endforelse
                            </small>

                            <hr>

                            <h6 class="font-weight-bold text-uppercase">
                                {{ __('Primary') }}
                            </h6>
                            <small>
                                {{ $ticket->priority->name }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card shadow-light-lg">
                        <div class="card-body">
                            @include('web.layouts.flash-alerts')

                            @foreach($comments as $comment)
                                <div class="align-items-center row">
                                    <div class="col-auto pl-0 pr-2">
                                        <div class="avatar avatar-xl p-md-2 p-0 mb-1 ml-4 ml-md-3 account-img">
                                            <img src="{{ Storage::disk('s3')->temporaryUrl('images/profile/' . $comment->user->profile_picture, now()->addMinutes(5)) }}" class="avatar-img rounded-circle border border-4 border-body" title="{{ __('Click to upload profile picture') }}" onclick="$('#profile_picture').click()">
                                        </div>
                                    </div>
                                    <div class="col pl-0">
                                        <span>
                                            {{ $comment->user->name }}
                                            @if (! $comment->user->hasRole(\App\Models\User::ROLE_REGULAR))
                                                -
                                                <small class="text-muted">
                                                    <span class="text-primary fe fe-shield"></span>
                                                    {{ __('Connect Team') }}
                                                </small>
                                            @endif
                                        </span>
                                        <br>
                                        <small>
                                            <span class="text-muted" title="{{ $comment->created_at->format('d. M Y, h:i T') }}">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    {!! $comment->content !!}
                                </div>
                                @if($comment->attachments->count())
                                    <div class="mt-6">
                                        <small class="text-muted">
                                            {{ __('Attachments') }}:
                                        </small>
                                        <small>
                                            @foreach($comment->attachments as $attachment)
                                                <br>
                                                <a href="{{ action('Web\TicketController@downloadAttachment', $attachment) }}">
                                                    {{ $attachment->original_filename }}
                                                </a>                            
                                            @endforeach
                                        </small>
                                    </div>
                                @endif
                                <hr>
                            @endforeach

                            @if($ticket->status == \App\Models\Ticket::STATUS_SOLVED)
                                <small class="text-muted">
                                    <i>{{ __('If you add a comment, the ticket will automatically be re-opened.') }}</i>
                                </small>
                            @endif

                            <form method="POST" action="{{ action('Web\TicketController@reply', $ticket) }}" enctype="multipart/form-data">
                                <div class="row">
                                    @csrf

                                    {{-- Comment --}}
                                    <div class="col-12">
                                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                            <textarea class="wysiwyg" name="content">{!! old('content') !!}</textarea>
                                            @if ($errors->has('content'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('content') }}</strong>
                                                </span>
                                            @endif
                                        </div>
    
                                        {{-- Attachments --}}
                                        <div class="form-group{{ $errors->has('attachments') ? ' has-error' : '' }}">
                                            <div class="col-md-12 px-0">
                                                <div class="dragupload d-flex align-items-center justify-content-center">
                                                    <input type="file" id="attachments" name="attachments[]" multiple/>
                                                    <span class="text-muted">{{ __('Drag your file(s) or click here to upload') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 col-md-auto">
                                        <button class="btn btn-block btn-primary" type="submit">
                                            {{ __('Add comment') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
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

    @include('web.tickets.modals.issues.show')
@endsection

@section('script')
    <script type="text/javascript">
        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files.length + " files selected");
        });
    </script>
@append

