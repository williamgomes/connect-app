<?php

namespace App\Jobs;

use App\Helpers\PasswordHelper;
use App\Models\Application;
use App\Models\ApplicationUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ActivateUserApplication implements ShouldQueue
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
     * The User
     *
     * @var $user
     */
    protected $user;

    /*
     * The Direct Type
     *
     * @var $direct
     */
    protected $direct;

    /*
     * The Application
     *
     * @var $application
     */
    protected $application;

    /**
     * Create a new job instance.
     *
     * @param Application $application
     * @param User        $user
     * @param bool        $direct
     *
     * @return void
     */
    public function __construct(Application $application, User $user, bool $direct)
    {
        $this->user = $user;
        $this->direct = $direct;
        $this->application = $application;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Try to find existing Application User
        $applicationUser = ApplicationUser::where('application_id', $this->application->id)
            ->where('user_id', $this->user->id)
            ->first();

        if ($applicationUser) {
            if ($applicationUser->active == ApplicationUser::NOT_ACTIVE) {
                $applicationUser->update([
                    'active'      => ApplicationUser::IS_ACTIVE,
                    'direct'      => $this->direct,
                    'provisioned' => ApplicationUser::NOT_PROVISIONED,
                ]);
            } elseif ($this->direct == ApplicationUser::IS_DIRECT) {
                $applicationUser->update([
                    'direct' => ApplicationUser::IS_DIRECT,
                ]);
            }
        } else {
            ApplicationUser::create([
                'application_id' => $this->application->id,
                'user_id'        => $this->user->id,
                'active'         => ApplicationUser::IS_ACTIVE,
                'provisioned'    => $this->application->provisioning,
                'direct'         => $this->direct,
                'password'       => is_null($this->application->sso) ? null : PasswordHelper::generate(20, [
                    'upper_case',
                    'lower_case',
                    'numbers',
                    'special_symbols',
                ]),
            ]);
        }
    }
}
