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

class SendDuoEnrollmentEmail implements ShouldQueue
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

        $duoClient = new DuoSecurity\Client(
            $directory->duo_integration_key,
            $directory->duo_secret_key,
            $directory->duo_api_url,
        );

        $duoClient->jsonApiCall('POST', '/admin/v1/users/enroll', [
            'username'   => $user->synega_id,
            'email'      => $user->email,
            'valid_secs' => 172800, // 48 hours
        ]);
    }
}
