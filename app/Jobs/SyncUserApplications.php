<?php

namespace App\Jobs;

use App\Models\Application;
use App\Models\ApplicationUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncUserApplications implements ShouldQueue
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

    /**
     * Create a new job instance.
     *
     * @param User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // All applications user has access to via roles
        $applications = Application::select('applications.*')
            ->join('application_role', 'application_role.application_id', 'applications.id')
            ->join('role_user', 'role_user.role_id', 'application_role.role_id')
            ->where('role_user.user_id', $this->user->id)
            ->groupBy('applications.id')
            ->get();

        // Activate applications
        foreach ($applications as $application) {
            ActivateUserApplication::dispatch($application, $this->user, ApplicationUser::NOT_DIRECT);
        }

        $applicationToDeactivate = ApplicationUser::where('application_user.user_id', $this->user->id)
            ->where('application_user.active', ApplicationUser::IS_ACTIVE)
            ->where('application_user.direct', ApplicationUser::NOT_DIRECT)
            ->whereNotIn('application_user.application_id', $applications->pluck('id'))
            ->get();

        // Deactivate applications
        foreach ($applicationToDeactivate as $applicationUser) {
            DeactivateUserApplication::dispatch($applicationUser, ApplicationUser::NOT_DIRECT);
        }
    }
}
