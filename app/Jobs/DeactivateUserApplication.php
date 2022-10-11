<?php

namespace App\Jobs;

use App\Models\ApplicationUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeactivateUserApplication implements ShouldQueue
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
     * The Direct Type
     *
     * @var $direct
     */
    protected $direct;

    /*
     * The Application User
     *
     * @var $applicationUser
     */
    protected $applicationUser;

    /**
     * Create a new job instance.
     *
     * @param ApplicationUser $applicationUser
     * @param bool            $direct
     *
     * @return void
     */
    public function __construct(ApplicationUser $applicationUser, bool $direct)
    {
        $this->direct = $direct;
        $this->applicationUser = $applicationUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->direct == ApplicationUser::NOT_DIRECT) {
            $this->applicationUser->update([
                'active' => ApplicationUser::NOT_ACTIVE,
            ]);
        } else {
            $this->applicationUser->update([
                'direct' => ApplicationUser::NOT_DIRECT,
            ]);

            SyncUserApplications::dispatch($this->applicationUser->user);
        }
    }
}
