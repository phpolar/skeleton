<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use ArrayAccess;
use Phpolar\CsrfProtection\CsrfTokenGenerator;
use Phpolar\CsrfProtection\Http\CsrfProtectionRequestHandler;
use Phpolar\CsrfProtection\Http\CsrfRequestCheckMiddleware;
use Phpolar\CsrfProtection\Http\CsrfResponseFilterMiddleware;
use Phpolar\CsrfProtection\Http\ResponseFilterStrategyInterface;
use Phpolar\CsrfProtection\Storage\AbstractTokenStorage;
use Phpolar\CsrfProtection\Storage\SessionTokenStorage;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

use const Phpolar\CsrfProtection\REQUEST_ID_KEY;
use const Phpolar\CsrfProtection\TOKEN_DEFAULT_TTL;
use const Phpolar\CsrfProtection\TOKEN_MAX;

return [
    "csrf_token_ttl" => TOKEN_DEFAULT_TTL,
    "request_id_key" => REQUEST_ID_KEY,
    "session_vars" => [],
    "max_storerd_token_count" => TOKEN_MAX,
    CsrfRequestCheckMiddleware::class => static fn (ContainerInterface $container) =>
    new CsrfRequestCheckMiddleware(
        $container->get(CsrfProtectionRequestHandler::class),
    ),
    CsrfResponseFilterMiddleware::class => static fn (ContainerInterface $container) =>
    new CsrfResponseFilterMiddleware(
        $container->get(AbstractTokenStorage::class),
        $container->get(CsrfTokenGenerator::class),
        $container->get(ResponseFilterStrategyInterface::class),
    ),
    CsrfProtectionRequestHandler::class => static fn (ContainerInterface $container) =>
    new CsrfProtectionRequestHandler(
        $container->get(ResponseFactoryInterface::class),
        $container->get(AbstractTokenStorage::class),
    ),
    AbstractTokenStorage::class => static fn (ContainerInterface $container) =>
    new SessionTokenStorage(
        $container->get("session_vars"),
        $container->get("request_id_key"),
        $container->get("max_stored_token_count"),
    ),
    CsrfTokenGenerator::class => static fn (ContainerInterface $container) => new CsrfTokenGenerator($container->get("csrf_token_ttl")),
];
