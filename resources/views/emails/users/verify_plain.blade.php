{{ __('Hi') }} {{ $userVerification->user->name }}.

{{ __('This email has been sent to you because you requested to verify you identity without using OneLogin. Please click the link below to continue the identification process.') }}

{{ __('Click on this URL to verify you identity:') }}
{{ action('UserVerificationController@complete', $userVerification->email_token) }}

{{ __("Didn't request this email? Please notify us via Synega Connect immediately to prevent unauthorized access to your account.")}}

{{ __("You can't reply to this email.") }}

{{ __('Best regards, The Synega Connect Team.')}}