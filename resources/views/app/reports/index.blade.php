@extends('app.layouts.app')

@section('title', __('All Reports'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Reports') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Reports') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Report::class)
                        <a href="{{ action('App\ReportController@create') }}" class="btn btn-primary">
                            {{ __('Create Report') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <form>
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <span class="fe fe-search text-muted"></span>
                            </div>
                            <div class="col">
                                <input type="text" name="search" class="form-control form-control-flush" value="{{ app('request')->input('search') }}" placeholder="{{ __('Search') }}" autofocus>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-nowrap card-table">
                <thead>
                    <tr>
                        <th>{{ __('Title (Folder)') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Owner') }}</th>
                        <th>{{ __('Who Has Access') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($reports as $report)
                        <tr>
                            <td>
                                @can('update', $report)
                                    <a href="{{ action('App\ReportController@edit', $report) }}">
                                        {{ $report->title }}
                                    </a>
                                @else
                                    {{ $report->title }}
                                @endcan
                                <small class="text-muted d-block">{{ $report->folder->fullPath() }}</small>
                            </td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($report->description, 45, '...') }}
                            </td>
                            <td>
                                <a href="{{ action('App\UserController@show', $report->owner) }}">
                                    {{ $report->owner->name }}
                                </a>
                            </td>
                            <td>
                                @foreach($report->users as $user)
                                    <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a>@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $report)
                                            <a href="{{ action('App\ReportController@edit', $report) }}" class="dropdown-item">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center">
                {{ $reports->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
