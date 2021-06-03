# rate-limiter

[简体中文](README-CN.md) | [ENGLISH](README.md)

> Provides a Token Bucket implementation to rate limit input and output in your Coole application. - 提供令牌桶实现来限制 Coole 应用程序中的输入和输出。

[![Tests](https://github.com/coolephp/rate-limiter/workflows/Tests/badge.svg)](https://github.com/coolephp/rate-limiter/actions)
[![Check & fix styling](https://github.com/coolephp/rate-limiter/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/coolephp/rate-limiter/actions)
[![codecov](https://codecov.io/gh/coolephp/rate-limiter/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/coolephp/rate-limiter)
[![Latest Stable Version](https://poser.pugx.org/coolephp/rate-limiter/v)](//packagist.org/packages/coolephp/rate-limiter)
[![Total Downloads](https://poser.pugx.org/coolephp/rate-limiter/downloads)](//packagist.org/packages/coolephp/rate-limiter)
[![License](https://poser.pugx.org/coolephp/rate-limiter/license)](//packagist.org/packages/coolephp/rate-limiter)

## 环境要求

* PHP >= 7.2

## 安装

``` bash
$ composer require coolephp/rate-limiter --prefer-dist -vvv
```

## 使用

1. 复制 `rate-limiter/config/rate-limiter.php` 为 `coole-skeleton/config/rate-limiter.php`.
2. 配置 `\Coole\RateLimiter\RateLimiter::class` 中间件.

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

## 测试

``` bash
$ composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证（MIT）。有关更多信息，请参见[协议文件](LICENSE)。
