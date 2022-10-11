<?php

namespace App\Jobs\OneLogin;

use App\Environment;
use App\Helpers\OneLoginHelper;
use App\Models\DirectoryUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UpdateUserInOneLogin implements ShouldQueue
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

        // Create the OneLogin Client & Token
        $oneLoginClient = new OneLoginHelper();
        $token = $oneLoginClient->generateToken($directory);

        $directoryUser = DirectoryUser::where('directory_id', $directory->id)
            ->where('user_id', $user->id)
            ->first();

        // Create OneLogin User
        $response = Http::log()
            ->withToken($token)
            ->put($directory->onelogin_api_url . '/api/2/users/' . $directoryUser->onelogin_id, [
                'firstname'         => $user->first_name,
                'lastname'          => $user->last_name,
                'email'             => $user->email,
                'phone'             => $user->phone_number,
                'external_id'       => $user->uuid,
                'custom_attributes' => [
                    'email_username' => $directoryUser->username,
                ],
            ]);

        // Throw an exception if a client or server error occur
        $response->throw();

        // Revoke token as it's not needed anymore
        $oneLoginClient->revokeToken($directory, $token);
    }
}
