<?php

declare(strict_types=1);

/**
 *
 * An application using the PHPolar Microframework
 * ==========================================================
 *
 * See `src/config/dependencies/conf.d/`.
 */

namespace Phpolar\Example;

use PhpCommonEnums\MimeType\Enumeration\MimeTypeEnum as MimeType;
use Phpolar\Phpolar\App;
use Phpolar\Phpolar\DependencyInjection\ContainerLoader;
use Psr\Http\Message\ServerRequestInterface;

ini_set("display_errors", true);
chdir("../");

require "vendor/autoload.php";

/**
 *
 * Set up dependency injection
 * ==========================================================
 *
 * Use any PSR-11 container you like.
 * Just `composer require <the-container-implementation>`.
 * Then, return an instance of the PSR-11 container
 * implementation in the factory function below.
 */
$dependencyMap = new \Pimple\Container();
$psr11Container = new \Pimple\Psr11\Container($dependencyMap);
/**
 *
 * Get the request
 * ==========================================================
 *
 * Use any PSR-17 request factory you like.
 * Just `composer require <some-psr-17-factory>`,
 * then replace the configuration in
 * `src/config/dependencies/conf.d/http.php`
 */

$serverRequest = (new \Nyholm\Psr7Server\ServerRequestCreator(
    ...array_fill(0, 4, new \Nyholm\Psr7\Factory\Psr17Factory()),
))->fromGlobals()
    ->withHeader("Accept", [MimeType::TextHtml->value]);

$dependencyMap[ServerRequestInterface::class] = $serverRequest;

(new ContainerLoader())->load($psr11Container, $dependencyMap);
/**
 *
 * Configure the web application
 * ==========================================================
 */
$app = App::create($psr11Container);
// $app->useCsrfMiddleware();
$app->receive($serverRequest);
