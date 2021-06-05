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
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Throwable;
use Tightenco\Collect\Support\Collection;

class RateLimiter implements MiddlewareInterface
{
    /**
     * @var Collection
     */
    protected $config;

    /**
     * @var \Symfony\Component\RateLimiter\RateLimiterFactory
     */
    protected $rateLimiterFactory;

    public function __construct()
    {
        $this->initConfig();
        $this->config = app('config')['rate-limiter'];
        $this->rateLimiterFactory = $this->buildRateLimiterFactory($this->config);
    }

    protected function initConfig()
    {
        $initConfig = require __DIR__.'/../config/rate-limiter.php';

        App::addConfig(['rate-limiter' => $initConfig]);
    }

    protected function buildRateLimiterFactory(Collection $config): RateLimiterFactory
    {
        try {
            $storage = new $config['storage']();
        } catch (Throwable $e) {
            $cache = new $config['cache_adapter']();

            $storage = new $config['storage']($cache);
        }

        $options = $config
            ->filter(function ($val, $key) {
                return ! in_array($key, ['paths', 'storage', 'cache_adapter']);
            })
            ->toArray();

        return new RateLimiterFactory($options, $storage);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $this->shouldRun($request)) {
            return $next($request);
        }

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

    public function getRateLimiterFactory(): RateLimiterFactory
    {
        return $this->rateLimiterFactory;
    }

    protected function shouldRun(Request $request): bool
    {
        return $this->isMatchingPath($request);
    }

    protected function isMatchingPath(Request $request): bool
    {
        $paths = $this->getPathsByHost($request->getHost());

        foreach ($paths as $path) {
            if ('/' !== $path) {
                $path = trim($path, '/');
            }

            $url = trim($request->getRequestUri(), '/');
            if (Str::is($path, $url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array|mixed
     */
    protected function getPathsByHost(string $host)
    {
        $paths = $this->config->get('paths', []);
        if (isset($paths[$host])) {
            return $paths[$host];
        }

        return array_filter($paths, function ($path) {
            return is_string($path);
        });
    }
}
