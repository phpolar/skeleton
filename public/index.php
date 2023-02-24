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

use Phpolar\Phpolar\Routing\RouteRegistry;
use Phpolar\Phpolar\WebServer\ContainerFactory;
use Phpolar\Phpolar\WebServer\WebServer;

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
$containerFactory = new ContainerFactory(
  static fn (\ArrayAccess $containerConf) => new \Pimple\Psr11\Container($containerConf)
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
$request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
  $_SERVER,
  $_GET,
  $_POST,
  $_COOKIE,
);
$person = new Person($request->getParsedBody());

/**
 * ==========================================================
 * Set up request handlers
 * ==========================================================
 *
 * PHPolar uses type-safe PSR-15 request handlers
 * instead of Closures.
 */
$getPersonForm = new GetPersonForm($person);
$submitPersonForm = new SubmitPersonForm($person);

/**
 * ==========================================================
 * Set up routes
 * ==========================================================
 */
$routes = new RouteRegistry();
$routes->addGet("/", new GetPeople());
$routes->addGet("/person/form", $getPersonForm);
$routes->addPost("/person/add", $person->isValid() === true ? $submitPersonForm : new GetPersonForm($person, true));

/**
 * ==========================================================
 * Configure the web server
 * ==========================================================
 */
$app = WebServer::createApp($containerFactory, $dependencyMap);
$app->useRoutes($routes);
// $app->useCsrfMiddleware();
$app->receive($request);
