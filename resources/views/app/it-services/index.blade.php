@extends('app.layouts.app')

@section('title', __('All IT Services'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('IT Services') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All IT Services') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\ItService::class)
                        <a href="{{ action('App\ItServiceController@create') }}" class="btn btn-primary">
                            {{ __('Create IT Service') }}
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
            <table class="table table-sm card-table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Identifier') }}</th>
                        <th>{{ __('Note') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($itServices as $itService)
                        <tr>
                            <td>
                                @can('update', $itService)
                                    <a href="{{ action('App\ItServiceController@edit', $itService) }}">
                                        {{ $itService->name }}
                                    </a>
                                @else
                                    {{ $itService->name }}
                                @endcan
                            </td>
                            <td>
                                {{ $itService->identifier }}
                            </td>
                            <td>
                                @if($itService->note)
                                    {!! \Illuminate\Support\Str::limit($itService->note ?? '', 200, '...') !!}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('update', $itService)
                                            <a href="{{ action('App\ItServiceController@edit', $itService) }}" class="dropdown-item">
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
            {{ $itServices->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
