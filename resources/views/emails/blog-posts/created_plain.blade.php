{{ __('Hi') }} {{ $user->name }}.

{{ __('A new blog post has been added to Synega Connect.') }}
{{ __('Click on this URL to view the blog post:') }}
{{ action('Web\BlogController@show', $blogPost) }}

{{ __("You can't reply to this email.") }}

{{ __('Best regards, The Synega Connect Team.')}}

{{ __('Unsubscribe from this notification') }}
{{ action('UserController@unsubscribeBlogFromHash', encrypt($user->id)) }}
