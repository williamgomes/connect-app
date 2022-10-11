<?php

namespace App\Jobs\OneLogin;

use App\Environment;
use App\Helpers\OneLoginHelper;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CreateOneLoginRole implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /*
     * The Application
     *
     * @var $application
     */
    protected $application;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
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

        $directory = $this->application->directory;

        // Create and assign the OneLogin Role
        $oneLoginClient = new OneLoginHelper();
        $token = $oneLoginClient->generateToken($directory);

        // Create OneLogin Role
        $response = Http::log()
            ->withToken($token)
            ->post($directory->onelogin_api_url . '/api/2/roles', [
                'name' => 'Connect - #' . $this->application->id,
                'apps' => [$this->application->onelogin_app_id],
            ]);

        // Revoke token as it's not needed anymore
        $oneLoginClient->revokeToken($directory, $token);

        // Throw an exception if a client or server error occur
        $response->throw();

        $this->application->update([
            'onelogin_role_id' => $response['id'],
        ]);
    }
}
