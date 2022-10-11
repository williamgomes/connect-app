<div id="add-watcher-modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add watcher') }}</h4>
                <button type="button" class="close pt-4" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ action('App\TicketController@createWatcher', $ticket) }}">
                    @csrf

                    <div class="form-group">
                        <label>{{ __('User') }}</label>
                        <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5"}' name="user_id" id="user_id">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
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
