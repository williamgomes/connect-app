@if($reportFolder->parentFolder)
    @include('app.reports.folders.breadcrumbs', ['reportFolder' => $reportFolder->parentFolder]) /
@endif

<a href="{{ action('App\ReportFolderController@show', $reportFolder) }}">{{ $reportFolder->name }}</a>
