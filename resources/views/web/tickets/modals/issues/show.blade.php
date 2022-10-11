<div id="issueShowModal" class="modal modal-md fade text-left" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('View Issue') }}</h4>
                <button type="button" class="close pt-4" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{-- Content will be loaded via AJAX --}}
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        $(document).ready(function () {
            let issueModal = $('#issueShowModal');

            $('.show-issue').on('click', function(e){
                e.preventDefault();

                issueModal.find('.modal-body').html('');

                let issueId = $(this).attr('data-id');
                let getIssueEndpoint = "{{ action('Web\IssueController@show', 'ISSUE_ID') }}";
                let getIssueUrl = getIssueEndpoint.replace('ISSUE_ID', issueId);

                $.ajax({
                    url: getIssueUrl,
                    method: 'GET',
                    dataType: 'JSON',
                }).done(function (response) {
                    if (response.html) {
                        issueModal.find('.modal-body').html(response.html);
                        issueModal.modal('show');
                    }
                });
            })
        });
    </script>
@append
