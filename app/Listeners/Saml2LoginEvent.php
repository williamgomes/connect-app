<?php

namespace App\Listeners;

use App\Models\Saml2LoginLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Saml2LoginEvent
{
    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        $messageId = $event->getSaml2Auth()->getLastMessageId();
        $existingLoginRecord = Saml2LoginLog::where('message_id', $messageId)->exists();
        if ($existingLoginRecord) {
            abort(403, 'Unauthorized');
        }

        // Get unique user identifier
        $synegaId = $event->getSaml2User()->getUserId();

        // Find user based on Synega ID
        $user = User::where('synega_id', '=', $synegaId)->first();

        // Set authentication status
        if ($user && $user->active == User::IS_ACTIVE) {
            $authenticated = true;
        } else {
            $authenticated = false;
        }

        // Log the SAML2 Login
        Saml2LoginLog::create([
            'message_id' => $messageId,
            'identifier' => $synegaId,
            'success'    => $authenticated,
        ]);

        // Authenticate user or abort
        if ($authenticated) {
            Auth::login($user);
        } else {
            abort(403, 'Unauthorized');
        }
    }
}
