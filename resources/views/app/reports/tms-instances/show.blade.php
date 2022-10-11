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
                        <a href="{{ action('App\ReportController@tmsInstances') }}">{{ __('TMS Instances') }}</a> /
                        {{ __('View Instance') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('TMS Instances Report') }}
                    </h1>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        @foreach ($tmsInstances as $tmsInstance)
                            <li class="nav-item">
                                <a href="{{ action('App\ReportController@showTmsInstance', $tmsInstance) }}" class="nav-link {{ $selectedTmsInstance->id == $tmsInstance->id ? 'active' : '' }}">
                                    {{ $tmsInstance->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_REVENUE])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_NEW_USER_LEADS])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_NEW_EMPLOYEES])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_EMPLOYEE_CONVERSION, 'description' => '%'])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_EMPLOYEES_DEACTIVATED])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_EMPLOYEE_CHURN, 'description' => '%'])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_USER_RATINGS])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_NEW_CLIENT_LEADS])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_NEW_CLIENTS])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_CLIENT_CONVERSION, 'description' => '%'])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_CLIENTS_DEACTIVATED])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_CLIENT_CHURN, 'description' => '%'])

    @include('app.reports.tms-instances.partials.charts-block', ['type' => \App\Models\TmsInstance::TYPE_CLIENT_RATINGS, 'description' => '%'])
@endsection

@section('script')
    <script>
        function initChart(chart, labels, data, dataWithDates, type, period) {
            let chartUnit = new Chart(chart, {
                type: 'line',
                options: {
                    scales: {
                        gridLines: {
                            drawOnChartArea: false
                        },

                        yAxes: [{
                            afterTickToLabelConversion : function(q){
                                // Format yAxis numbers
                                for(let tick in q.ticks){
                                    if(q.ticks[tick] >= 1000){
                                        q.ticks[tick] = formatNumber(q.ticks[tick]);
                                    }
                                }
                            },
                            ticks: {
                                maxTicksLimit: 12,
                            }
                        }]
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                // Format tooltips numbers
                                return tooltipItem.yLabel >= 1000 ? formatNumber(tooltipItem.yLabel) : tooltipItem.yLabel;
                            }
                        }
                    }
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: data,
                            borderColor: '#2c7be5',
                            backgroundColor: '#73a2f7',
                        },
                    ],
                },
            });

            // Get budget values for a chart via AJAX call
            let budgetData = getBudgetData(type, period);

            // Replace with actual data value if no budgeted value is set
            let budgetValues = {};
            for (const key in dataWithDates) {
                budgetValues[key] = (budgetData[key] === null || typeof budgetData[key] === 'undefined') ? dataWithDates[key] : budgetData[key];
            }

            // Dynamically add new dataset(line) to chart
            addBudgetDataset(chartUnit, Object.values(budgetValues));
        }

        // Load budget values
        function getBudgetData(type, period) {
            let data = [];
            $.ajax({
                url: '{{ action('Ajax\ReportBudgetController@show') }}',
                data: {
                    'tms_instance_id': '{{ $selectedTmsInstance->id }}',
                    'type': type,
                    'period': period,
                },
                method: 'GET',
                async: false,
            }).done(function (response) {
                if (response.data) {
                    data = response.data;
                }
            });

            return data;
        }

        function addBudgetDataset(chart, data) {
            chart.data.datasets.push(
                {
                    data: data,
                    borderColor: 'rgba(222,81,81,0.41)',
                    backgroundColor: 'rgba(255,99,99,0.26)',
                });

            chart.update();
        }

        function formatNumber(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            let rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ' ' + '$2');
            }
            return x1 + x2;
        }
    </script>
@append
