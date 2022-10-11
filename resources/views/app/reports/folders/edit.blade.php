@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $reportFolder->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ReportFolderController@index') }}">{{ __('Report Folders') }}</a> /
                        <a href="{{ action('App\ReportFolderController@show', $reportFolder) }}">{{ $reportFolder->name }}</a> /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Report Folder') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $reportFolder)
                        <form role="form" method="POST" action="{{ action('App\ReportFolderController@destroy', $reportFolder) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete Report Folder') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ReportFolderController@update',  $reportFolder) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Parent Report Folder') }}</label>
            <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5", "allowClear": true, "placeholder": "{{ __('No parent report folder') }}"}' name="parent_id" id="parent_id">
                <option></option>
                @foreach($parentReportFolders->sortBy('name')->where('parent_id', null) as $parentReportFolder)
                    <option value="{{ $parentReportFolder->id }}" {{ (old('parent_id', $reportFolder->parent_id) == $parentReportFolder->id) ? ' selected' : '' }}>{{ $parentReportFolder->name }}</option>
                    @if($parentReportFolders->where('parent_id', $parentReportFolder->id)->count())
                        @include('app.reports.folders.structure-helper', ['allFolders' => $parentReportFolders, 'subfolders' => $parentReportFolders->sortBy('name')->where('parent_id', $parentReportFolder->id), 'selected' => $reportFolder->parent_id])
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

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name',  $reportFolder->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Report Folder') }}
        </button>


        <a href="{{ action('App\ReportFolderController@show', $reportFolder) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
