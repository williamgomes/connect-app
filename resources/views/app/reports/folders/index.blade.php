@extends('app.layouts.app')

@section('title', __('All Report Folders'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Report Folders') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Report Folders') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\ReportFolder::class)
                        <a href="{{ action('App\ReportFolderController@create') }}" class="btn btn-primary">
                            {{ __('Create Report Folder') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('app.reports.folders.show-all')
@endsection
