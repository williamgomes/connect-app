@extends('web.layouts.app')

@section('title', __('Report'))

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\ReportFolderController@index') }}" class="text-gray-700">
                                {{ __('Reports') }}
                            </a>
                        </li>
                        @include('web.reports.folders.breadcrumbs', ['reportFolder' => $report->folder])
                        <li class="breadcrumb-item">
                            {{ $report->title }}
                        </li>
                    </ol>
                    @if($report->description)
                        <small class="text-muted">{{ $report->description }}</small>
                    @endif
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <iframe src="{{ $iframeUrl }}" style="height:100vh" frameBorder="0" width="100%" allowTransparency/>

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
@endsection
