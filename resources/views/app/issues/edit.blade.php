@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $issue->title)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\IssueController@index') }}">{{ __('Issues') }}</a> /
                        <a href="{{ action('App\IssueController@show', $issue) }}">{{ $issue->title }}</a> /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit') }} {{ $issue->title }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\IssueController@update', $issue) }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>{{ __('Title') }}</label>
            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title', $issue->title) }}" placeholder="{{ __('Enter Title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Key') }}</label>
            <input id="key" type="text" class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}" name="key" value="{{ old('key', $issue->key) }}" placeholder="{{ __('Enter Key') }}">

            @if ($errors->has('key'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('key') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Type') }}</label>
            <select class="form-control" data-toggle="select" name="type" id="type">
                @foreach(\App\Models\Issue::$types as $key => $label)
                    <option value="{{ $key }}" {{ old('type', $issue->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Status') }}</label>
            <select class="form-control" data-toggle="select" name="status" id="status">
                @foreach(\App\Models\Issue::$statuses as $key => $label)
                    <option value="{{ $key }}" {{ old('status', $issue->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            @if ($errors->has('status'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>

        {{-- Hidden tickets attribute in payload so that user can clear all relations in pivot table --}}
        <input type="hidden" name="tickets" value="">
        <div class="form-group">
            <label>{{ __('Tickets') }}</label>
            <select class="form-control" data-toggle="select" name="tickets[]" id="tickets" multiple>
                @foreach($tickets as $ticket)
                    <option value="{{ $ticket->id }}" {{ collect(old('tickets', $issue->tickets->pluck('id')))->contains($ticket->id) ? 'selected' : '' }}>{{ $ticket->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('tickets'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('tickets') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('description') ? ' is-invalid' : '' }}">
            <textarea class="wysiwyg" name="description">{!! old('description', $issue->description) !!}</textarea>

            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <div class="dragupload d-flex align-items-center justify-content-center">
            <input type="file" id="attachments" name="attachments[]" multiple/>
            <span class="text-muted">{{ __('Drag your file(s) or click here to upload') }}</span>
        </div>

        @if($issue->attachments->count())
            <div class="card my-4 attachments-block">
                <table class="table table-sm card-table table-hover">
                    <tbody>
                        @foreach($issue->attachments as $attachment)
                            <tr class="attachment-row">
                                <td>
                                    <a href="{{ action('App\IssueController@showAttachment', $attachment) }}" target="_blank">
                                        {{ $attachment->original_filename }}
                                    </a>
                                </td>
                                <td>
                                    <a class="delete-attachment text-danger float-right ml-3" href="javascript:void(0)" data-attachment-id="{{ $attachment->id }}"><i class="fe fe-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Issue') }}
        </button>

        <a href="{{ action('App\IssueController@show', $issue) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(document).on("click", ".delete-attachment", function (event) {
                let attachmentId = $(this).data('attachment-id');
                let attachmentRow = $(this).closest('.attachment-row');

                let destroyEndpoint = "{{ action('Ajax\IssueAttachmentController@destroy', 'ATTACHMENT_ID') }}";
                let url = destroyEndpoint.replace('ATTACHMENT_ID', attachmentId);

                swal({
                    title: '{{ __('Are you sure?') }}',
                    text: "{!! __('You won\'t be able to revert this!') !!}",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('Yes, delete it!') }}'
                }).then(function () {
                    $.ajax({
                        method: "DELETE",
                        url: url,
                        data: {_token: "{{ csrf_token() }}"}
                    }).done(function (msg) {
                        if (msg.success == true) {
                            swal('{{ __('Deleted!') }}', '{{ __('Your attachment has been deleted.') }}', 'success');
                            attachmentRow.remove();

                            if(!$('.attachment-row').length){
                                $('.attachments-block').remove();
                            }
                        } else {
                            swal('{{ __('Deleted!') }}', '{{ __('Attachment has not been deleted.') }}', 'error');
                        }
                    }).fail(function () {
                        swal('{{ __('Deleted!') }}', '{{ __('Internal error') }}', 'error');
                    });
                })
            });
        })
    </script>
@append