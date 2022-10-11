<h3>
    {{ \App\Models\TmsInstance::$types[$type] }} @if(@$description)<span class="text-muted">{{ $description }}</span>@endif
</h3>
<div class="row">
    @foreach([\App\Models\TmsInstance::PERIOD_DAY, \App\Models\TmsInstance::PERIOD_MONTH, \App\Models\TmsInstance::PERIOD_YEAR] as $period)
        @include('app.reports.tms-instances.partials.chart', ['chart' => $type, 'period' => $period])
    @endforeach
</div>
