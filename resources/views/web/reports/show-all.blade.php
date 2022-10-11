<section class="mt-n6">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-row shadow-light-lg mb-6">
                    <div class="card-body pt-7 pb-5">
                        @foreach($reports as $report)
                            <a href="{{ action('Web\ReportController@show', $report) }}" class="d-block mt-2">
                                {{ $report->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
