<?php

namespace App\Jobs\OneLogin;

use App\Environment;
use App\Helpers\OneLoginHelper;
use App\Helpers\PasswordHelper;
use App\Mail\UserCreated;
use App\Models\DirectoryUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUserInOneLogin implements ShouldQueue
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
     * @throws \Illuminate\Http\Client\RequestException
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

        // Set a random 12 character password
        $password = PasswordHelper::generate(12, [
            'lower_case',
            'upper_case',
            'numbers',
            'special_symbols',
        ]);

        // Set password with salt
        $salt = Str::random(10);
        $hashedPassword = hash('sha256', $salt . $password);

        $directoryUser = DirectoryUser::where('directory_id', $directory->id)
            ->where('user_id', $user->id)
            ->first();

        // Create OneLogin User
        $response = Http::log()
            ->withToken($token)
            ->post($directory->onelogin_api_url . '/api/2/users', [
                'state'                 => 1, // Approved
                'status'                => 4, // Require new password
                'firstname'             => $user->first_name,
                'lastname'              => $user->last_name,
                'email'                 => $user->email,
                'phone'                 => $user->phone_number,
                'username'              => strval($user->synega_id),
                'external_id'           => $user->uuid,
                'password'              => $hashedPassword,
                'password_confirmation' => $hashedPassword,
                'password_algorithm'    => 'salt+sha256',
                'salt'                  => $salt,
                'comment'               => 'Automatically provisioned by Connect.',
                'role_ids'              => [$directory->onelogin_default_role],
                'custom_attributes'     => [
                    'email_username' => $directoryUser->username,
                ],
            ]);

        // Throw an exception if a client or server error occur
        $response->throw();

        // Add OneLogin id to the Directory User relation record
        $directoryUser->update([
            'onelogin_id' => $response['id'],
        ]);

        // Send login information to the new user
        Mail::to($user->email)->send(new UserCreated($directoryUser, $password));

        // Revoke token as it's not needed anymore
        $oneLoginClient->revokeToken($directory, $token);
    }
}
