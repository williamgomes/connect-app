<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class NotifyUserOnSlack implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /*
     * The user who should get notification
     *
     * @var $user
     */
    protected $user;

    /*
     * The Message Data
     *
     * @var $data
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Abort if the user does not have Slack set-up
        if (is_null($this->user->slack_webhook_url)) {
            return;
        }

        $response = Http::log()->retry(3, 3000) // 3 retries, 3 seconds
            ->post($this->user->slack_webhook_url, $this->data);

        // Throw an exception if a client or server error occurred...
        $response->throw();
    }
}
