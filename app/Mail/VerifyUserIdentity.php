<?php

namespace App\Mail;

use App\Models\UserVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyUserIdentity extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * The user verification instance.
     *
     * @var userVerification
     */
    public $userVerification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserVerification $userVerification)
    {
        $this->userVerification = $userVerification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Verify your identity'))
                ->view('emails.users.verify')
                ->text('emails.users.verify_plain');
    }
}
