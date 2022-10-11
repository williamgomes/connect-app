<div id="select-network-modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Select Network') }}</h4>
                <button type="button" class="close pt-4" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="GET" action="{{ action('App\InventoryController@createIpAddress', $inventory) }}">
                    @csrf

                    <div class="form-group">
                        <label>{{ __('Network') }}</label>
                        <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5"}' name="network_id" id="network_id">
                            @foreach($networks as $network)
                                <option value="{{ $network->id }}">{{ $network->ip_address }}/{{ $network->cidr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit">{{ __('Continue') }}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
