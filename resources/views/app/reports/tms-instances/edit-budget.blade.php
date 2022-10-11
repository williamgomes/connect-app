@extends('app.layouts.app')

@section('title', __('Edit Budget'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Reports') }} /
                        <a href="{{ action('App\ReportController@tmsInstances') }}">{{ __('TMS Instances') }}</a> /
                        <a href="{{ action('App\ReportController@showTmsInstance', $tmsInstance) }}">{{ $tmsInstance->name }}</a> /
                        {{ __('Edit Budget') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Budget of') }} {{ \App\Models\TmsInstance::$types[$type] }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-6" role="form" method="POST" action="{{ action('App\ReportController@updateBudget', [$tmsInstance, $type, $period]) }}">
        <div class="card">
            @csrf
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered card-body mb-0">
                        <thead>
                        <tr>
                            <th class="text-center">{{ __('Period') }}</th>
                            <th>{{ __('Budgeted Value') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dates as $date)
                            <tr>
                                <td style="width:180px" class="text-center">{{ $date['label'] }}</td>
                                <td>
                                    <input type="number" step="0.01" name="budget_values[{{ $date['key'] }}]" class="form-control" value="{{ old('budget_values')[$date['key']] ?? ($values[$date['key']] ?? '') }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        <hr class="my-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update') }}
        </button>

        <a href="{{ action('App\ReportController@tmsInstances') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection
