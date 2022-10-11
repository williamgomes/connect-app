<?php

namespace App\Jobs\OneLogin;

use App\Environment;
use App\Helpers\OneLoginHelper;
use App\Models\Directory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class DeleteUserInOneLogin implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /*
     * The Directory
     *
     * @var $directory
     */
    protected $directory;

    /*
     * The unique Identifier of the user in OneLogin
     */
    protected $oneloginId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Directory $directory, $oneloginId)
    {
        $this->directory = $directory;
        $this->oneloginId = $oneloginId;
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

        // Create the OneLogin Client & Token
        $oneLoginClient = new OneLoginHelper();
        $token = $oneLoginClient->generateToken($this->directory);

        // Delete the user in OneLogin
        $response = Http::log()->withToken($token)->delete($this->directory->onelogin_api_url . '/api/2/users/' . $this->oneloginId);

        // Throw an exception if a client or server error occur
        $response->throw();

        // Revoke token as it's not needed anymore
        $oneLoginClient->revokeToken($this->directory, $token);
    }
}
