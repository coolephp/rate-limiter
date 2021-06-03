<?php

/**
 * This file is part of the coolephp/rate-limiter.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Coole\RateLimiter;

use Closure;
use Guanguans\Coole\Facade\App;
use Guanguans\Coole\Middleware\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Throwable;

class RateLimiter implements MiddlewareInterface
{
    protected $rateLimiterFactory;

    public function __construct()
    {
        $this->init();

        $config = App::make('config')['rate-limiter'];

        try {
            $storage = new $config['storage']();
        } catch (Throwable $e) {
            $cache = new $config['cache_adapter']();

            $storage = new $config['storage']($cache);
        }

        $this->rateLimiterFactory = new RateLimiterFactory([
            'id' => $config['id'],
            'policy' => $config['policy'],
            'limit' => $config['limit'],
            'rate' => $config['rate'],
        ], $storage);
    }

    protected function init()
    {
        App::addConfig(require __DIR__.'/../config/rate-limiter.php');
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, Closure $next)
    {
        $limiter = $this->rateLimiterFactory->create($request->getClientIp());
        $limit = $limiter->consume();

        $headers = [
            'X-RateLimit-Remaining' => $limit->getRemainingTokens(),
            'X-RateLimit-Retry-After' => $limit->getRetryAfter()->getTimestamp(),
            'X-RateLimit-Limit' => $limit->getLimit(),
        ];

        if (false === $limit->isAccepted()) {
            throw new TooManyRequestsHttpException($limit->getRetryAfter()->getTimestamp(), 'Too Many Attempts.', null, Response::HTTP_TOO_MANY_REQUESTS, $headers);
        }

        $response = $next($request);
        $response->headers->add($headers);

        return $response;
    }
}
