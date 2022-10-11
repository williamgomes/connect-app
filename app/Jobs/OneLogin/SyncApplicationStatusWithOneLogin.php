<?php

namespace App\Jobs\OneLogin;

use App\Environment;
use App\Helpers\OneLoginHelper;
use App\Models\ApplicationUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncApplicationStatusWithOneLogin implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /*
     * The Application User
     *
     * @var $applicationUser
     */
    protected $applicationUser;

    /*
     * The Initial Application User Status
     *
     * @var $initialApplicationUserStatus
     */
    protected $initialApplicationUserStatus;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ApplicationUser $applicationUser, $initialApplicationUserStatus = null)
    {
        $this->applicationUser = $applicationUser;
        $this->initialApplicationUserStatus = $initialApplicationUserStatus;
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

        // Skip already provisioned applications
        if ($this->applicationUser->active === $this->initialApplicationUserStatus) {
            return;
        }

        $directory = $this->applicationUser->application->directory;

        // Create and assign the OneLogin Role
        $oneLoginClient = new OneLoginHelper();
        $token = $oneLoginClient->generateToken($directory);

        $url = $directory->onelogin_api_url . '/api/2/roles/' . $this->applicationUser->application->onelogin_role_id . '/users';

        if ($this->applicationUser->active) {
            $response = Http::log()->withToken($token)->post($url, [$this->applicationUser->user->onelogin_id]);
        } else {
            $response = Http::log()->withToken($token)->delete($url, [$this->applicationUser->user->onelogin_id]);
        }

        // Revoke token as it's not needed anymore
        $oneLoginClient->revokeToken($directory, $token);

        // Throw an exception if a client or server error occur
        $response->throw();
    }
}
