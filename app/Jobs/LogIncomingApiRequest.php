<?php

namespace App\Jobs;

use App\Models\ApiHttpLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogIncomingApiRequest implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The request body.
     *
     * @var
     */
    protected $request;

    /**
     * The response body.
     *
     * @var
     */
    protected $response;

    /**
     * The response code.
     *
     * @var
     */
    protected $responseCode;

    /**
     * The request method.
     *
     * @var
     */
    protected $method;

    /**
     * The request ip.
     *
     * @var
     */
    protected $ip;

    /**
     * The uuid.
     *
     * @var string
     */
    protected $uuid;

    /**
     * The request endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The application token of the request.
     *
     * @var int
     */
    protected $applicationTokenId;

    /**
     * The elapsed time.
     *
     * @var int
     */
    protected $elapsed;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $response, string $uuid, int $applicationTokenId = null, float $elapsed)
    {
        $this->request = (string) $request;
        $this->response = (string) $response;
        $this->responseCode = $response->status();
        $this->method = $request->method();
        $this->ip = $request->ip();
        $this->endpoint = $request->fullUrl();
        $this->uuid = $uuid;
        $this->applicationTokenId = $applicationTokenId;
        $this->elapsed = $elapsed;
        $this->onQueue('logging');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ApiHttpLog::create([
            'uuid'                 => $this->uuid,
            'type'                 => ApiHttpLog::INCOMING,
            'ip'                   => $this->ip,
            'http_method'          => $this->method,
            'endpoint'             => $this->endpoint,
            'request'              => empty($this->request) ? null : $this->request,
            'response'             => empty($this->response) ? null : $this->response,
            'response_code'        => $this->responseCode,
            'application_token_id' => $this->applicationTokenId,
            'response_time'        => (int) (1000 * $this->elapsed),
        ]);
    }
}
