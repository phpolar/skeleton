<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Laminas\Diactoros\RequestFactory;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

return [
    RequestFactoryInterface::class => static fn () => new RequestFactory(),
    ResponseFactoryInterface::class => static fn () => new ResponseFactory,
    StreamFactoryInterface::class => static fn () => new StreamFactory(),
];