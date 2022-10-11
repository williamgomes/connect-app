@extends('app.layouts.app')

@section('title', __('Create Report Folder'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ReportFolderController@index') }}">{{ __('Report Folders') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create Report Folder') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ReportFolderController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Parent Report Folder') }}</label>

            <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5", "allowClear": true, "placeholder": "{{ __('No parent report folder') }}"}' name="parent_id" id="parent_id">
                <option></option>
                @foreach($parentReportFolders->sortBy('name')->where('parent_id', null) as $parentReportFolder)
                    <option value="{{ $parentReportFolder->id }}" {{ (old('parent_id', app('request')->input('parent_id')) == $parentReportFolder->id) ? ' selected' : '' }}>{{ $parentReportFolder->name }}</option>
                    @if($parentReportFolders->where('parent_id', $parentReportFolder->id)->count())
                        @include('app.reports.folders.structure-helper', ['allFolders' => $parentReportFolders, 'subfolders' => $parentReportFolders->sortBy('name')->where('parent_id', $parentReportFolder->id), 'selected' => old('parent_id', app('request')->input('parent_id'))])
                    @endif
                @endforeach
            </select>

            @if ($errors->has('parent_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('parent_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create Report Folder') }}
        </button>

        <a href="{{ app('request')->has('parent_id') ? action('App\ReportFolderController@show', app('request')->input('parent_id')) : action('App\ReportFolderController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Creation') }}
        </a>
    </form>
@endsection
