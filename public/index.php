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
use Psr\Container\ContainerInterface;

ini_set("display_errors", true);
chdir("../");

require "vendor/autoload.php";

/**
 * ==========================================================
 * Set up dependency injection
 * ==========================================================
 *
 * Use any PSR-11 container you like.
 * Just `composer require <the-container-implementation>`.
 * Then, return an instance of the PSR-11 container
 * implementation in the factory function below.
 */
$dependencyMap = new \Pimple\Container();
$containerManager = new ContainerManager(
    new ClosureContainerFactory(
        static fn (): ContainerInterface => new \Pimple\Psr11\Container($dependencyMap)
    ),
    $dependencyMap,
);

/**
 * ==========================================================
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
))->fromGlobals();


/**
 * ==========================================================
 * Set up routes
 * ==========================================================
 *
 * PHPolar route handlers must implement `AbstractContentDelegate`
 */
$routes = new RouteRegistry();
$routes->add("GET", "/", new GetPeople());
$routes->add("GET", "/person/form", new GetPersonForm());
$routes->add("POST", "/person/add", new SubmitPersonForm());
$routes->add("POST", "/person/delete/{id}", new DeletePerson());

/**
 * ==========================================================
 * Configure the web application
 * ==========================================================
 */
$app = App::create($containerManager);
$app->useRoutes($routes);
// $app->useCsrfMiddleware();
$app->receive($serverRequest);
