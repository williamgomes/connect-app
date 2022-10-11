<?php

namespace App\Jobs;

use App\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendSMS implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /*
     * Phone number of who should get the SMS
     *
     * @var $to
     */
    protected $to;

    /*
     * The SMS Body
     *
     * @var $body
     */
    protected $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $to, string $body)
    {
        $this->to = $to;
        $this->body = $body;
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

        if (strlen($this->body) > 160) {
            $this->body = substr($this->body, 0, 157) . '...';
        }

        $response = Http::log()->withToken(env('SWITCHBOARD_TOKEN'))
            ->retry(3, 3000) // 3 retries, 3 seconds
            ->post(env('SWITCHBOARD_URL') . '/api/v1/sms/send', [
                'to'   => $this->to,
                'body' => $this->body,
            ]);

        // Throw an exception if a client or server error occurred...
        $response->throw();
    }
}
