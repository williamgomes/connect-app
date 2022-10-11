<?php

namespace App\Http\Middleware;

use App\Feature;
use App\Jobs\LogOutgoingApiRequest as LogOutgoingApiRequestJob;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogOutgoingApiRequest
{
    public function __invoke(string $uuid, $expiresAt = null): callable
    {
        return function (callable $handler) use ($uuid, $expiresAt): callable {
            return function (RequestInterface $request, array $options) use ($handler, $uuid, $expiresAt): PromiseInterface {
                $start = microtime(true);

                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($request, $start, $uuid, $expiresAt) {
                        $elapsed = microtime(true) - $start;

//                        if (Feature::accessible('api-http-log')) {
                        LogOutgoingApiRequestJob::dispatch($request, $response, $uuid, $elapsed, $expiresAt);
//                        }

                        return $response;
                    }
                );
            };
        };
    }
}
