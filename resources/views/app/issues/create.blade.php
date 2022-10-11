@extends('app.layouts.app')

@section('title', __('Create Issue'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\IssueController@index') }}">{{ __('Issues') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create Issue') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\IssueController@store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>{{ __('Title') }}</label>
            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="{{ __('Enter Title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Key') }}</label>
            <input id="key" type="text" class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}" name="key" value="{{ old('key') }}" placeholder="{{ __('Enter Key') }}">

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
                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            @if ($errors->has('status'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Tickets') }}</label>
            <select class="form-control" data-toggle="select" name="tickets[]" id="tickets" multiple>
                @foreach($tickets as $ticket)
                    <option value="{{ $ticket->id }}" {{ collect(old('tickets'))->contains($ticket->id) ? 'selected' : '' }}>{{ $ticket->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('tickets'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('tickets') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('description') ? ' is-invalid' : '' }}">
            <textarea class="wysiwyg" name="description">{!! old('description') !!}</textarea>

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

        <hr class="my-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create Issue') }}
        </button>
        
        <a href="{{ action('App\IssueController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Creation') }}
        </a>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files.length + " files selected");
        });
    </script>
@append