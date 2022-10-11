@if($reportFolder->parentFolder)
    @include('web.reports.folders.breadcrumbs', ['reportFolder' => $reportFolder->parentFolder])
@endif

<li class="breadcrumb-item">
    <a href="{{ action('Web\ReportFolderController@show', $reportFolder) }}" class="text-gray-700">{{ $reportFolder->name }}</a>
</li>
