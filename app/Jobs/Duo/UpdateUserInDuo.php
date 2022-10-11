<?php

namespace App\Jobs\Duo;

use App\Environment;
use App\Helpers\DuoSecurity;
use App\Models\DirectoryUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserInDuo implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /*
     * The DirectoryUser
     *
     * @var $directoryUser
     */
    protected $directoryUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DirectoryUser $directoryUser)
    {
        $this->directoryUser = $directoryUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!Environment::shouldExecute()) {
            return;
        }

        $user = $this->directoryUser->user;
        $directory = $this->directoryUser->directory;

        // Create the DUO Client
        $duoClient = new DuoSecurity\Client(
            $directory->duo_integration_key,
            $directory->duo_secret_key,
            $directory->duo_api_url,
        );

        $response = $duoClient->jsonApiCall('POST', '/admin/v1/users/' . $this->directoryUser->duo_id, [
            'email'    => $user->email,
            'realname' => $user->name,
        ]);
    }
}
