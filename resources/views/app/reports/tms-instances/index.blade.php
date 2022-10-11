@extends('app.layouts.app')

@section('title', __('TMS Instances Report'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Reports') }} /
                        {{ __('TMS Instances') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('TMS Instances Report') }}
                    </h1>
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
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Identifier') }}</th>
                </tr>
                </thead>
                <tbody class="list">
                @foreach($tmsInstances as $tmsInstance)
                    <tr>
                        <td>
                            <a href="{{ action('App\ReportController@showTmsInstance', $tmsInstance) }}">
                                {{ $tmsInstance->name }}
                            </a>
                        </td>
                        <td>
                            {{ $tmsInstance->identifier }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
