<?php

namespace App\Mail;

use App\Models\DirectoryUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * The User instance.
     *
     * @var User
     */
    public $user;

    /**
     * The Directory instance.
     *
     * @var Directory
     */
    public $directory;

    /**
     * The password instance.
     *
     * @var password
     */
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DirectoryUser $directoryUser, string $password)
    {
        $this->user = $directoryUser->user;
        $this->directory = $directoryUser->directory;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to ' . $this->directory->name . '!')
                    ->view('emails.users.created')
                    ->text('emails.users.created_plain');
    }
}
