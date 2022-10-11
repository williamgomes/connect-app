@extends('app.layouts.app')

@section('title', __('View') . ' ' . $report->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ReportController@index') }}">{{ __('Reports') }}</a> /
                        <a href="{{ action('App\ReportController@show', $report) }}">{{ $report->title }}</a> /
                        {{ __('View') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('View Report') }}
                    </h1>

                    @if($report->description)
                        <span class="text-muted pt-2 d-block">{{ $report->description }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <style>
        body {
            background: white;
        }
    </style>
@append

@section('content')
    <iframe src="{{ $iframeUrl }}" style="height:100vh" frameBorder="0" width="100%" allowTransparency/>
@endsection
