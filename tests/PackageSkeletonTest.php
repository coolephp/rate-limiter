<?php

/**
 * This file is part of the coolephp/rate-limiter.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Coole\RateLimiter\Tests;

use Coole\RateLimiter\PackageSkeleton;

class PackageSkeletonTest extends TestCase
{
    public function testTest()
    {
        $this->assertTrue(PackageSkeleton::test());
    }
}
