@extends('app.layouts.app')

@section('title', $apiApplication->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ApiApplicationController@index') }}">{{ __('Applications') }}</a> /
                        {{ $apiApplication->name }}
                    </h6>
                    <h1 class="header-title">
                        {{ $apiApplication->name }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\ApiApplicationToken::class)
                        <a href="{{ action('App\ApiApplicationTokenController@create', $apiApplication) }}" class="btn btn-primary">
                            {{ __('Generate token') }}
                        </a>
                    @endcan
                    @can('update', $apiApplication)
                        <a href="{{ action('App\ApiApplicationController@edit', $apiApplication) }}" class="btn btn-primary">
                            {{ __('Edit') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["token-identifier", "token-status", "token-days", "token-created-by", "token-revoked-by"]}'>
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="row align-items-center">
                        <div class="col-auto pr-0">
                            <span class="fe fe-search text-muted"></span>
                        </div>
                        <div class="col">
                            <input type="search" class="form-control form-control-flush search" placeholder="{{ __('Search') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-nowrap card-table">
                <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="token-identifier">
                                {{ __('Identifier') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="token-status">
                                {{ __('Status') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="token-days">
                                {{ __('Days') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort">
                                {{ __('Last used') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="token-created-by">
                                {{ __('Created by') }}
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="token-revoked-by">
                                {{ __('Revoked by') }}
                            </a>
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($apiApplicationTokens as $apiApplicationToken)
                        <tr>
                            <td class="token-identifier">
                                {{ $apiApplicationToken->identifier }}
                            </td>
                            <td class="token-status">
                                @if (is_null($apiApplicationToken->revoked_at))
                                    <span class="text-success">●</span>
                                    {{ __('Active') }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ __('Revoked') }}
                                @endif
                            </td>
                            <td class="token-days">
                                @if ($apiApplicationToken->days() < 100)
                                    <span class="text-success">●</span>
                                    {{ $apiApplicationToken->days() }}
                                @else
                                    <span class="text-danger">●</span>
                                    {{ $apiApplicationToken->days() }}
                                @endif
                            </td>
                            <td>
                                @if ($apiApplicationToken->last_used_at)
                                    {{ $apiApplicationToken->last_used_at->diffForHumans() }}
                                @else
                                    {{ __('Never used') }}
                                @endif
                            </td>
                            <td class="token-created-by">
                                {{ $apiApplicationToken->createdBy->name }}
                            </td>
                            <td class="token-revoked-by">
                                @if ($apiApplicationToken->revoked_by)
                                    {{ $apiApplicationToken->revokedBy->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">
                                @can('revoke', $apiApplicationToken)
                                    <div class="dropdown">
                                        <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <form action="{{ action('App\ApiApplicationTokenController@revoke', [$apiApplication, $apiApplicationToken]) }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item">
                                                        {{ __('Revoke') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
