<?php

/**
 * This file is part of the coolephp/rate-limiter.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

return [
    'id' => 'Coole',

    /*
     * [token_bucket, fixed_window, sliding_window, no_limit]
     */
    'policy' => 'token_bucket',

    'limit' => 60,

    'interval' => '1 minutes',

    /*
     * Only the policy is token_bucket.
     */
    'rate' => [
        'interval' => '1 minutes',
    ],

    /*
     * [InMemoryStorage, CacheStorage]
     */
    'storage' => CacheStorage::class,

    /*
     * ```
     * [
     *     ApcuAdapter,
     *     ArrayAdapter,
     *     ChainAdapter,
     *     CouchbaseBucketAdapter,
     *     DoctrineAdapter,
     *     FilesystemAdapter,
     *     FilesystemTagAwareAdapter,
     *     MemcachedAdapter,
     *     NullAdapter,
     *     PdoAdapter,
     *     PhpArrayAdapter,
     *     PhpFilesAdapter,
     *     ProxyAdapter,
     *     Psr16Adapter,
     *     RedisAdapter,
     *     RedisTagAwareAdapter,
     *     TagAwareAdapter,
     *     TraceableAdapter,
     *     TraceableTagAwareAdapter
     * ]
     * ```
     */
    'cache_adapter' => FilesystemAdapter::class,
];
