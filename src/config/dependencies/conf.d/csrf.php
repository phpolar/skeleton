<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use ArrayAccess;
use Phpolar\CsrfProtection\Http\CsrfPostRoutingMiddlewareFactory;
use Phpolar\CsrfProtection\Http\CsrfPreRoutingMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

return [
    CsrfPreRoutingMiddleware::class => static fn (ArrayAccess $conf) =>
        new CsrfPreRoutingMiddleware(
            $conf[ResponseFactoryInterface::class],
            $conf[StreamFactoryInterface::class]
        ),
    CsrfPostRoutingMiddlewareFactory::class => static fn (ArrayAccess $conf) =>
        new CsrfPostRoutingMiddlewareFactory(
            $conf[ResponseFactoryInterface::class],
            $conf[StreamFactoryInterface::class]
        ),
];
