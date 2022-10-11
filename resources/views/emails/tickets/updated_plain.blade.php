{{ __('Hi') }} {{ $user->name }}.

{{ __('A ticket has been updated:') }} {{ $ticket->title }} (#{{ $ticket->id}}).

{{ __('Click on this URL to view the comment:') }}
{{ action('Web\TicketController@show', $ticket) }}

{{ __("You can't reply to this email.") }}

{{ __('Best regards, The Synega Connect Team.')}}
