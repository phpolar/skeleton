<?php

declare(strict_types=1);

/**
 * ==========================================================
 * An application using the PHPolar Microframework
 * ==========================================================
 *
 * See `src/config/dependencies/conf.d/`.
 */

namespace Phpolar\Example;

use Phpolar\Phpolar\App;
use Phpolar\Phpolar\DependencyInjection\ClosureContainerFactory;
use Phpolar\Phpolar\DependencyInjection\ContainerManager;
use Phpolar\Phpolar\Routing\RouteRegistry;

ini_set("display_errors", true);
chdir("../");

require "vendor/autoload.php";

/**
 * ==========================================================
 * Storage and templating is already set up
 * ==========================================================
 *
 * See `src/config/dependencies/conf.d/`.
 */

/**
 * ==========================================================
 * Set up dependency injection
 * ==========================================================
 *
 * Use any PSR-11 container you like.
 * Just `composer install <the-container>`,
 * then replace the configuration in
 * `src/config/dependencies/conf.d/container.php`.
 * Finally, use or change the factory below.
 */
$dependencyMap = new \Pimple\Container();
$containerManager = new ContainerManager(
    new ClosureContainerFactory(
        static fn (): \Pimple\Psr11\Container => new \Pimple\Psr11\Container($dependencyMap)
    ),
    $dependencyMap,
);

/**
 * ==========================================================
 * Get the request
 * ==========================================================
 *
 * Use any PSR-15 request factory you like.
 * Just `composer install <some-psr-15-factory>`,
 * then replace the configuration in
 * `src/config/dependencies/conf.d/http.php`
 */

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();


/**
 * ==========================================================
 * Set up routes
 * ==========================================================
 *
 * PHPolar uses type-safe PSR-15 request handlers
 * instead of Closures.
 */
$routes = new RouteRegistry();
$routes->add("GET", "/", new GetPeople());
$routes->add("GET", "/person/form", new GetPersonForm());
$routes->add("POST", "/person/add", new SubmitPersonForm());
$routes->add("POST", "/person/delete/{id}", new DeletePerson());

// /**
//  * ==========================================================
//  * Configure the web application
//  * ==========================================================
//  */
$app = App::create($containerManager);
$app->useRoutes($routes);
// $app->useCsrfMiddleware();
$app->receive($serverRequest);
