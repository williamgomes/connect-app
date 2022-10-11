@extends('app.layouts.app')

@section('title', __('Create Report'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ReportController@index') }}">{{ __('Reports') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create Report') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ReportController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Folder') }}</label>

            <select class="form-control" data-toggle="select" name="folder_id" id="folder_id">
                @foreach($reportFolders->sortBy('name')->where('parent_id', null) as $reportFolder)
                    <option value="{{ $reportFolder->id }}" {{ (old('folder_id') == $reportFolder->id) ? ' selected' : '' }}>{{ $reportFolder->name }}</option>
                    @if($reportFolder->subfolders->count())
                        @include('app.reports.folders.structure-helper', ['allFolders' => $reportFolders, 'subfolders' => $reportFolder->subfolders])
                    @endif
                @endforeach
            </select>

            @if ($errors->has('folder_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('folder_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Title') }}</label>

            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="{{ __('Enter title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Description') }}</label>

            <textarea id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="{{ __('Enter description') }}">{{ old('description') }}</textarea>

            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Metabase ID') }}</label>

            <input id="metabase_id" type="text" class="form-control {{ $errors->has('metabase_id') ? 'is-invalid' : '' }}" name="metabase_id" value="{{ old('metabase_id') }}" placeholder="{{ __('Enter metabase_id') }}" required autofocus>

            @if ($errors->has('metabase_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('metabase_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Users') }}</label> <small class="text-muted">({{ __('who will have access') }})</small>
            <select class="form-control" data-toggle="select" name="users[]" id="users" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ collect(old('users'))->contains($user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('users'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('users') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create Report') }}
        </button>

        <a href="{{ action('App\ReportController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Creation') }}
        </a>
    </form>
@endsection
