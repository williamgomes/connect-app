@extends('app.layouts.app')

@section('title', __('All Datacenters'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        {{ __('Datacenters') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('All Datacenters') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\Datacenter::class)
                        <a href="{{ action('App\DatacenterController@create') }}" class="btn btn-primary">
                            {{ __('Create Datacenter') }}
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
                        <th>{{ __('Country/Location(ID)') }}</th>
                        <th>{{ __('Note') }}</th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($datacenters as $datacenter)
                        <tr>
                            <td>
                                @can('update', $datacenter)
                                    <a href="{{ action('App\DatacenterController@edit', $datacenter) }}">
                                        {{ $datacenter->name }}
                                    </a>
                                @else
                                    {{ $datacenter->name }}
                                @endcan
                            </td>
                            <td>
                                {{ $datacenter->country }} / {{ $datacenter->location }} ({{ $datacenter->location_id }})
                            </td>
                            <td>
                                @if($datacenter->note)
                                    {!! \Illuminate\Support\Str::limit($datacenter->note ?? '', 200, '...') !!}
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
                                        @can('update', $datacenter)
                                            <a href="{{ action('App\DatacenterController@edit', $datacenter) }}" class="dropdown-item">
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
            {{ $datacenters->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
