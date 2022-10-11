<div id="add-tag-modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add tag') }}</h4>
                <button type="button" class="close pt-4" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ action('App\TicketController@createTicketTag', $ticket) }}">
                    @csrf

                    <div class="form-group">
                        <label>{{ __('Tag') }}</label>
                        <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5"}' name="ticket_tags[]" id="ticket_tag_id" multiple>
                            @foreach ($ticketTags as $ticketTag)
                                <option value="{{ $ticketTag->id }}">{{ $ticketTag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit">{{ __('Submit') }}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
