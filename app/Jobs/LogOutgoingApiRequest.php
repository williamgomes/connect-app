<?php

namespace App\Jobs;

use App\Models\ApiHttpLog;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogOutgoingApiRequest implements ShouldQueue
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

    protected $request;
    protected $response;
    protected $responseCode;
    protected $method;
    protected $uuid;
    protected $endpoint;
    protected $elapsed;
    protected $expiresAt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RequestInterface $request, ResponseInterface $response, string $uuid, float $elapsed, Carbon $expiresAt = null)
    {
        $this->request = Message::toString($request);
        $this->response = Message::toString($response);
        $this->responseCode = $response->getStatusCode();
        $this->method = $request->getMethod();
        $this->uuid = $uuid;
        $this->endpoint = (string) $request->getUri();
        $this->elapsed = $elapsed;
        $this->expiresAt = $expiresAt;
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
            'uuid'          => $this->uuid,
            'type'          => ApiHttpLog::OUTGOING,
            'http_method'   => $this->method,
            'ip'            => gethostbyname(parse_url($this->endpoint, PHP_URL_HOST)) ?? null,
            'endpoint'      => $this->endpoint,
            'request'       => $this->request,
            'response'      => $this->response,
            'response_code' => $this->responseCode,
            'response_time' => (int) (1000 * $this->elapsed),
            'expires_at'    => $this->expiresAt,
        ]);
    }
}
