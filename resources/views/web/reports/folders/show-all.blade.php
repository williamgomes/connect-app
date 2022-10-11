<section class="mt-n6">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-row shadow-light-lg mb-6">
                    <div class="card-body pt-7 pb-5">
                        <div class="row">
                            @foreach($reportFolders as $reportFolder)
                                <div class="col-md-4">
                                    <a class="d-block text-black pb-3 pl-4" href="{{ action('Web\ReportFolderController@show', $reportFolder) }}">
                                        {{ $reportFolder->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

