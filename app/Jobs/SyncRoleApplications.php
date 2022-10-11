<?php

namespace App\Jobs;

use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncRoleApplications implements ShouldQueue
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
     * The Role
     *
     * @var $role
     */
    protected $role;

    /**
     * Create a new job instance.
     *
     * @param Role $role
     *
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::select('users.*')
            ->join('role_user', 'role_user.user_id', 'users.id')
            ->where('role_user.role_id', $this->role->id)
            ->get();

        foreach ($users as $user) {
            SyncUserApplications::dispatch($user);
        }
    }
}
