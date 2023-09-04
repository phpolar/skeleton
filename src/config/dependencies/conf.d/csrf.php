<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use DateTimeImmutable;
use PhpContrib\Http\Message\ResponseFilterInterface;
use PhpContrib\Http\Message\ResponseFilterStrategyInterface;
use Phpolar\CsrfProtection\CsrfToken;
use Phpolar\CsrfProtection\Http\CsrfProtectionRequestHandler;
use Phpolar\CsrfProtection\Http\CsrfRequestCheckMiddleware;
use Phpolar\CsrfProtection\Http\CsrfResponseFilterMiddleware;
use Phpolar\CsrfProtection\Storage\AbstractTokenStorage;
use Phpolar\CsrfProtection\Storage\SessionTokenStorage;
use Phpolar\CsrfProtection\Storage\SessionWrapper;
use Phpolar\CsrfResponseFilter\Http\Message\CsrfResponseFilter;
use Phpolar\CsrfResponseFilter\Http\Message\ResponseFilterPatternStrategy;
use Phpolar\Phpolar\DependencyInjection\DiTokens;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Stringable;

use const Phpolar\CsrfProtection\REQUEST_ID_KEY;
use const Phpolar\CsrfProtection\TOKEN_DEFAULT_TTL;
use const Phpolar\CsrfProtection\TOKEN_MAX;

const CSRF_TOKEN_TTL = TOKEN_DEFAULT_TTL;
const REQUEST_ID = REQUEST_ID_KEY;
const MAX_STORED_TOKEN_COUNT = TOKEN_MAX;

return [
    "csrf_token" =>
    /**
     * Created on each request.
     *
     * Authentication will cause superfluous token creation.
     * Some dependency injection containers register dependencies
     * as singletons as long as a factory function is not used
     * to instantiate.  For that reason, we are not using a function
     * here.
     */
    new CsrfToken(
        new DateTimeImmutable("now"),
        CSRF_TOKEN_TTL,
    ),
    ResponseFilterStrategyInterface::class => static function (ContainerInterface $container) {
        /**
         * @var Stringable $token
         */
        $token = $container->get("csrf_token");
        return new ResponseFilterPatternStrategy(
            $token,
            $container->get(StreamFactoryInterface::class),
            REQUEST_ID,
        );
    },
    ResponseFilterInterface::class => static fn (ContainerInterface $container) => new CsrfResponseFilter($container->get(ResponseFilterStrategyInterface::class)),
    DiTokens::CSRF_CHECK_MIDDLEWARE => static fn (ContainerInterface $container) =>
    new CsrfRequestCheckMiddleware(
        $container->get(CsrfProtectionRequestHandler::class),
    ),
    DiTokens::CSRF_RESPONSE_FILTER_MIDDLEWARE => static fn (ContainerInterface $container) =>
    new CsrfResponseFilterMiddleware(
        $container->get(ResponseFilterInterface::class),
    ),
    CsrfProtectionRequestHandler::class => static fn (ContainerInterface $container) =>
    new CsrfProtectionRequestHandler(
        $container->get("csrf_token"),
        $container->get(AbstractTokenStorage::class),
        $container->get(ResponseFactoryInterface::class),
        REQUEST_ID,
    ),
    AbstractTokenStorage::class => static fn () =>
    new SessionTokenStorage(
        new SessionWrapper($_SESSION),
        REQUEST_ID,
        MAX_STORED_TOKEN_COUNT,
    ),
];
