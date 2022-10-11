@extends('app.layouts.app')

@section('title', __('View') . ' ' . $currentReportFolder->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ReportFolderController@index') }}">{{ __('Report Folders') }}</a> /
                        @include('app.reports.folders.breadcrumbs', ['reportFolder' => $currentReportFolder])
                    </h6>
                    <h1 class="header-title">
                        {{ __('View Report Folder') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\ReportFolder::class)
                        <a href="{{ action('App\ReportFolderController@create', ['parent_id' => $currentReportFolder->id]) }}" class="btn btn-primary">
                            {{ __('Create Report Folder') }}
                        </a>
                    @endcan
                    @can('update', $currentReportFolder)
                        <a href="{{ action('App\ReportFolderController@edit', $currentReportFolder) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('app.reports.folders.show-all')
@endsection
