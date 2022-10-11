@php($uniqueIdentifier = $chart . '_' . $period)
<div class="col {{ $period == \App\Models\TmsInstance::PERIOD_DAY ? 'col-md-5' : ($period == \App\Models\TmsInstance::PERIOD_YEAR ? 'col-md-3' : 'col-md-4') }}">
    <div class="card">
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:25vh">
                <canvas id="{{ $uniqueIdentifier }}_chart" class="chart-canvas"></canvas>
            </div>
        </div>

        <div class="dropdown position-absolute" style="right:5px; top:7px;">
            <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fe fe-more-vertical"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ action('App\ReportController@editBudget', [$selectedTmsInstance, $chart, $period]) }}" class="dropdown-item">
                    {{ __('Edit Budget') }}
                </a>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            initChart(
                $('#' + '{{ $uniqueIdentifier }}' + '_chart'),
                JSON.parse('@json($labels[$period])'),
                JSON.parse('@json(array_values($data[$chart][$period]))'),
                JSON.parse('@json($data[$chart][$period])'),
                '{{ $chart }}',
                '{{ $period }}');
        });
    </script>
@append
