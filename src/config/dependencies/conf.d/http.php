<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

return array_combine([
    RequestFactoryInterface::class,
    ResponseFactoryInterface::class,
    StreamFactoryInterface::class,
], array_fill(0, 3, $psr17Factory));
