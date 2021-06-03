# rate-limiter

[简体中文](README-CN.md) | [ENGLISH](README.md)

> Provides a Token Bucket implementation to rate limit input and output in your Coole application. - 提供令牌桶实现来限制 Coole 应用程序中的输入和输出。

[![Tests](https://github.com/coolephp/rate-limiter/workflows/Tests/badge.svg)](https://github.com/coolephp/rate-limiter/actions)
[![Check & fix styling](https://github.com/coolephp/rate-limiter/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/coolephp/rate-limiter/actions)
[![codecov](https://codecov.io/gh/coolephp/rate-limiter/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/coolephp/rate-limiter)
[![Latest Stable Version](https://poser.pugx.org/coolephp/rate-limiter/v)](//packagist.org/packages/coolephp/rate-limiter)
[![Total Downloads](https://poser.pugx.org/coolephp/rate-limiter/downloads)](//packagist.org/packages/coolephp/rate-limiter)
[![License](https://poser.pugx.org/coolephp/rate-limiter/license)](//packagist.org/packages/coolephp/rate-limiter)

## Requirement

* PHP >= 7.2

## Installation

``` bash
$ composer require coolephp/rate-limiter --prefer-dist -vvv
```

## Usage

1. Copy `rate-limiter/config/rate-limiter.php` to `coole-skeleton/config/rate-limiter.php`.
2. Config `\Coole\RateLimiter\RateLimiter::class` middleware.

``` php
<?php

return [
    /*
     * App 名称
     */
    'name' => env('APP_NAME', 'Coole'),

    /*
     * 全局中间件
     */
    'middleware' => [
        ...
        \Coole\RateLimiter\RateLimiter::class
        ...
    ],
];
```

## Testing

``` bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
