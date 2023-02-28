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
use Psr\Http\Message\ResponseFactoryInterface;

use const Phpolar\CsrfProtection\REQUEST_ID_KEY;
use const Phpolar\CsrfProtection\TOKEN_DEFAULT_TTL;
use const Phpolar\CsrfProtection\TOKEN_MAX;

return [
    "csrf_token_ttl" => TOKEN_DEFAULT_TTL,
    "request_id_key" => REQUEST_ID_KEY,
    "session_vars" => [],
    "max_storerd_token_count" => TOKEN_MAX,
    CsrfRequestCheckMiddleware::class => static fn (ArrayAccess $conf) =>
    new CsrfRequestCheckMiddleware(
        $conf[CsrfProtectionRequestHandler::class],
    ),
    CsrfResponseFilterMiddleware::class => static fn (ArrayAccess $conf) =>
    new CsrfResponseFilterMiddleware(
        $conf[AbstractTokenStorage::class],
        $conf[CsrfTokenGenerator::class],
        $conf[ResponseFilterStrategyInterface::class],
    ),
    CsrfProtectionRequestHandler::class => static fn (ArrayAccess $conf) =>
    new CsrfProtectionRequestHandler(
        $conf[ResponseFactoryInterface::class],
        $conf[AbstractTokenStorage::class],
    ),
    AbstractTokenStorage::class => static fn (ArrayAccess $conf) =>
    new SessionTokenStorage(
        $conf["session_vars"],
        $conf["request_id_key"],
        $conf["max_stored_token_count"],
    ),
    CsrfTokenGenerator::class => static fn (ArrayAccess $conf) => new CsrfTokenGenerator($conf["csrf_token_ttl"]),
];
