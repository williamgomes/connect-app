@extends('app.layouts.app')

@section('title', __('Issues'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Issues') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Issues') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Issue::class)
                        <a href="{{ action('App\IssueController@create') }}" class="btn btn-primary">
                            {{ __('Create Issue') }}
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
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Key') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($issues as $issue)
                        <tr>
                            <td>
                                <a href="{{ action('App\IssueController@show', $issue) }}">
                                    {{ $issue->title }}
                                </a>
                            </td>
                            <td>
                                @if($issue->key)
                                    <button class="btn btn-white btn-sm copy-to-clipboard" data-clipboard-text="{{ $issue->key }}" title="{{ __('Click to copy') }}">
                                        <span class="fe fe-copy"></span>
                                        {{ $issue->key }}
                                    </button>
                                @else
                                    <i class="text-muted">{{ __('N/A') }}</i>
                                @endif
                            </td>
                            <td>
                                @if($issue->type == \App\Models\Issue::TYPE_BUG)
                                    <span class="badge badge-soft-danger">{{ __('Bug') }}</span>
                                @elseif($issue->type == \App\Models\Issue::TYPE_FEATURE)
                                    <span class="badge badge-soft-primary">{{ __('Feature') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ action('App\UserController@show', $issue->author) }}">{{ $issue->author->name }}</a>
                            </td>
                            <td>
                                @if($issue->status == \App\Models\Issue::STATUS_AWAITING_SPECIFICATION)
                                    <span class="badge badge-soft-warning">{{ __('Awaiting Specification') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_BACKLOG)
                                    <span class="badge badge-soft-dark">{{ __('Backlog') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_DECLINED)
                                    <span class="badge badge-soft-danger">{{ __('Declined') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_DONE)
                                    <span class="badge badge-soft-success">{{ __('Done') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_IN_PROGRESS)
                                    <span class="badge badge-soft-primary">{{ __('In progress') }}</span>
                                @elseif($issue->status == \App\Models\Issue::STATUS_QUALITY_ASSURANCE)
                                    <span class="badge badge-soft-secondary">{{ __('Quality Assurance') }}</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('view', $issue)
                                            <a href="{{ action('App\IssueController@show', $issue) }}" class="dropdown-item">
                                                {{ __('Show') }}
                                            </a>
                                        @endcan
                                        @can('update', $issue)
                                            <a href="{{ action('App\IssueController@edit', $issue) }}" class="dropdown-item">
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
        </div>
        <div class="row justify-content-center">
            {{ $issues->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        new ClipboardJS('.copy-to-clipboard');
    </script>
@append