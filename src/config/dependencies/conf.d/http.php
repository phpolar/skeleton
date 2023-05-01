<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
return [
    RequestFactoryInterface::class => static fn () => $psr17Factory,
    ResponseFactoryInterface::class => static fn () => $psr17Factory,
    StreamFactoryInterface::class => static fn () => $psr17Factory,
];
